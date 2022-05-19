<?php
class Item_Utility_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

    public function returnItemDetailsArr( $arrCondition = false) {
        $this->db->select('Menu_Base.*');
        $this->db->select('Menu_Category.CatName CatName, Menu_Category.CatSortNo CatSortNo, Menu_Category.CatDesc CatDesc');
        $this->db->select('Menu_Sub_Category.SubCatName SubCatName, Menu_Sub_Category.SubCatSortNo SubCatSortNo, Menu_Sub_Category.SubCatDesc SubCatDesc');

        $this->db->from('Menu_Base');
        $this->db->from('Menu_Category');
        $this->db->where('Menu_Base.FK_CatId = Menu_Category.PK_CatId');

        //  New Version
        $this->db->join('Menu_Sub_Category', 'Menu_Sub_Category.PK_SubCatId = Menu_Base.FK_SubCatId', 'left');

        //  Old Version
        //$this->db->from('Menu_Sub_Category');
        //$this->db->where('Menu_Base.FK_SubCatId = Menu_Sub_Category.PK_SubCatId');

        if( $arrCondition != false )
        {	$this->db->where($arrCondition);	}

        $this->db->order_by("CatSortNo, SubCatSortNo");

        $query = $this->db->get();

        if( $query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function returnItemDetailsBasedOnItemId( $ItemId, $arrCondition = false) {
        if ( isset($ItemId) && preg_match('/^[0-9]*$/', $ItemId)) {
            $this->db->select('Menu_Base.*');
            $this->db->select('Menu_Category.CatName CatName, Menu_Category.CatSortNo CatSortNo, Menu_Category.CatDesc CatDesc');
            $this->db->select('Menu_Sub_Category.SubCatName SubCatName, Menu_Sub_Category.SubCatSortNo SubCatSortNo, Menu_Sub_Category.SubCatDesc SubCatDesc');

            $this->db->from('Menu_Base');
            $this->db->from('Menu_Category');
            $this->db->where('Menu_Base.FK_CatId = Menu_Category.PK_CatId');

            //  New Version
            $this->db->join('Menu_Sub_Category', 'Menu_Sub_Category.PK_SubCatId = Menu_Base.FK_SubCatId', 'left');

            //  Old Version
            //$this->db->from('Menu_Sub_Category');
            //$this->db->where('Menu_Base.FK_SubCatId = Menu_Sub_Category.PK_SubCatId');

            $this->db->where('Menu_Base.PK_BaseId', $ItemId);

            if( $arrCondition != false )
            {	$this->db->where($arrCondition);	}

            $this->db->order_by("CatSortNo, SubCatSortNo");

            $query = $this->db->get();

            if( $query->num_rows() > 0 ) {
                return $query->row();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /*
     *	Return the Selection by category but if the Selections are already added to the item returns that Selection details
     */
    public function returnSelectionByCategoryArr( $arrCondition = false, $base_itm_id = false ) {
        $this->db->select('Menu_Selection.PK_SelecId, Menu_Selection.SelecName, Menu_Selection.SelecDefaultPrice, Menu_Selection.SelecDiscount, Menu_Selection.SelecStatus');
        $this->db->select('Menu_Selection_Category.PK_SelecCatId, Menu_Selection_Category.SelecCatName, Menu_Selection_Category.SelecCatSortNo');
        $this->db->select('Menu_Joint_Selections_To_Element.PK_J_SelecToElementID, Menu_Joint_Selections_To_Element.FK_ItemId,Menu_Joint_Selections_To_Element.J_SelecPrice');

        $this->db->from('Menu_Selection');
        $this->db->join('Menu_Joint_Selections_To_Element', 'Menu_Joint_Selections_To_Element.FK_SelecId = Menu_Selection.PK_SelecId AND Menu_Joint_Selections_To_Element.FK_ItemId='.$base_itm_id, 'left');

        $this->db->from('Menu_Selection_Category');
        $this->db->where('Menu_Selection_Category.PK_SelecCatId = Menu_Selection.FK_SelecCatId');


        if( $arrCondition != false )
        {	$this->db->where($arrCondition);	}

        $this->db->order_by('Menu_Selection_Category.SelecCatSortNo');
        $this->db->order_by('Menu_Selection.SelecSortNo');

        $query = $this->db->get();

        if( $query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return false;
        }
    }

    /*
     *	Return the toppings by category but if the toppings is already added to the item returns that topping details
     */
    public function returnToppingByCategoryArr( $arrCondition = false, $base_itm_id = false ) {
        $this->db->select('Menu_Topping.PK_ToppId, Menu_Topping.ToppName, Menu_Topping.ToppDefaultPrice, Menu_Topping.ToppDiscount, Menu_Topping.ToppStatus');
        $this->db->select('Menu_Topping_Category.PK_ToppCatId, Menu_Topping_Category.ToppCatName, Menu_Topping_Category.ToppCatSortNo');

        $this->db->select('Menu_Joint_Toppings_To_Element.PK_J_ToppintToElementID, Menu_Joint_Toppings_To_Element.FK_ItemId');
        $this->db->select('Menu_Joint_Toppings_To_Element.J_ToppPrice, Menu_Joint_Toppings_To_Element.J_ToppFreeFlag, Menu_Joint_Toppings_To_Element.J_ToppDefaultFlag');

        $this->db->from('Menu_Topping');
        $this->db->join('Menu_Joint_Toppings_To_Element', 'Menu_Joint_Toppings_To_Element.FK_ToppId = Menu_Topping.PK_ToppId AND Menu_Joint_Toppings_To_Element.FK_ItemId='.$base_itm_id, 'left');

        $this->db->from('Menu_Topping_Category');
        $this->db->where('Menu_Topping_Category.PK_ToppCatId = Menu_Topping.FK_ToppCatId');


        if( $arrCondition != false )
        {	$this->db->where($arrCondition);	}

        $this->db->order_by('Menu_Topping_Category.ToppCatSortNo');
        $this->db->order_by('Menu_Topping.ToppSortNo');

        $query = $this->db->get();

        if( $query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function returnAllAddedToppingByCategoryArr( $arrCondition = false ) {
        $this->db->select('Menu_Topping.PK_ToppId, Menu_Topping.ToppName, Menu_Topping.ToppDefaultPrice, Menu_Topping.ToppDiscount, Menu_Topping.ToppStatus');
        $this->db->select('Menu_Topping_Category.PK_ToppCatId, Menu_Topping_Category.ToppCatName, Menu_Topping_Category.ToppCatSortNo');

        $this->db->select('Menu_Joint_Toppings_To_Element.PK_J_ToppintToElementID, Menu_Joint_Toppings_To_Element.FK_ItemId');
        $this->db->select('Menu_Joint_Toppings_To_Element.J_ToppPrice, Menu_Joint_Toppings_To_Element.J_ToppFreeFlag, Menu_Joint_Toppings_To_Element.J_ToppDefaultFlag');

        $this->db->from('Menu_Joint_Toppings_To_Element');
        $this->db->from('Menu_Topping');
        $this->db->from('Menu_Topping_Category');

        $this->db->where('Menu_Joint_Toppings_To_Element.FK_ToppId = Menu_Topping.PK_ToppId');
        $this->db->where('Menu_Joint_Toppings_To_Element.FK_ToppCatId = Menu_Topping_Category.PK_ToppCatId');

        if( $arrCondition != false )
        {	$this->db->where($arrCondition);	}

        $this->db->order_by('Menu_Topping_Category.ToppCatSortNo');
        $this->db->order_by('Menu_Topping.ToppSortNo');

        $query = $this->db->get();

        if( $query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function returnAllAddedSelectionByCategoryArr( $arrCondition = false ) {
        $this->db->select('Menu_Selection.PK_SelecId, Menu_Selection.SelecName, Menu_Selection.SelecDefaultPrice, Menu_Selection.SelecDiscount, Menu_Selection.SelecStatus');
        $this->db->select('Menu_Selection_Category.PK_SelecCatId, Menu_Selection_Category.SelecCatName, Menu_Selection_Category.SelecCatSortNo');
        $this->db->select('Menu_Joint_Selections_To_Element.PK_J_SelecToElementID, Menu_Joint_Selections_To_Element.FK_ItemId, Menu_Joint_Selections_To_Element.J_SelecPrice');

        $this->db->select('Menu_Joint_Selection_To_Element_Summary.J_SelecShowOnMenuFlag');

        $this->db->from('Menu_Joint_Selection_To_Element_Summary');
        $this->db->from('Menu_Joint_Selections_To_Element');
        $this->db->from('Menu_Selection');
        $this->db->from('Menu_Selection_Category');

        $this->db->where('Menu_Joint_Selections_To_Element.FK_SelecId = Menu_Selection.PK_SelecId');
        $this->db->where('Menu_Joint_Selections_To_Element.FK_SelecCatId = Menu_Selection_Category.PK_SelecCatId');

        $this->db->where('Menu_Joint_Selections_To_Element.FK_ItemCatId = Menu_Joint_Selection_To_Element_Summary.FK_ItemCatId');
        $this->db->where('Menu_Joint_Selections_To_Element.FK_ItemSubCatId = Menu_Joint_Selection_To_Element_Summary.FK_ItemSubCatId');
        $this->db->where('Menu_Joint_Selections_To_Element.FK_ItemId = Menu_Joint_Selection_To_Element_Summary.FK_ItemId');
        $this->db->where('Menu_Joint_Selections_To_Element.FK_SelecCatId = Menu_Joint_Selection_To_Element_Summary.FK_SelecCatId');

        if( $arrCondition != false )
        {	$this->db->where($arrCondition);	}

        $this->db->order_by('Menu_Selection_Category.SelecCatSortNo');
        $this->db->order_by('Menu_Selection.SelecSortNo');

        $query = $this->db->get();

        if( $query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function returnSpicialItmSelectionArr( $arrCondition = false ) {
        $this->db->select('`Menu_Special_Item_Details`.`Pk_SpecialItmDetails`, `Menu_Special_Item_Details`.`SpecialItmSelectionName`');
        $this->db->select('`Menu_Joint_Special_Item_Base_Details`.`PK_J_SpecialItemBaseDetailsId`, `Menu_Joint_Special_Item_Base_Details`.`Fk_CatId`');
        $this->db->select('`Menu_Category`.`CatName`, `Menu_Joint_Special_Item_Base_Details`.`FK_SubCatId`');
        $this->db->select('`Menu_Sub_Category`.`SubCatName`, `Menu_Joint_Special_Item_Base_Details`.`FK_BaseId`');
        $this->db->select('`Menu_Base`.`BaseName`, `Menu_Joint_Special_Item_Base_Details`.`J_Price` as `BasePrice`, `Menu_Joint_Special_Item_Base_Details`.`Flag_HasSelection`');

        $this->db->select('`Menu_Joint_Special_Item_Base_Selection_Details`.`PK_J_SpecialItemBaseSelectionId`, `Menu_Joint_Special_Item_Base_Selection_Details`.`J_Price` as `BaseSelectionPrice`');

        $this->db->select('`Menu_Joint_Special_Item_Base_Selection_Details`.`FK_SelecCatId`,
`Menu_Selection_Category`.`SelecCatName`');
        $this->db->select('`Menu_Joint_Special_Item_Base_Selection_Details`.`FK_SelecId`,
`Menu_Selection`.`SelecName`');

        $this->db->from('`Menu_Special_Item_Details`, `Menu_Joint_Special_Item_Base_Details`');

        $this->db->join('`Menu_Joint_Special_Item_Base_Selection_Details`', '`Menu_Joint_Special_Item_Base_Details`.`PK_J_SpecialItemBaseDetailsId` = `Menu_Joint_Special_Item_Base_Selection_Details`.`FK_J_SpecialItemBaseDetailsId`', 'left');

        $this->db->join('`Menu_Category`', '`Menu_Joint_Special_Item_Base_Details`.`Fk_CatId` = `Menu_Category`.`PK_CatId`', 'left');
        $this->db->join('`Menu_Sub_Category`', '`Menu_Joint_Special_Item_Base_Details`.`FK_SubCatId` = `Menu_Sub_Category`.`PK_SubCatId`', 'left');
        $this->db->join('`Menu_Base`', '`Menu_Joint_Special_Item_Base_Details`.`FK_BaseId` = `Menu_Base`.`PK_BaseId`', 'left');

        $this->db->join('`Menu_Selection_Category`', '`Menu_Joint_Special_Item_Base_Selection_Details`.`FK_SelecCatId` = `Menu_Selection_Category`.`PK_SelecCatId`', 'left');
        $this->db->join('`Menu_Selection`', '`Menu_Joint_Special_Item_Base_Selection_Details`.`FK_SelecId` = `Menu_Selection`.`PK_SelecId`', 'left');

        $this->db->where('`Menu_Special_Item_Details`.`Pk_SpecialItmDetails` = `Menu_Joint_Special_Item_Base_Details`.`Fk_SpecialItmDetails`');

        if( $arrCondition != false )
        {	$this->db->where($arrCondition);	}

        $query = $this->db->get();

        if( $query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return false;
        }
    }

    /*
     *	Return the valid Category for Menu Page
     */
    public function returnValidCategoryForMenu( $arrCondition = false, $OrderType = NULL ) {
        $this->db->select('Menu_Category.PK_CatId PK_CatId, Menu_Category.CatName CatName, Menu_Category.CatOrderType CatOrderType,Menu_Category.CatSortNo CatSortNo, Menu_Category.CatDesc CatDesc');
        $this->db->select('Menu_Sub_Category.PK_SubCatId PK_SubCatId, Menu_Sub_Category.SubCatName SubCatName, Menu_Sub_Category.SubCatOrderType SubCatOrderType, Menu_Sub_Category.SubCatSortNo SubCatSortNo, Menu_Sub_Category.SubCatDesc SubCatDesc');

        $this->db->from('Menu_Category');

        if( $OrderType != NULL ) {
            $this->db->where("( Menu_Category.CatOrderType = $OrderType OR Menu_Category.CatOrderType IS NULL )");

            $this->db->join('Menu_Sub_Category',
                "Menu_Sub_Category.FK_CatId = Menu_Category.PK_CatId AND( Menu_Sub_Category.SubCatOrderType = $OrderType OR Menu_Sub_Category.SubCatOrderType IS NULL )",
                'left');
        }
        else {
            $this->db->join('Menu_Sub_Category', 'Menu_Sub_Category.FK_CatId = Menu_Category.PK_CatId', 'left');
        }

        if( $arrCondition != false )
        {	$this->db->where($arrCondition);	}

        $this->db->order_by("CatSortNo, SubCatSortNo");

        $query = $this->db->get();

        //echo $this->db->last_query();

        if( $query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return false;
        }
    }


    /*
     *	Return the valid Item for Menu Page Based On Category and Sub Category
     */
    public function returnItmListByCategoryOrSubCategory( $arrCondition = false, $OrderType = NULL, $arrCategory = false, $arrSubCategory = false ) {
        $this->db->select('Menu_Base.*');
        $this->db->select('Menu_Category.PK_CatId PK_CatId, Menu_Category.CatName CatName, Menu_Category.CatOrderType CatOrderType,Menu_Category.CatSortNo CatSortNo, Menu_Category.CatDesc CatDesc');
        $this->db->select('Menu_Sub_Category.PK_SubCatId PK_SubCatId, Menu_Sub_Category.SubCatName SubCatName, Menu_Sub_Category.SubCatOrderType SubCatOrderType, Menu_Sub_Category.SubCatSortNo SubCatSortNo, Menu_Sub_Category.SubCatDesc SubCatDesc');

        $this->db->from('Menu_Base');
        $this->db->from('Menu_Category');
        $this->db->where('Menu_Base.FK_CatId = Menu_Category.PK_CatId');

        //  New Version
        $this->db->join('Menu_Sub_Category', 'Menu_Sub_Category.PK_SubCatId = Menu_Base.FK_SubCatId', 'left');
        
        if( $arrCondition != false )
        {	$this->db->where($arrCondition);	}

        /*
         * Segment For Later
        if( $OrderType != NULL ) {  }
        else {  }
         */

        $this->db->group_start();
        if( $arrCategory != false )
        {	$this->db->where_in('Menu_Base.FK_CatId', $arrCategory);	}

        if( $arrSubCategory != false )
        {	$this->db->or_where_in('Menu_Base.FK_SubCatId', $arrSubCategory);	}
        $this->db->group_end();

        $this->db->order_by("CatSortNo, SubCatSortNo, BaseSortNo");

        $query = $this->db->get();

        //echo $this->db->last_query();

        if( $query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return false;
        }
    }

    /*
     *	Return the Formated Item List With Categor and Sub Category Details
     *  Used in 'modules/menu/controller/menu.php'
     */
    public function returnFormatedItemListWithCategoryAndSubCategory( $arrRawItemList ) {
        if( isset($arrRawItemList) && count($arrRawItemList) > 0 ) {
            $arrPreparedItemList = array();

            foreach( $arrRawItemList as $objRawItm ) {
                //echo "<br />-----------------------------------------------------------------------------------<br />";
                //printArr($objRawItm);
                
                //  Setting Up The Category
                if ( isset($arrPreparedItemList[$objRawItm->FK_CatId]) && array_key_exists("categoryDetails", $arrPreparedItemList[$objRawItm->FK_CatId]) ) {
                    //echo " Already Exists ==> ". $objRawItm->CatName ."<br />";
                }
                else {    
                    //echo "ADD TO CATEGORY SEGMENT ==> ". $objRawItm->CatName ."<br />";
                    $arrPreparedItemList[$objRawItm->FK_CatId]['categoryDetails']['CatName'] = $objRawItm->CatName;
                    $arrPreparedItemList[$objRawItm->FK_CatId]['categoryDetails']['CatOrderType'] = $objRawItm->CatOrderType;
                    $arrPreparedItemList[$objRawItm->FK_CatId]['categoryDetails']['CatSortNo'] = $objRawItm->CatSortNo;
                    $arrPreparedItemList[$objRawItm->FK_CatId]['categoryDetails']['CatDesc'] = $objRawItm->CatDesc;
                }

                if( $objRawItm->FK_SubCatId == 0 ) {
                    ///////////////////  FOR ITEMS WITHOUT SUB CATEGORY
                    //  Setting Up The Item
                    $arrPreparedItemList[$objRawItm->FK_CatId]['items'][$objRawItm->PK_BaseId]['PK_BaseId'] = $objRawItm->PK_BaseId;
                    $arrPreparedItemList[$objRawItm->FK_CatId]['items'][$objRawItm->PK_BaseId]['BaseName'] = $objRawItm->BaseName;
                    $arrPreparedItemList[$objRawItm->FK_CatId]['items'][$objRawItm->PK_BaseId]['BaseType'] = $objRawItm->BaseType;
                    $arrPreparedItemList[$objRawItm->FK_CatId]['items'][$objRawItm->PK_BaseId]['BaseNo'] = $objRawItm->BaseNo;
                    $arrPreparedItemList[$objRawItm->FK_CatId]['items'][$objRawItm->PK_BaseId]['BasePrice'] = $objRawItm->BasePrice;
                    $arrPreparedItemList[$objRawItm->FK_CatId]['items'][$objRawItm->PK_BaseId]['BaseDesc'] = $objRawItm->BaseDesc;
                    $arrPreparedItemList[$objRawItm->FK_CatId]['items'][$objRawItm->PK_BaseId]['BaseImage'] = $objRawItm->BaseImage;
                    $arrPreparedItemList[$objRawItm->FK_CatId]['items'][$objRawItm->PK_BaseId]['BaseHotLevel'] = $objRawItm->BaseHotLevel;
                    $arrPreparedItemList[$objRawItm->FK_CatId]['items'][$objRawItm->PK_BaseId]['BaseDiscount'] = $objRawItm->BaseDiscount;
                    $arrPreparedItemList[$objRawItm->FK_CatId]['items'][$objRawItm->PK_BaseId]['BaseSortNo'] = $objRawItm->BaseSortNo;
                } 
                else {
                    ///////////////////  FOR ITEMS WITH SUB CATEGORY
                    //  Setting Up The Sub-Category
                    if ( isset($arrPreparedItemList[$objRawItm->FK_CatId]) && array_key_exists("subCategoryDetails", $arrPreparedItemList[$objRawItm->FK_CatId]) && array_key_exists($objRawItm->PK_SubCatId, $arrPreparedItemList[$objRawItm->FK_CatId]['subCategoryDetails']) ) {
                        //echo " Already Exists ==> ". $objRawItm->CatName;
                    }
                    else {    
                        //echo "ADD TO CATEGORY SEGMENT ==> ". $objRawItm->CatName .", SUB-CATEGORY SEGMENT ==> ". $objRawItm->SubCatName ."<br />";
                        $arrPreparedItemList[$objRawItm->FK_CatId]['subCategoryDetails'][$objRawItm->PK_SubCatId]['SubCatName'] = $objRawItm->SubCatName;
                        $arrPreparedItemList[$objRawItm->FK_CatId]['subCategoryDetails'][$objRawItm->PK_SubCatId]['SubCatOrderType'] = $objRawItm->SubCatOrderType;
                        $arrPreparedItemList[$objRawItm->FK_CatId]['subCategoryDetails'][$objRawItm->PK_SubCatId]['SubCatSortNo'] = $objRawItm->SubCatSortNo;
                        $arrPreparedItemList[$objRawItm->FK_CatId]['subCategoryDetails'][$objRawItm->PK_SubCatId]['SubCatDesc'] = $objRawItm->SubCatDesc;
                    }

                    //  Setting Up The Item
                    $arrPreparedItemList[$objRawItm->FK_CatId]['subCategoryDetails'][$objRawItm->PK_SubCatId]['items'][$objRawItm->PK_BaseId]['PK_BaseId'] = $objRawItm->PK_BaseId;
                    $arrPreparedItemList[$objRawItm->FK_CatId]['subCategoryDetails'][$objRawItm->PK_SubCatId]['items'][$objRawItm->PK_BaseId]['BaseName'] = $objRawItm->BaseName;
                    $arrPreparedItemList[$objRawItm->FK_CatId]['subCategoryDetails'][$objRawItm->PK_SubCatId]['items'][$objRawItm->PK_BaseId]['BaseType'] = $objRawItm->BaseType;
                    $arrPreparedItemList[$objRawItm->FK_CatId]['subCategoryDetails'][$objRawItm->PK_SubCatId]['items'][$objRawItm->PK_BaseId]['BaseNo'] = $objRawItm->BaseNo;
                    $arrPreparedItemList[$objRawItm->FK_CatId]['subCategoryDetails'][$objRawItm->PK_SubCatId]['items'][$objRawItm->PK_BaseId]['BasePrice'] = $objRawItm->BasePrice;
                    $arrPreparedItemList[$objRawItm->FK_CatId]['subCategoryDetails'][$objRawItm->PK_SubCatId]['items'][$objRawItm->PK_BaseId]['BaseDesc'] = $objRawItm->BaseDesc;
                    $arrPreparedItemList[$objRawItm->FK_CatId]['subCategoryDetails'][$objRawItm->PK_SubCatId]['items'][$objRawItm->PK_BaseId]['BaseImage'] = $objRawItm->BaseImage;
                    $arrPreparedItemList[$objRawItm->FK_CatId]['subCategoryDetails'][$objRawItm->PK_SubCatId]['items'][$objRawItm->PK_BaseId]['BaseHotLevel'] = $objRawItm->BaseHotLevel;
                    $arrPreparedItemList[$objRawItm->FK_CatId]['subCategoryDetails'][$objRawItm->PK_SubCatId]['items'][$objRawItm->PK_BaseId]['BaseDiscount'] = $objRawItm->BaseDiscount;
                    $arrPreparedItemList[$objRawItm->FK_CatId]['subCategoryDetails'][$objRawItm->PK_SubCatId]['items'][$objRawItm->PK_BaseId]['BaseSortNo'] = $objRawItm->BaseSortNo;
                }

                //printArr( $arrPreparedItemList );
                //echo "<br />-----------------------------------------------------------------------------------<br />";
            }

            //printArr( $arrPreparedItemList );
            return $arrPreparedItemList;
        }
        else {
            return false;
        }
    }















    /*
     *	Return the Selection Details based on Selection Id Array
     */
    public function returnSelectionDetailsBySelectionID_Arr( $jointSelectionIdStr, $arrCondition = false ) {
        $this->db->select('Menu_Selection.PK_SelecId, Menu_Selection.SelecName, Menu_Selection.SelecDefaultPrice, Menu_Selection.SelecDiscount, Menu_Selection.SelecStatus');
        $this->db->select('Menu_Selection_Category.PK_SelecCatId, Menu_Selection_Category.SelecCatName, Menu_Selection_Category.SelecCatSortNo');
        $this->db->select('Menu_Joint_Selections_To_Element.PK_J_SelecToElementID, Menu_Joint_Selections_To_Element.FK_ItemId, Menu_Joint_Selections_To_Element.J_SelecPrice');

        $this->db->select('Menu_Joint_Selection_To_Element_Summary.J_SelecShowOnMenuFlag');

        $this->db->from('Menu_Joint_Selection_To_Element_Summary');
        $this->db->from('Menu_Joint_Selections_To_Element');
        $this->db->from('Menu_Selection');
        $this->db->from('Menu_Selection_Category');

        $this->db->where('Menu_Joint_Selections_To_Element.FK_SelecId = Menu_Selection.PK_SelecId');
        $this->db->where('Menu_Joint_Selections_To_Element.FK_SelecCatId = Menu_Selection_Category.PK_SelecCatId');

        $this->db->where('Menu_Joint_Selections_To_Element.FK_ItemCatId = Menu_Joint_Selection_To_Element_Summary.FK_ItemCatId');
        $this->db->where('Menu_Joint_Selections_To_Element.FK_ItemSubCatId = Menu_Joint_Selection_To_Element_Summary.FK_ItemSubCatId');
        $this->db->where('Menu_Joint_Selections_To_Element.FK_ItemId = Menu_Joint_Selection_To_Element_Summary.FK_ItemId');
        $this->db->where('Menu_Joint_Selections_To_Element.FK_SelecCatId = Menu_Joint_Selection_To_Element_Summary.FK_SelecCatId');

        if( $arrCondition != false )
        {	$this->db->where($arrCondition);	}

        $this->db->where_in("`Menu_Joint_Selections_To_Element`.`PK_J_SelecToElementID`", $jointSelectionIdStr);

        $this->db->order_by('Menu_Selection_Category.SelecCatSortNo');
        $this->db->order_by('Menu_Selection.SelecSortNo');

        $query = $this->db->get();

        if( $query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return false;
        }
    }








    public function returnToppingDetailsByToppingID_Arr( $jointToppingIdStr, $arrCondition = false ) {
        $this->db->select('Menu_Topping.PK_ToppId, Menu_Topping.ToppName, Menu_Topping.ToppDefaultPrice, Menu_Topping.ToppDiscount, Menu_Topping.ToppStatus');
        $this->db->select('Menu_Topping_Category.PK_ToppCatId, Menu_Topping_Category.ToppCatName, Menu_Topping_Category.ToppCatSortNo');

        $this->db->select('Menu_Joint_Toppings_To_Element.PK_J_ToppintToElementID, Menu_Joint_Toppings_To_Element.FK_ItemId');
        $this->db->select('Menu_Joint_Toppings_To_Element.J_ToppPrice, Menu_Joint_Toppings_To_Element.J_ToppFreeFlag, Menu_Joint_Toppings_To_Element.J_ToppDefaultFlag');

        $this->db->from('Menu_Joint_Toppings_To_Element');
        $this->db->from('Menu_Topping');
        $this->db->from('Menu_Topping_Category');

        $this->db->where('Menu_Joint_Toppings_To_Element.FK_ToppId = Menu_Topping.PK_ToppId');
        $this->db->where('Menu_Joint_Toppings_To_Element.FK_ToppCatId = Menu_Topping_Category.PK_ToppCatId');

        if( $arrCondition != false )
        {	$this->db->where($arrCondition);	}


        $this->db->where_in("`Menu_Joint_Toppings_To_Element`.`PK_J_ToppintToElementID`", $jointToppingIdStr);

        $this->db->order_by('Menu_Topping_Category.ToppCatSortNo');
        $this->db->order_by('Menu_Topping.ToppSortNo');

        $query = $this->db->get();

        if( $query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return false;
        }
    }


}
?>
