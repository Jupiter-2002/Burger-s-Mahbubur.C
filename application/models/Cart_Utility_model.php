<?php
class Cart_Utility_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

    /*
    'Generate Identification Key' based on Item that adds to the CART
    Pattern: 
        Normal: {CatId:CatId#SubCatId:SubCatId#ItemId:ItemId}
        Selection: {
                CatId:CatId#SubCatId:SubCatId#ItemId:ItemId#SelecId:[SelecId1,SelecId2,....]
            }
        Topping: {
                CatId:CatId#SubCatId:SubCatId#ItemId:ItemId#ToppId:[ToppId1,ToppId2,....]
            }
        Selection And Topping: {
                CatId:CatId#SubCatId:SubCatId#ItemId:ItemId
                #SelecId:[
                    SelecId1, SelecId2, SelecId3, ....
                ]
                #ToppId:[
                    ToppId1, ToppId2, ToppId3, ....
                ]
            }
        Selection With Topping: {
                CatId:CatId#SubCatId:SubCatId#ItemId:ItemId
                #SelecId:[
                    SelecId1@ToppId:[ToppId1,ToppId2,....],
                    SelecId2@ToppId:[ToppId1,ToppId2,....],
                    ....
                ]
            }
    */
    public function generateIdentificationKey( $arrItemDetails ) {
        $IdentificationKey = "";

        //  For Category
        if( isset($arrItemDetails->FK_CatId) && isValidDigit($arrItemDetails->FK_CatId) ) {
            if( $IdentificationKey != "" )  {   $IdentificationKey .= "#"; }
            $IdentificationKey .= "C_ID:".$arrItemDetails->FK_CatId;
        }
        //  For Sub Category
        if( isset($arrItemDetails->FK_SubCatId) && isValidDigit($arrItemDetails->FK_SubCatId) ) {
            if( $IdentificationKey != "" )  {   $IdentificationKey .= "#"; }
            $IdentificationKey .= "S_C_ID:".$arrItemDetails->FK_SubCatId;
        }
        //  For Base Item
        if( isset($arrItemDetails->PK_BaseId) && isValidDigit($arrItemDetails->PK_BaseId) ) {
            if( $IdentificationKey != "" )  {   $IdentificationKey .= "#"; }
            $IdentificationKey .= "ITM_ID:".$arrItemDetails->PK_BaseId;
        }
        //echo $IdentificationKey."<br />";

        /*
        //  For Selection
        if( isset($arrItemDetails->SelectionDetails) && count($arrItemDetails->SelectionDetails) ) {
            $IdentificationKey .= "#SL_Id:";
            $tmpSelectionIdStr = "";
            foreach ( $arrItemDetails->SelectionDetails as $selectionObj ) {
                $tmpSelectionIdStr .= $selectionObj->PK_J_SelecToElementID.",";
            }
            $IdentificationKey .= "[".$tmpSelectionIdStr."]";
        }
        echo $IdentificationKey."<br />";

        //  For Topping
        if( isset($arrItemDetails->ToppingsDetails) && count($arrItemDetails->ToppingsDetails) ) {
            $IdentificationKey .= "#TP_Id:";
            $tmpToppingIdStr = "";
            foreach ( $arrItemDetails->ToppingsDetails as $toppingObj ) {
                $tmpToppingIdStr .= $toppingObj->PK_J_ToppintToElementID.",";
            }
            $IdentificationKey .= "[".$tmpToppingIdStr."]";
        }
        echo $IdentificationKey."<br />";
        */
        
        return $IdentificationKey;
    }

    public function getItemUnitPrice( $arrItemDetails ) {
        $itemUnitPrice = null;

        $itemUnitPrice = number_formate($arrItemDetails->BasePrice);     //  Demo Data For Now

        return $itemUnitPrice;
    }

    public function getItemDiscount( $arrItemDetails ) {
        $itmDiscount = 0;

        //$itmDiscount = number_formate(0.25);     //  Demo Data For Now

        return $itmDiscount;
    }

    public function cartDiscountDetails( $itemPrice ) {
        $discountArr = array();

        /*
        //  Demo Data For Now
        $discountObj = new stdClass;
        $discountObj->title = "Order Total Discount";
        $discountObj->type = "OrdTotalDiscount";
        $discountObj->amount = number_formate(1.5);
        $discountArr[0] = $discountObj;

        $discountObj = new stdClass;
        $discountObj->title = "Order Type Discount";
        $discountObj->type = "OrdTypeDiscount";
        $discountObj->amount = number_formate(0.5);
        $discountArr[1] = $discountObj;

        $discountObj = new stdClass;
        $discountObj->title = "Voucher Discount";
        $discountObj->type = "VoucherDiscount";
        $discountObj->amount = number_formate(10.5);
        $discountArr[2] = $discountObj;
        */

        $array = array('StartAmount <= ' => $itemPrice, 'EndAmount >= ' => $itemPrice, 'OrderTypeId' => $_SESSION['selectedOrderType']);
        $this->db->where($array);
        $this->db->order_by("DiscountAmount DESC");
        $query = $this->db->get('restaurant_discount');

        //echo $this->db->last_query();

        //	Checks if user is logged in
        if ( $query->num_rows() > 0 ) {
            $tmpDiscountObj = $query->row();

            $discountObj = new stdClass;
            $discountObj->title = "Order Total Discount <br />[".get_global_values('OrderTypeArr', $tmpDiscountObj->OrderTypeId)."]";
            $discountObj->type = "OrdTotalDiscount";

            if( $tmpDiscountObj->DiscountType == 1 ) {
                //  Fixed
                $discountObj->type .= "_Fixed";
                //$discountObj->title .= "_Fixed";
                $discountObj->amount = number_formate($tmpDiscountObj->DiscountAmount);
            }
            else if( $tmpDiscountObj->DiscountType == 2 ) {
                //  Percentage
                $discountObj->type .= "_Percentage";
                $discountObj->title .= "[". $tmpDiscountObj->DiscountAmount ."%]";
                $discountObj->amount = number_formate(($itemPrice * $tmpDiscountObj->DiscountAmount) / 100);
            }
            $discountArr[count($discountArr)+1] = $discountObj;
        } else {
            return false;
        }

        //printArr( $discountArr );

        return $discountArr;
    }










    //  Returns the 'IdentificationKey', 'itemUnitPrice', 'itmDiscount' in an array
    public function processAddedItem( $arrItemDetails ) {
        //printArr($arrItemDetails);

        $processeData = array();

        $processeData['itemUnitPrice'] = 0;
        $processeData['itmDiscount'] = 0;
        $processeData['IdentificationKey'] = "";

        /*
         *  Generate Identification Key [ START ]
         *
        'Generate Identification Key' based on Item that adds to the CART
        Pattern:
            Normal: {CatId:CatId#SubCatId:SubCatId#ItemId:ItemId}
            Selection: {
                    CatId:CatId#SubCatId:SubCatId#ItemId:ItemId#SelecId:[SelecId1,SelecId2,....]
                }
            Topping: {
                    CatId:CatId#SubCatId:SubCatId#ItemId:ItemId#ToppId:[ToppId1,ToppId2,....]
                }
            Selection And Topping: {
                    CatId:CatId#SubCatId:SubCatId#ItemId:ItemId
                    #SelecId:[
                        SelecId1, SelecId2, SelecId3, ....
                    ]
                    #ToppId:[
                        ToppId1, ToppId2, ToppId3, ....
                    ]
                }
            Selection With Topping: {
                    CatId:CatId#SubCatId:SubCatId#ItemId:ItemId
                    #SelecId:[
                        SelecId1@ToppId:[ToppId1,ToppId2,....],
                        SelecId2@ToppId:[ToppId1,ToppId2,....],
                        ....
                    ]
                }
        */

        //  For Category
        if( isset($arrItemDetails->FK_CatId) && isValidDigit($arrItemDetails->FK_CatId) ) {
            if( $processeData['IdentificationKey'] != "" )  {   $processeData['IdentificationKey'] .= "#"; }
            $processeData['IdentificationKey'] .= "C_ID:".$arrItemDetails->FK_CatId;
        }
        //  For Sub Category
        if( isset($arrItemDetails->FK_SubCatId) && isValidDigit($arrItemDetails->FK_SubCatId) ) {
            if( $processeData['IdentificationKey'] != "" )  {   $processeData['IdentificationKey'] .= "#"; }
            $processeData['IdentificationKey'] .= "S_C_ID:".$arrItemDetails->FK_SubCatId;
        }
        //  For Base Item
        if( isset($arrItemDetails->PK_BaseId) && isValidDigit($arrItemDetails->PK_BaseId) ) {
            if( $processeData['IdentificationKey'] != "" )  {   $processeData['IdentificationKey'] .= "#"; }
            $processeData['IdentificationKey'] .= "ITM_ID:".$arrItemDetails->PK_BaseId;
        }
        //echo $processeData['IdentificationKey']."<br />";

        $processeData['itemUnitPrice'] = number_formate($arrItemDetails->BasePrice);
        $processeData['itmDiscount'] = number_formate($arrItemDetails->BaseDiscount);

        //  For Selection
        if( isset($arrItemDetails->SelectionDetails) && count($arrItemDetails->SelectionDetails) ) {
            //  IF THE ITEM HAS SELECTION THE BASE PRICE OF THE ITEM IS NOT APPLICABLE
            $processeData['itemUnitPrice'] = 0;

            $processeData['IdentificationKey'] .= "#SL_Id:";
            $tmpSelectionIdStr = "";
            foreach ( $arrItemDetails->SelectionDetails as $selectionObj ) {
                $processeData['itemUnitPrice'] += number_formate($selectionObj->J_SelecPrice);
                $processeData['itmDiscount'] += number_formate($selectionObj->SelecDiscount);
                $tmpSelectionIdStr .= $selectionObj->PK_J_SelecToElementID.",";
            }
            $processeData['IdentificationKey'] .= "[".$tmpSelectionIdStr."]";
        }
        //echo $processeData['IdentificationKey']."<br />";

        //  For Topping
        if( isset($arrItemDetails->ToppingsDetails) && count($arrItemDetails->ToppingsDetails) ) {
            $processeData['IdentificationKey'] .= "#TP_Id:";
            $tmpToppingIdStr = "";
            foreach ( $arrItemDetails->ToppingsDetails as $toppingObj ) {

                if( $toppingObj->J_ToppFreeFlag == 1 ) {
                    $processeData['itemUnitPrice'] += 0;
                }
                else {
                    $processeData['itemUnitPrice'] += number_formate($toppingObj->J_ToppPrice);
                    $processeData['itmDiscount'] += number_formate($toppingObj->ToppDiscount);
                }

                $tmpToppingIdStr .= $toppingObj->PK_J_ToppintToElementID.",";
            }
            $processeData['IdentificationKey'] .= "[".$tmpToppingIdStr."]";
        }
        //echo $processeData['IdentificationKey']."<br />";
        /*
         *  Generate Identification Key [ END ]
         */

        return $processeData;
    }








}
?>
