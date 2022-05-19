<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminItem extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Admin_model');
		$this->load->model('Utility_model');
        $this->load->model('Item_Utility_model');


		if( !$this->Admin_model->isLoggedIn() ) {
		    session_destroy();
			header("Location: ".base_url()."/admin");
		}
	}

	public function index() {
        if( $this->Admin_model->getAdminType() == 1 ) {
            //	For Category Dropdown
            $data['catListDropdown'] = $this->Utility_model->returnRecord("Menu_Category", false, false, "CatSortNo");

            //  Admin Dashboard
            $data['page_title'] = "Item";
            $data['respnsHeader'] = 'admin/common/respns_header_admin';

            $data['currentView'] = 'Item/item_base';

            //	For Populating Button On Top Heading
            $data['topjQueryHeadingButtonList'] = (object) array( (object) array("event"=>"onclick", "eventFunction"=>"openAddCategoryDiv()", "class"=>"bars", "label"=>"Add Category"));

            $this->load->view('admin/base_theme_frame',$data);
        } else {
            session_destroy();
            header("Location: ".base_url());
        }
    }

    public function ajaxItemForm() {
        $returnRespond = array();
        $isValid = true;

        if( $this->Admin_model->getAdminType() == 1 ) {
            if( isset($_POST['Action']) && $_POST['Action'] == "addItem" ) {
                sleep(1);
                $arrSendToView = array();

                $arrSendToView['SegmentTitle'] = "Add New Item";
                $arrSendToView['arrCategoryList'] = $this->Utility_model->returnRecord("Menu_Category", "PK_CatId, CatName");


                if( isset($_POST['CategorId']) && $_POST['CategorId'] != "" ) {
                    $arrSendToView['InitCategorId'] = $_POST['CategorId'];
                }
                if( isset($_POST['SubCategorId']) && $_POST['SubCategorId'] != "" ) {
                    $arrSendToView['InitSubCategorId'] = $_POST['SubCategorId'];
                }

                $arrSendToView['BaseTypeArr'] = get_global_values('BaseTypeArr');
                $arrSendToView['BaseHotLevelArr'] = get_global_values('BaseHotLevelArr');


                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "content"=>$this->load->view('Item/item_form', $arrSendToView, true)));
            }
            else if( isset($_POST['Action']) && $_POST['Action'] == "editItem" ) {
                if( isset($_POST['BaseId']) && $_POST['BaseId'] != "" ) {
                    sleep(1);
                    $arrSendToView = array();

                    $arrSendToView['SegmentTitle'] = "Edit Item";
                    $arrSendToView['arrCategoryList'] = $this->Utility_model->returnRecord("Menu_Category", "PK_CatId, CatName");

                    $arrItemDetails = $this->Utility_model->returnRecord("Menu_Base", false, array("PK_BaseId"=>$_POST['BaseId']));

                    if( isset($arrItemDetails) && is_array($arrItemDetails) && isset($arrItemDetails[0]->FK_CatId) && $arrItemDetails[0]->FK_CatId != "" ) {
                        $arrSendToView['InitCategorId'] = $arrItemDetails[0]->FK_CatId;
                    }
                    if( isset($arrItemDetails) && is_array($arrItemDetails) && isset($arrItemDetails[0]->FK_SubCatId) && $arrItemDetails[0]->FK_SubCatId != "" ) {
                        $arrSendToView['InitSubCategorId'] = $arrItemDetails[0]->FK_SubCatId;
                    }
                    $arrSendToView['arrItemDetails'] = $arrItemDetails;

                    $arrSendToView['BaseTypeArr'] = get_global_values('BaseTypeArr');
                    $arrSendToView['BaseHotLevelArr'] = get_global_values('BaseHotLevelArr');

                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "content"=>$this->load->view('Item/item_form', $arrSendToView, true)));
                } else {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_itm_id"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_action"));
            }
        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }

    public function ajaxAddItem() {
        $returnRespond = array();
        $isValid = true;

        if( $this->Admin_model->getAdminType() == 1 ) {
            if( isset($_POST['AddItemSubmitArr']) && $_POST['AddItemSubmitArr'] != "" ) {
                $arrFrInsert = array();
                parse_str($_POST['AddItemSubmitArr'], $arrFrInsert);

                if( isset($arrFrInsert['FK_CatId']) && $arrFrInsert['FK_CatId']!="" && isset($arrFrInsert['BaseName']) && $arrFrInsert['BaseName']!="" && isset($arrFrInsert['BasePrice']) && $arrFrInsert['BasePrice']!="" && isset($arrFrInsert['BaseType']) && $arrFrInsert['BaseType']!="" ) {
                    $arrChkItmCond['FK_CatId'] = $arrFrInsert['FK_CatId'];
                    $arrChkItmCond['FK_SubCatId'] = $arrFrInsert['FK_SubCatId'];
                    $arrChkItmCond['BaseName'] = $arrFrInsert['BaseName'];

                    $chkItmFlag = $this->Utility_model->returnRecord("Menu_Base", false, $arrChkItmCond);

                    if( $chkItmFlag == FALSE ) {
                        $arrFrInsert['BasePrice'] = number_format($arrFrInsert['BasePrice'], 2);
                        $newBaseId = $this->Utility_model->insertRecort('Menu_Base', $arrFrInsert );

                        $tmpRespondArr = array();
                        if( $newBaseId > 0 ) {
                            $tmpRespondArr['error_flag'] = !$isValid;
                            $tmpRespondArr['code'] = "SUCCESS";
                            $tmpRespondArr['newBaseId'] = $newBaseId;
                        } else {
                            $isValid = false;
                            $tmpRespondArr['error_flag'] = !$isValid;
                            $tmpRespondArr['error_msg'] = "DbInsertError";
                        }

                        $returnRespond = array("respond"=>$tmpRespondArr);
                    }
                    else {
                        $isValid = false;
                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"ErrorItmAlreadyExist"));
                    }
                }
                else {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"ErrorInPostData"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"ErrorInSerializeData"));
            }
        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }

    public function ajaxUpdateItem( $baseId ) {
        $returnRespond = array();
        $isValid = true;

        if( $this->Admin_model->getAdminType() == 1 ) {
            if( isset($_POST['AddUpdateSubmitArr']) && $_POST['AddUpdateSubmitArr'] != "" ) {
                $currnetSubCategoryDetails = $this->Utility_model->returnRecord("Menu_Base", "FK_CatId, FK_SubCatId, BaseName, BasePrice, BaseDiscount, BaseNo, BaseType, BaseHotLevel, BaseDesc", array("PK_BaseId"=>$baseId));

                if( is_array($currnetSubCategoryDetails) ) {
                    $arrPostFrUpdate = array();
                    parse_str($_POST['AddUpdateSubmitArr'], $arrPostFrUpdate);

                    //$diffResult = array_merge(array_diff((array) $currnetSubCategoryDetails[0], $arrPostFrUpdate), array_diff($arrPostFrUpdate, (array) $currnetSubCategoryDetails[0]));

                    $diffResult = array_diff_assoc($arrPostFrUpdate, (array) $currnetSubCategoryDetails[0]);

                    if( count($diffResult) > 0 ) {
                        $arrForUpdate = array();

                        foreach ( $diffResult as $diffKey=>$diffKeyValue ) {
                            if( $diffKey == "FK_CatId" ) {
                                if( isset($arrPostFrUpdate['FK_CatId']) && $arrPostFrUpdate['FK_CatId'] != "" ) {
                                    if( is_array($this->Utility_model->returnRecord("Menu_Category", false, array('PK_CatId'=>$arrPostFrUpdate['FK_CatId']))) ) {
                                        $arrForUpdate['FK_CatId'] = $arrPostFrUpdate['FK_CatId'];
                                    } else {
                                        $isValid = false;
                                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_FK_CatId"));
                                    }
                                }
                                else {
                                    $isValid = false;
                                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_FK_CatId"));
                                }
                            }
                            if( $diffKey == "FK_SubCatId" && $isValid ) {
                                if( isset($arrPostFrUpdate['FK_SubCatId']) && $arrPostFrUpdate['FK_SubCatId'] != "" ) {
                                    if( is_array($this->Utility_model->returnRecord("Menu_Sub_Category", false, array('PK_SubCatId'=>$arrPostFrUpdate['FK_SubCatId'], 'FK_CatId'=>$arrPostFrUpdate['FK_CatId']))) ) {
                                        $arrForUpdate['FK_SubCatId'] = $arrPostFrUpdate['FK_SubCatId'];
                                    } else {
                                        $isValid = false;
                                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_FK_SubCatId"));
                                    }
                                }
                                else {
                                    $isValid = false;
                                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_FK_SubCatId"));
                                }
                            }
                            if( $diffKey == "BaseName" && $isValid ) {
                                if( $this->Utility_model->returnRecord("Menu_Base", false, array('FK_CatId'=>$arrPostFrUpdate['FK_CatId'], 'FK_SubCatId'=>$arrPostFrUpdate['FK_SubCatId'], 'BaseName'=>$arrPostFrUpdate['BaseName'])) == false ) {
                                    $arrForUpdate['BaseName'] = $arrPostFrUpdate['BaseName'];
                                }
                                else {
                                    $isValid = false;
                                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"ErrorItmAlreadyExist"));
                                }
                            }
                            if( $diffKey == "BasePrice" && $isValid ) {
                                $arrForUpdate['BasePrice'] = number_format($arrPostFrUpdate['BasePrice'], 2);
                            }
                            if( $diffKey == "BaseDiscount" && $isValid ) {
                                $arrForUpdate['BaseDiscount'] = $arrPostFrUpdate['BaseDiscount'];
                            }
                            if( $diffKey == "BaseNo" && $isValid ) {
                                $arrForUpdate['BaseNo'] = $arrPostFrUpdate['BaseNo'];
                            }
                            if( $diffKey == "BaseType" && $isValid ) {
                                $arrForUpdate['BaseType'] = $arrPostFrUpdate['BaseType'];
                            }
                            if( $diffKey == "BaseHotLevel" && $isValid ) {
                                $arrForUpdate['BaseHotLevel'] = $arrPostFrUpdate['BaseHotLevel'];
                            }
                            if( $diffKey == "BaseDesc" && $isValid ) {
                                $arrForUpdate['BaseDesc'] = $arrPostFrUpdate['BaseDesc'];
                            }

                            //printArr($arrForUpdate);
                        }

                        if( $isValid ) {
                            $countUpdateRow = $this->Utility_model->updateRecord('Menu_Base', $arrForUpdate, array("PK_BaseId"=>$baseId) );

                            $tmpRespondArr = array();
                            if( $countUpdateRow > 0 ) {
                                $tmpRespondArr['error_flag'] = FALSE;
                                $tmpRespondArr['code'] = "SUCCESS";
                                $tmpRespondArr['query'] = $this->db->last_query();
                            } else {
                                $tmpRespondArr['error_flag'] = TRUE;
                                $tmpRespondArr['error_msg'] = "DbInsertError";
                            }

                            $returnRespond = array("respond"=>$tmpRespondArr);
                        }
                    }
                    else {
                        $isValid = false;
                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_Changes"));
                    }
                }
                else {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"base_id_error"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"ErrorInSerializeData"));
            }
        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }

    public function ajaxViewItemList() {
        $returnRespond = array();
        $isValid = true;

        if( $this->Admin_model->getAdminType() == 1 ) {
            sleep(1);
            $arrSendToView = array();

            $arrSendToView['SegmentTitle'] = "Item List";

            $arrCondition = array();
            if( isset($_POST['CategorId']) && $_POST['CategorId'] != "" ) {
                $arrCondition['Menu_Base.FK_CatId'] = $_POST['CategorId'];
            }
            if( isset($_POST['SubCategorId']) && $_POST['SubCategorId'] != "" ) {
                $arrCondition['Menu_Base.FK_SubCatId'] = $_POST['SubCategorId'];
            }

            $arrSendToView['arrItemList'] = $this->Item_Utility_model->returnItemDetailsArr($arrCondition);

            //echo $this->db->last_query();

            $arrSendToView['arrCategoryDetails'] = $this->Utility_model->returnRecord("Menu_Category", false, array("PK_CatId" => $_POST['CategorId']));

            $arrSendToView['BaseTypeArr'] = get_global_values('BaseTypeArr');
            $arrSendToView['BaseHotLevelArr'] = get_global_values('BaseHotLevelArr');

            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "content"=>$this->load->view('Item/item_list', $arrSendToView, true)));
        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }

    //////////////////////////////////////////////////////
    //////              Topping [ Start ]           //////
    public function ajaxLoadBaseToppingList() {
        $returnRespond = array();
        $isValid = true;

        if( $this->Admin_model->getAdminType() == 1 ) {
            if( isset($_POST['BaseId']) && $_POST['BaseId'] != "" ) {
                $baseItmDetails = $this->Utility_model->returnRecord("Menu_Base", false, array("PK_BaseId"=>$_POST['BaseId']));

                if( is_array($baseItmDetails) ) {
                    sleep(1);
                    $arrSendToView = array();

                    $arrSendToView['SegmentTitle'] = "Topping List";
                    $arrSendToView['BaseItemDetails'] = $baseItmDetails;


                    //  Return the toppings by category but if the toppings is already added to the item returns that topping details [ START ]
                    $arrToppingByCategoryCond['Menu_Joint_Toppings_To_Element.FK_ItemId'] = $_POST['BaseId'];
                    $arrSendToView['arrToppList'] = $this->Item_Utility_model->returnAllAddedToppingByCategoryArr($arrToppingByCategoryCond);
                    //  Return the toppings by category but if the toppings is already added to the item returns that topping details [ END ]

                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "content"=>$this->load->view('Item/Topping/topping_list_by_base', $arrSendToView, true)));
                }
                else {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_base_id"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_base_id"));
            }
        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }

    public function ajaxBaseToppingForm() {
        $returnRespond = array();
        $isValid = true;

        if( $this->Admin_model->getAdminType() == 1 ) {
            if( isset($_POST['Action']) && $_POST['Action'] == "addTopping" ) {
                if( isset($_POST['BaseId']) && $_POST['BaseId'] != "" ) {
                    $baseItmDetails = $this->Utility_model->returnRecord("Menu_Base", false, array("PK_BaseId"=>$_POST['BaseId']));

                    if( is_array($baseItmDetails) ) {
                        sleep(1);
                        $arrSendToView = array();

                        $arrSendToView['SegmentTitle'] = "Topping";
                        $arrSendToView['BaseItemDetails'] = $baseItmDetails;
                        $arrSendToView['arrCategoryList'] = $this->Utility_model->returnRecord("Menu_Topping_Category", "PK_ToppCatId, ToppCatName", array('ToppCatStatus'=>1), "ToppCatSortNo");

                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "content"=>$this->load->view('Item/Topping/topping_form_base', $arrSendToView, true)));
                    }
                    else {
                        $isValid = false;
                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_base_id"));
                    }
                }
                else {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_base_id"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_action"));
            }
        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }

    public function ajaxToppingByCategory() {
        $returnRespond = array();
        $isValid = true;

        if( $this->Admin_model->getAdminType() == 1 ) {
            $baseDetails = array();
            if( isset($_POST['BaseId']) && $_POST['BaseId'] != "" ) {
                $baseDetails = $this->Utility_model->returnRecord("Menu_Base", false, array("PK_BaseId"=>$_POST['BaseId']));

                if( $baseDetails == false ) {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_base_id"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_base_id"));
            }

            $toppCatDetails = array();
            if( isset($_POST['ToppCatId']) && $_POST['ToppCatId'] != "" ) {
                $toppCatDetails = $this->Utility_model->returnRecord("Menu_Topping_Category", false, array("PK_ToppCatId"=>$_POST['ToppCatId']));

                if( $toppCatDetails == false ) {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_cat_id"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_cat_id"));
            }

            if($isValid) {
                sleep(1);
                $arrSendToView = array();

                $arrSendToView['BaseDetails'] = $baseDetails;
                $arrSendToView['ToppCatDetails'] = $toppCatDetails;

                //$arrSendToView['arrToppList'] = $this->Utility_model->returnRecord("Menu_Topping", "PK_ToppId, ToppName, ToppDefaultPrice", array('FK_ToppCatId' =>$_POST['ToppCatId'], 'ToppStatus'=>1), "ToppSortNo");

                //  Return the toppings by category but if the toppings is already added to the item returns that topping details [ START ]
                $arrToppingByCategoryCond['Menu_Topping.FK_ToppCatId'] = $_POST['ToppCatId'];
                $arrToppingByCategoryCond['Menu_Topping.ToppStatus'] = 1;
                $arrSendToView['arrToppList'] = $this->Item_Utility_model->returnToppingByCategoryArr($arrToppingByCategoryCond, $_POST['BaseId']);
                //  Return the toppings by category but if the toppings is already added to the item returns that topping details [ END ]
                //echo $this->db->last_query();

                //  For Already Added Toppings [ START ]
                $arrSendToView['joinToppToBaseSummary'] = $this->Utility_model->returnRecord("Menu_Joint_Topping_To_Element_Summary", "*", array('FK_ItemId' =>$_POST['BaseId'], 'FK_ToppCatId'=>$_POST['ToppCatId']));
                //  For Already Added Toppings [ END ]

                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "content"=>$this->load->view('Item/Topping/topping_form_list_by_category', $arrSendToView, true)));
            }
        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }

    public function ajaxSaveToppingToBase( $BaseId ) {
        $returnRespond = array();
        $isValid = true;

        if( $this->Admin_model->getAdminType() == 1 ) {
            $arrPostData = array();
            parse_str($_POST['PostDataArr'], $arrPostData);

            //printArr($arrPostData);

            $baseDetails = array();
            if( isset($BaseId) && $BaseId != "" ) {
                $baseDetails = $this->Utility_model->returnRecord("Menu_Base", false, array("PK_BaseId"=>$BaseId));

                if( $baseDetails == false ) {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_base_id"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_base_id"));
            }

            if( isset($arrPostData['flagAddToppToItm']) && $arrPostData['flagAddToppToItm'] != "" ) {
                //  Clear Old Record [ Start ]
                $arrTmpDeleteCond = array();
                $arrTmpDeleteCond['FK_ItemId'] = $baseDetails[0]->PK_BaseId;
                $arrTmpDeleteCond['FK_ToppCatId'] = $arrPostData['PK_ToppCatId'];
                $this->Utility_model->deleteRecord('Menu_Joint_Toppings_To_Element', $arrTmpDeleteCond );
                $this->Utility_model->deleteRecord('Menu_Joint_Topping_To_Element_Summary', $arrTmpDeleteCond );
                //  Clear Old Record [ End ]


                foreach ( $arrPostData['flagAddToppToItm'] as $addToppToItmKey => $addToppToItmVal ) {
                    $arrFrToppInsert = array();

                    $arrFrToppInsert['FK_ItemCatId'] = $baseDetails[0]->FK_CatId;
                    $arrFrToppInsert['FK_ItemSubCatId'] = $baseDetails[0]->FK_SubCatId;
                    $arrFrToppInsert['FK_ItemId'] = $baseDetails[0]->PK_BaseId;
                    $arrFrToppInsert['FK_ToppCatId'] = $arrPostData['PK_ToppCatId'];
                    $arrFrToppInsert['FK_ToppId'] = $addToppToItmKey;

                    //  Free Topping
                    if( isset($arrPostData['flagToppFree'][$addToppToItmKey]) && $arrPostData['flagToppFree'][$addToppToItmKey] == 1 ) {
                        $arrFrToppInsert['J_ToppFreeFlag'] = 1;
                        $arrFrToppInsert['J_ToppPrice'] = 0;        //  Price Set to 0 as free topping
                    }

                    //  Default Topping
                    if( isset($arrPostData['flagToppDefault'][$addToppToItmKey]) && $arrPostData['flagToppDefault'][$addToppToItmKey] == 1 ) {
                        $arrFrToppInsert['J_ToppDefaultFlag'] = 1;
                        //$arrFrToppInsert['J_ToppPrice'] = 0;        //  Price Set to 0 as free topping
                    }

                    //  For Price
                    if( !isset($arrFrToppInsert['J_ToppPrice']) && $arrPostData['priceTopp'][$addToppToItmKey] > 0 ) {
                        $arrFrToppInsert['J_ToppPrice'] = $arrPostData['priceTopp'][$addToppToItmKey];
                    }

                    //printArr($arrFrToppInsert);

                    $newId = $this->Utility_model->insertRecort('Menu_Joint_Toppings_To_Element', $arrFrToppInsert );

                    if( $newId > 0 ) { }
                    else {
                        $isValid = false;
                        break;
                    }
                }

                if($isValid) {
                    $arrFrToppSummary = array();
                    $arrFrToppSummary['FK_ItemCatId'] = $baseDetails[0]->FK_CatId;
                    $arrFrToppSummary['FK_ItemSubCatId'] = $baseDetails[0]->FK_SubCatId;
                    $arrFrToppSummary['FK_ItemId'] = $baseDetails[0]->PK_BaseId;
                    $arrFrToppSummary['FK_ToppCatId'] = $arrPostData['PK_ToppCatId'];
                    $arrFrToppSummary['J_ToppMax'] = $arrPostData['MaxTopp'];
                    $arrFrToppSummary['J_ToppFree'] = $arrPostData['FreeTopp'];

                    $newId = $this->Utility_model->insertRecort('Menu_Joint_Topping_To_Element_Summary', $arrFrToppSummary );

                    if( $newId > 0 ) {
                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "code"=>"SUCCESS"));
                    }
                    else {
                        $isValid = false;
                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"major_issue"));
                    }
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"nothing_to_add"));
            }
        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }

    //////          Topping For Selection [ Start ]           //////
    public function ajaxLoadBaseSelectionToppingList() {
        $returnRespond = array();
        $isValid = true;

        if( $this->Admin_model->getAdminType() == 1 ) {
            if( isset($_POST['BaseId']) && $_POST['BaseId'] != "" ) {
                $baseItmDetails = $this->Utility_model->returnRecord("Menu_Base", false, array("PK_BaseId"=>$_POST['BaseId']));

                if( is_array($baseItmDetails) ) {
                    sleep(1);
                    $arrSendToView = array();

                    $arrSendToView['SegmentTitle'] = "Topping List";
                    $arrSendToView['BaseItemDetails'] = $baseItmDetails;
                    $arrSendToView['SelecId'] = $_POST['SelecId'];

                    //  Return the toppings by category but if the toppings is already added to the item returns that topping details [ START ]
                    $arrToppingByCategoryCond['Menu_Joint_Toppings_To_Element.FK_ItemId'] = $_POST['BaseId'];
                    $arrToppingByCategoryCond['Menu_Joint_Toppings_To_Element.FK_ItemSelecId'] = $_POST['SelecId'];
                    $arrSendToView['arrToppList'] = $this->Item_Utility_model->returnAllAddedToppingByCategoryArr($arrToppingByCategoryCond);
                    //  Return the toppings by category but if the toppings is already added to the item returns that topping details [ END ]

                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "content"=>$this->load->view('Item/Topping/topping_list_by_base_selection', $arrSendToView, true)));
                }
                else {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_base_id"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_base_id"));
            }
        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }

    public function ajaxBaseSelectionToppingForm() {
        $returnRespond = array();
        $isValid = true;

        if( $this->Admin_model->getAdminType() == 1 ) {
            if( isset($_POST['Action']) && $_POST['Action'] == "addTopping" ) {
                if( isset($_POST['BaseId']) && $_POST['BaseId'] != "" ) {
                    $baseItmDetails = $this->Utility_model->returnRecord("Menu_Base", false, array("PK_BaseId"=>$_POST['BaseId']));

                    if( is_array($baseItmDetails) ) {
                        sleep(1);
                        $arrSendToView = array();

                        $arrSendToView['SegmentTitle'] = "Topping For Selection";
                        $arrSendToView['BaseItemDetails'] = $baseItmDetails;
                        $arrSendToView['SelecId'] = $_POST['SelecId'];
                        $arrSendToView['arrCategoryList'] = $this->Utility_model->returnRecord("Menu_Topping_Category", "PK_ToppCatId, ToppCatName", array('ToppCatStatus'=>1), "ToppCatSortNo");

                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "content"=>$this->load->view('Item/Topping/topping_selection_form_base', $arrSendToView, true)));
                    }
                    else {
                        $isValid = false;
                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_base_id"));
                    }
                }
                else {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_base_id"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_action"));
            }
        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }

    public function ajaxSelectionToppingByCategory() {
        $returnRespond = array();
        $isValid = true;

        if( $this->Admin_model->getAdminType() == 1 ) {
            $baseDetails = array();
            if( isset($_POST['BaseId']) && $_POST['BaseId'] != "" ) {
                $baseDetails = $this->Utility_model->returnRecord("Menu_Base", false, array("PK_BaseId"=>$_POST['BaseId']));

                if( $baseDetails == false ) {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_base_id"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_base_id"));
            }

            $toppCatDetails = array();
            if( isset($_POST['ToppCatId']) && $_POST['ToppCatId'] != "" ) {
                $toppCatDetails = $this->Utility_model->returnRecord("Menu_Topping_Category", false, array("PK_ToppCatId"=>$_POST['ToppCatId']));

                if( $toppCatDetails == false ) {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_cat_id"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_cat_id"));
            }

            if($isValid) {
                sleep(1);
                $arrSendToView = array();

                $arrSendToView['BaseDetails'] = $baseDetails;
                $arrSendToView['ToppCatDetails'] = $toppCatDetails;
                $arrSendToView['SelecId'] = $_POST['SelecId'];

                //$arrSendToView['arrToppList'] = $this->Utility_model->returnRecord("Menu_Topping", "PK_ToppId, ToppName, ToppDefaultPrice", array('FK_ToppCatId' =>$_POST['ToppCatId'], 'ToppStatus'=>1), "ToppSortNo");

                //  Return the toppings by category but if the toppings is already added to the item returns that topping details [ START ]
                $arrToppingByCategoryCond['Menu_Topping.FK_ToppCatId'] = $_POST['ToppCatId'];
                $arrToppingByCategoryCond['Menu_Topping.ToppStatus'] = 1;
                $arrSendToView['arrToppList'] = $this->Item_Utility_model->returnToppingByCategoryArr($arrToppingByCategoryCond, $_POST['BaseId']);
                //  Return the toppings by category but if the toppings is already added to the item returns that topping details [ END ]
                //echo $this->db->last_query();

                //  For Already Added Toppings [ START ]
                //$arrSendToView['joinToppToBaseSummary'] = $this->Utility_model->returnRecord("Menu_Joint_Topping_To_Element_Summary", "*", array('FK_ItemId' =>$_POST['BaseId'], 'FK_ToppCatId'=>$_POST['ToppCatId']));
                //  For Already Added Toppings [ END ]

                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "content"=>$this->load->view('Item/Topping/topping_selection_form_list_by_category', $arrSendToView, true)));
            }
        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }

    public function ajaxSaveToppingToBaseSelection( $BaseId, $SelecId ) {
        $returnRespond = array();
        $isValid = true;

        if( $this->Admin_model->getAdminType() == 1 ) {
            $arrPostData = array();
            parse_str($_POST['PostDataArr'], $arrPostData);

            $baseDetails = array();
            if( isset($BaseId) && $BaseId != "" ) {
                $baseDetails = $this->Utility_model->returnRecord("Menu_Base", false, array("PK_BaseId"=>$BaseId));

                if( $baseDetails == false ) {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_base_id"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_base_id"));
            }

            if( isset($SelecId) && $SelecId != "" ) {
                $selecDetails = $this->Utility_model->returnRecord("Menu_Selection", false, array("PK_SelecId"=>$SelecId));

                if( $selecDetails == false ) {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_selec_id"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_selec_id"));
            }

            if( isset($arrPostData['flagAddToppToItm']) && $arrPostData['flagAddToppToItm'] != "" ) {
                //  Clear Old Record [ Start ]
                $arrTmpDeleteCond = array();
                $arrTmpDeleteCond['FK_ItemId'] = $baseDetails[0]->PK_BaseId;
                $arrTmpDeleteCond['FK_ItemSelecId'] = $SelecId;
                $arrTmpDeleteCond['FK_ToppCatId'] = $arrPostData['PK_ToppCatId'];
                $this->Utility_model->deleteRecord('Menu_Joint_Toppings_To_Element', $arrTmpDeleteCond );
                $this->Utility_model->deleteRecord('Menu_Joint_Topping_To_Element_Summary', $arrTmpDeleteCond );
                //  Clear Old Record [ End ]


                foreach ( $arrPostData['flagAddToppToItm'] as $addToppToItmKey => $addToppToItmVal ) {
                    $arrFrToppInsert = array();

                    $arrFrToppInsert['FK_ItemCatId'] = $baseDetails[0]->FK_CatId;
                    $arrFrToppInsert['FK_ItemSubCatId'] = $baseDetails[0]->FK_SubCatId;
                    $arrFrToppInsert['FK_ItemId'] = $baseDetails[0]->PK_BaseId;
                    $arrFrToppInsert['FK_ItemSelecId'] = $SelecId;
                    $arrFrToppInsert['FK_ToppCatId'] = $arrPostData['PK_ToppCatId'];
                    $arrFrToppInsert['FK_ToppId'] = $addToppToItmKey;

                    //  Free Topping
                    if( isset($arrPostData['flagToppFree'][$addToppToItmKey]) && $arrPostData['flagToppFree'][$addToppToItmKey] == 1 ) {
                        $arrFrToppInsert['J_ToppFreeFlag'] = 1;
                        $arrFrToppInsert['J_ToppPrice'] = 0;        //  Price Set to 0 as free topping
                    }

                    //  Default Topping
                    if( isset($arrPostData['flagToppDefault'][$addToppToItmKey]) && $arrPostData['flagToppDefault'][$addToppToItmKey] == 1 ) {
                        $arrFrToppInsert['J_ToppDefaultFlag'] = 1;
                        //$arrFrToppInsert['J_ToppPrice'] = 0;        //  Price Set to 0 as free topping
                    }

                    //  For Price
                    if( !isset($arrFrToppInsert['J_ToppPrice']) && $arrPostData['priceTopp'][$addToppToItmKey] > 0 ) {
                        $arrFrToppInsert['J_ToppPrice'] = $arrPostData['priceTopp'][$addToppToItmKey];
                    }

                    //printArr($arrFrToppInsert);

                    $newId = $this->Utility_model->insertRecort('Menu_Joint_Toppings_To_Element', $arrFrToppInsert );

                    if( $newId > 0 ) { }
                    else {
                        $isValid = false;
                        break;
                    }
                }

                if($isValid) {
                    $arrFrToppSummary = array();
                    $arrFrToppSummary['FK_ItemCatId'] = $baseDetails[0]->FK_CatId;
                    $arrFrToppSummary['FK_ItemSubCatId'] = $baseDetails[0]->FK_SubCatId;
                    $arrFrToppSummary['FK_ItemId'] = $baseDetails[0]->PK_BaseId;
                    $arrFrToppSummary['FK_ItemSelecId'] = $SelecId;
                    $arrFrToppSummary['FK_ToppCatId'] = $arrPostData['PK_ToppCatId'];
                    $arrFrToppSummary['J_ToppMax'] = $arrPostData['MaxTopp'];
                    $arrFrToppSummary['J_ToppFree'] = $arrPostData['FreeTopp'];

                    $newId = $this->Utility_model->insertRecort('Menu_Joint_Topping_To_Element_Summary', $arrFrToppSummary );

                    if( $newId > 0 ) {
                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "code"=>"SUCCESS"));
                    }
                    else {
                        $isValid = false;
                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"major_issue"));
                    }
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"nothing_to_add"));
            }
        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }
    //////          Topping For Selection [ End ]             //////

    //////            Topping [ End ]               //////
    //////////////////////////////////////////////////////

    //////////////////////////////////////////////////////
    //////          Selection [ Start ]             //////
    public function ajaxLoadBaseSelectionList() {
        $returnRespond = array();
        $isValid = true;

        if( $this->Admin_model->getAdminType() == 1 ) {
            if( isset($_POST['BaseId']) && $_POST['BaseId'] != "" ) {
                $baseItmDetails = $this->Utility_model->returnRecord("Menu_Base", false, array("PK_BaseId"=>$_POST['BaseId']));

                if( is_array($baseItmDetails) ) {
                    sleep(1);
                    $arrSendToView = array();

                    $arrSendToView['SegmentTitle'] = "Selection List";
                    $arrSendToView['BaseItemDetails'] = $baseItmDetails;


                    //  Return the Selection by category but if the Selection is already added to the item returns that topping details [ START ]
                    $arrToppingByCategoryCond['Menu_Joint_Selections_To_Element.FK_ItemId'] = $_POST['BaseId'];
                    $arrSendToView['arrSelecList'] = $this->Item_Utility_model->returnAllAddedSelectionByCategoryArr($arrToppingByCategoryCond);
                    //  Return the Selection by category but if the Selection is already added to the item returns that topping details [ END ]


                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "content"=>$this->load->view('Item/Selection/selection_list_by_base', $arrSendToView, true)));
                }
                else {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_base_id"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_base_id"));
            }
        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }

    public function ajaxBaseSelectionForm() {
        $returnRespond = array();
        $isValid = true;

        if( $this->Admin_model->getAdminType() == 1 ) {
            if( isset($_POST['Action']) && $_POST['Action'] == "addSelection" ) {


                if( isset($_POST['BaseId']) && $_POST['BaseId'] != "" ) {
                    $baseItmDetails = $this->Utility_model->returnRecord("Menu_Base", false, array("PK_BaseId"=>$_POST['BaseId']));

                    if( is_array($baseItmDetails) ) {
                        sleep(1);
                        $arrSendToView = array();

                        $arrSendToView['SegmentTitle'] = "Selection";
                        $arrSendToView['BaseItemDetails'] = $baseItmDetails;
                        $arrSendToView['arrCategoryList'] = $this->Utility_model->returnRecord("Menu_Selection_Category", "PK_SelecCatId, SelecCatName", array('SelecCatStatus'=>1), "SelecCatSortNo");

                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "content"=>$this->load->view('Item/Selection/selection_form_base', $arrSendToView, true)));
                    }
                    else {
                        $isValid = false;
                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_base_id"));
                    }
                }
                else {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_base_id"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_action"));
            }
        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }

    public function ajaxSelectionByCategory() {
        $returnRespond = array();
        $isValid = true;

        if( $this->Admin_model->getAdminType() == 1 ) {
            $baseDetails = array();
            if( isset($_POST['BaseId']) && $_POST['BaseId'] != "" ) {
                $baseDetails = $this->Utility_model->returnRecord("Menu_Base", false, array("PK_BaseId"=>$_POST['BaseId']));

                if( $baseDetails == false ) {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_base_id"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_base_id"));
            }

            $selCatDetails = array();
            if( isset($_POST['SelecCatId']) && $_POST['SelecCatId'] != "" ) {
                $selCatDetails = $this->Utility_model->returnRecord("Menu_Selection_Category", false, array("PK_SelecCatId"=>$_POST['SelecCatId']));

                if( $selCatDetails == false ) {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_cat_id"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_cat_id"));
            }

            if($isValid) {
                sleep(1);
                $arrSendToView = array();

                $arrSendToView['BaseDetails'] = $baseDetails;
                $arrSendToView['SelCatDetails'] = $selCatDetails;

                //  Return the toppings by category but if the toppings is already added to the item returns that topping details [ START ]
                $arrSelecByCategoryCond['Menu_Selection.FK_SelecCatId'] = $_POST['SelecCatId'];
                $arrSelecByCategoryCond['Menu_Selection.SelecStatus'] = 1;
                $arrSendToView['arrSelecList'] = $this->Item_Utility_model->returnSelectionByCategoryArr($arrSelecByCategoryCond, $_POST['BaseId']);
                //  Return the toppings by category but if the toppings is already added to the item returns that topping details [ END ]

                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "content"=>$this->load->view('Item/Selection/selection_form_list_by_category', $arrSendToView, true)));
            }
        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }

    public function ajaxSaveSelecToBase( $BaseId ) {
	    $returnRespond = array();
        $isValid = true;

        if( $this->Admin_model->getAdminType() == 1 ) {
            $arrPostData = array();
            parse_str($_POST['PostDataArr'], $arrPostData);

            $baseDetails = array();
            if( isset($BaseId) && $BaseId != "" ) {
                $baseDetails = $this->Utility_model->returnRecord("Menu_Base", false, array("PK_BaseId"=>$BaseId));

                if( $baseDetails == false ) {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_base_id"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_base_id"));
            }

            if( isset($arrPostData['flagAddSelecToItm']) && $arrPostData['flagAddSelecToItm'] != "" ) {
                //  Clear Old Record [ Start ]
                $arrTmpDeleteCond = array();
                $arrTmpDeleteCond['FK_ItemId'] = $baseDetails[0]->PK_BaseId;
                $arrTmpDeleteCond['FK_SelecCatId'] = $arrPostData['PK_SelecCatId'];
                $this->Utility_model->deleteRecord('Menu_Joint_Selections_To_Element', $arrTmpDeleteCond );
                $this->Utility_model->deleteRecord('Menu_Joint_Selection_To_Element_Summary', $arrTmpDeleteCond );
                //  Clear Old Record [ End ]


                foreach ( $arrPostData['flagAddSelecToItm'] as $addSelecToItmKey => $addSelecToItmVal ) {
                    $arrFrSelecInsert = array();

                    $arrFrSelecInsert['FK_ItemCatId'] = $baseDetails[0]->FK_CatId;
                    $arrFrSelecInsert['FK_ItemSubCatId'] = $baseDetails[0]->FK_SubCatId;
                    $arrFrSelecInsert['FK_ItemId'] = $baseDetails[0]->PK_BaseId;
                    $arrFrSelecInsert['FK_SelecCatId'] = $arrPostData['PK_SelecCatId'];
                    $arrFrSelecInsert['FK_SelecId'] = $addSelecToItmKey;
                    $arrFrSelecInsert['J_SelecPrice'] = $arrPostData['priceSelec'][$addSelecToItmKey];

                    $newId = $this->Utility_model->insertRecort('Menu_Joint_Selections_To_Element', $arrFrSelecInsert );

                    if( $newId > 0 ) { }
                    else {
                        $isValid = false;
                        break;
                    }
                }


                if($isValid) {
                    $arrFrSelecSummary = array();
                    $arrFrSelecSummary['FK_ItemCatId'] = $baseDetails[0]->FK_CatId;
                    $arrFrSelecSummary['FK_ItemSubCatId'] = $baseDetails[0]->FK_SubCatId;
                    $arrFrSelecSummary['FK_ItemId'] = $baseDetails[0]->PK_BaseId;

                    //  For 'J_SelecShowOnMenuFlag' value on database [ START ]
                    $arrSelecOnMenu = $this->Utility_model->returnRecord("Menu_Joint_Selection_To_Element_Summary", false, $arrFrSelecSummary);
                    if( $arrSelecOnMenu == false ) {
                        //  No show on menu selection so this is valid show on menu
                        $arrFrSelecSummary['J_SelecShowOnMenuFlag'] = 1;
                    }
                    else {
                        //  Cant show on menu as already there
                        $arrFrSelecSummary['J_SelecShowOnMenuFlag'] = 0;
                    }
                    //  For 'J_SelecShowOnMenuFlag' value on database [ END ]

                    $arrFrSelecSummary['FK_SelecCatId'] = $arrPostData['PK_SelecCatId'];

                    $newId = $this->Utility_model->insertRecort('Menu_Joint_Selection_To_Element_Summary', $arrFrSelecSummary );

                    if( $newId > 0 ) {
                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "code"=>"SUCCESS"));
                    }
                    else {
                        $isValid = false;
                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"major_issue"));
                    }
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"nothing_to_add"));
            }
        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }
    //////           Selection [ End ]              //////
    //////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////
    //////          Special Item [ Start ]             //////


    public function ajaxBaseSpecialForm() {
	    $returnRespond = array();
        $isValid = true;

        if( $this->Admin_model->getAdminType() == 1 ) {
            if( isset($_POST['Action']) && $_POST['Action'] == "addSpecial" ) {
                if( isset($_POST['BaseId']) && $_POST['BaseId'] != "" ) {
                    $baseItmDetails = $this->Utility_model->returnRecord("Menu_Base", false, array("PK_BaseId"=>$_POST['BaseId']));

                    if( is_array($baseItmDetails) ) {
                        sleep(1);
                        $arrSendToView = array();

                        //  Admin Dashboard
                        $arrSendToView['SegmentTitle'] = "Selection Details";
                        $arrSendToView['BaseItemDetails'] = $baseItmDetails;

                        $arrSendToView['currentView'] = 'Item/item_base';

                        //printArr($arrSendToView);

                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "content"=>$this->load->view('Item/Special/special_form_base', $arrSendToView, true)));
                    }
                    else {
                        $isValid = false;
                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_base_id"));
                    }
                }
                else {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_base_id"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_action"));
            }
        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }

    public function ajaxItemListFrSpecial() {
        $returnRespond = array();
        $isValid = true;

        if( $this->Admin_model->getAdminType() == 1 ) {


            if( isset($_POST['BaseId']) && $_POST['BaseId'] != "" ) {
                $baseItmDetails = $this->Utility_model->returnRecord("Menu_Base", false, array("PK_BaseId" => $_POST['BaseId']));

                if (is_array($baseItmDetails)) {
                    sleep(1);
                    $arrSendToView = array();

                    $arrSendToView['SegmentTitle'] = "Item List";
                    $arrSendToView['BaseItemDetails'] = $baseItmDetails;

                    $arrCondition = array();
                    if( isset($_POST['CategorId']) && $_POST['CategorId'] != "" ) {
                        $arrCondition['Menu_Base.FK_CatId'] = $_POST['CategorId'];
                        $arrSendToView['arrCategoryDetails'] = $this->Utility_model->returnRecord("Menu_Category", false, array("PK_CatId" => $_POST['CategorId']));
                    }
                    if( isset($_POST['SubCategorId']) && $_POST['SubCategorId'] != "" ) {
                        $arrCondition['Menu_Base.FK_SubCatId'] = $_POST['SubCategorId'];
                        $arrSendToView['arrSubCategoryDetails'] = $this->Utility_model->returnRecord("Menu_Sub_Category", false, array("PK_SubCatId" => $_POST['SubCategorId'], "FK_CatId" => $_POST['CategorId']));
                    }

                    //  Not showing special item for now
                    $arrCondition['Menu_Base.BaseType != '] = 6;

                    $arrItemList = $this->Item_Utility_model->returnItemDetailsArr($arrCondition);
                    //echo $this->db->last_query();

                    //  Return the Selection by category but if the Selection is already added to the item returns that topping details [ START ]
                    foreach ( $arrItemList as $itemKey=>$itemObj ) {
                        $arrToppingByCategoryCond['Menu_Joint_Selections_To_Element.FK_ItemId'] = $itemObj->PK_BaseId;
                        $arrItmSelecList = $this->Item_Utility_model->returnAllAddedSelectionByCategoryArr($arrToppingByCategoryCond);

                        if( $arrItmSelecList != false ) {
                            $arrItemList[$itemKey]->ItemSelectionList = $arrItmSelecList;
                        }
                    }
                    //  Return the Selection by category but if the Selection is already added to the item returns that topping details [ END ]


                    $arrSendToView['arrItemList'] = $arrItemList;

                    $arrSendToView['BaseTypeArr'] = get_global_values('BaseTypeArr');
                    $arrSendToView['BaseHotLevelArr'] = get_global_values('BaseHotLevelArr');

                    //printArr($arrSendToView);

                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "content"=>$this->load->view('Item/Special/item_list_fr_spacial', $arrSendToView, true)));
                }
                else {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_base_id"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_base_id"));
            }

        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }


    /*
     * Save the data from the MAIN FROM of Base Item Add for spacial item
     */
    public function ajaxSaveBaseToSpacialItem_MainForm( $BaseId ) {
        $returnRespond = array();
        $isValid = true;

        if( $this->Admin_model->getAdminType() == 1 ) {
            //  Base Item [ Start ]
            $baseDetails = array();
            if( isset($BaseId) && $BaseId != "" ) {
                $baseDetails = $this->Utility_model->returnRecord("Menu_Base", false, array("PK_BaseId"=>$BaseId));

                if( $baseDetails == false ) {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_base_id"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_base_id"));
            }
            //  Base Item [ End ]

            //  Category [ Start ]
            if( isset($_POST['Category']) && $_POST['Category'] != "" ) {
                $bcategoryDetails = $this->Utility_model->returnRecord("Menu_Category", false, array("PK_CatId"=>$_POST['Category']));

                if( $bcategoryDetails == false ) {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_category_id"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_Category_id"));
            }
            //  Category [ End ]

            //  Sub Category [ Start ]
            if( $isValid && isset($_POST['SubCategory']) && $_POST['SubCategory'] != "" && $_POST['SubCategory'] != "0" ) {
                $baseDetails = $this->Utility_model->returnRecord("Menu_Sub_Category", false, array("PK_SubCatId"=>$_POST['SubCategory'], "FK_CatId"=>$_POST['Category']));

                if( $baseDetails == false ) {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_sub_category_id"));
                }
            }
            //  Sub Category [ End ]

            if( $isValid ) {
                $arrPostData = array();
                parse_str($_POST['PostDataArr'], $arrPostData);
                //printArr($arrPostData);

                if( isset($arrPostData['flagAddToSpacial_Itm']) && $arrPostData['flagAddToSpacial_Itm'] != "" ) {
                    //  Menu_Special_Item_Details [ Start ]
                    $Pk_SpecialItmDetails = 0;
                    if( isset($arrPostData['selectionName']) && $arrPostData['selectionName'] != "" ) {
                        $arrFrInsertSpecialItemDetails['FK_BaseId'] = $BaseId;
                        $arrFrInsertSpecialItemDetails['SpecialItmSelectionName'] = $arrPostData['selectionName'];

                        $Pk_SpecialItmDetails = $this->Utility_model->insertRecort('Menu_Special_Item_Details', $arrFrInsertSpecialItemDetails );

                        if( $Pk_SpecialItmDetails > 0 ) { }
                        else {
                            $isValid = false;
                            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"databaseError"));
                        }
                    }
                    else {
                        $isValid = false;
                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_selectionName"));
                    }
                    //  Menu_Special_Item_Details [ End ]

                    //  Menu_Joint_Special_Item_Base_Details [ Start ]
                    if( $isValid ) {
                        foreach ( $arrPostData['flagAddToSpacial_Itm'] as $keyAddToSpecial_Itm=>$objAddToSpecial_Itm) {
                            $arrFrInsertSpecialItemBaseDetails = array();
                            $arrFrInsertSpecialItemBaseDetails['Fk_SpecialItmDetails'] = $Pk_SpecialItmDetails;

                            //  Getting the Item Details [ Start ]
                            $AddToSpecial_ItmDetails = $this->Utility_model->returnRecord("Menu_Base", false, array("PK_BaseId"=>$objAddToSpecial_Itm));
                            //printArr($AddToSpecial_ItmDetails);

                            if( isset($AddToSpecial_ItmDetails[0]) ) {
                                $arrFrInsertSpecialItemBaseDetails['FK_BaseId'] = $AddToSpecial_ItmDetails[0]->PK_BaseId;
                                $arrFrInsertSpecialItemBaseDetails['Fk_CatId'] = $AddToSpecial_ItmDetails[0]->FK_CatId;
                                $arrFrInsertSpecialItemBaseDetails['FK_SubCatId'] = $AddToSpecial_ItmDetails[0]->FK_SubCatId;
                            }
                            else {
                                $isValid = false;
                                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"databaseError"));
                                echo json_encode($returnRespond);
                                return 0;
                            }
                            //  Getting the Item Details [ End ]

                            if( isset($arrPostData['addToSpacial_Itm_Price'][$objAddToSpecial_Itm]) && $arrPostData['addToSpacial_Itm_Price'][$objAddToSpecial_Itm]> 0 ) {
                                $arrFrInsertSpecialItemBaseDetails['J_Price'] = $arrPostData['addToSpacial_Itm_Price'][$objAddToSpecial_Itm];
                            } else {
                                $arrFrInsertSpecialItemBaseDetails['J_Price'] = 0;
                            }

                            if( isset($arrPostData['flagAddToSpacial_Itm_Selection']) && isset($arrPostData['flagAddToSpacial_Itm_Selection'][$objAddToSpecial_Itm]) ) {
                                $arrFrInsertSpecialItemBaseDetails['Flag_HasSelection'] = 1;
                            }

                            $PK_J_SpecialItemBaseDetailsId = $this->Utility_model->insertRecort('Menu_Joint_Special_Item_Base_Details', $arrFrInsertSpecialItemBaseDetails );

                            if( $PK_J_SpecialItemBaseDetailsId > 0 ) {
                                //  Menu_Joint_Special_Item_Base_Selection_Details [ Start ]
                                if( isset($arrPostData['flagAddToSpacial_Itm_Selection']) && isset($arrPostData['flagAddToSpacial_Itm_Selection'][$objAddToSpecial_Itm]) ) {
                                    $arrFrInsertSpecialItemBaseSelectionDetails = array();

                                    $arrFrInsertSpecialItemBaseSelectionDetails['FK_J_SpecialItemBaseDetailsId'] = $PK_J_SpecialItemBaseDetailsId;
                                    $arrFrInsertSpecialItemBaseSelectionDetails['Fk_CatId'] = $_POST['Category'];
                                    $arrFrInsertSpecialItemBaseSelectionDetails['FK_SubCatId'] = $_POST['SubCategory'];
                                    $arrFrInsertSpecialItemBaseSelectionDetails['FK_BaseId'] = $objAddToSpecial_Itm;

                                    foreach ( $arrPostData['flagAddToSpacial_Itm_Selection'][$objAddToSpecial_Itm] as $keyBaseSelectionCategoryId => $objBaseSelectionCategory) {
                                        $arrFrInsertSpecialItemBaseSelectionDetails['FK_SelecCatId'] = $keyBaseSelectionCategoryId;

                                        foreach ( $objBaseSelectionCategory as $objBaseSelectionId) {
                                            $arrFrInsertSpecialItemBaseSelectionDetails['FK_SelecId'] = $objBaseSelectionId;

                                            if( isset($arrPostData['addToSpacial_Itm_Selection_Price'][$objAddToSpecial_Itm][$keyBaseSelectionCategoryId][$objBaseSelectionId]) && $arrPostData['addToSpacial_Itm_Selection_Price'][$objAddToSpecial_Itm][$keyBaseSelectionCategoryId][$objBaseSelectionId]> 0 ) {
                                                $arrFrInsertSpecialItemBaseSelectionDetails['J_Price'] = $arrPostData['addToSpacial_Itm_Selection_Price'][$objAddToSpecial_Itm][$keyBaseSelectionCategoryId][$objBaseSelectionId];
                                            } else {
                                                $arrFrInsertSpecialItemBaseSelectionDetails['J_Price'] = 0;
                                            }

                                            $PK_J_SpecialItemBaseDetailsId = $this->Utility_model->insertRecort('Menu_Joint_Special_Item_Base_Selection_Details', $arrFrInsertSpecialItemBaseSelectionDetails );

                                            if( $PK_J_SpecialItemBaseDetailsId > 0 ) { }
                                            else {
                                                $isValid = false;
                                                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"databaseError"));
                                                echo json_encode($returnRespond);
                                                return 0;
                                            }
                                        }
                                    }
                                }
                                //  Menu_Joint_Special_Item_Base_Selection_Details [ End ]
                            }
                            else {
                                $isValid = false;
                                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"databaseError"));
                            }

                        }
                    }
                    //  Menu_Joint_Special_Item_Base_Details [ End ]

                    if( $isValid ) {
                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "code"=>"SUCCESS"));
                    }
                }
                else {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"nothing_to_add"));
                }
            }
        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }

    public function ajaxLoadBaseSpecialItmDetailsList() {
        $returnRespond = array();
        $isValid = true;

        if( $this->Admin_model->getAdminType() == 1 ) {
            if( isset($_POST['BaseId']) && $_POST['BaseId'] != "" ) {
                $baseItmDetails = $this->Utility_model->returnRecord("Menu_Base", false, array("PK_BaseId"=>$_POST['BaseId']));

                if( is_array($baseItmDetails) ) {
                    sleep(1);
                    $arrSendToView = array();

                    $arrSendToView['SegmentTitle'] = "Special Selection List";
                    $arrSendToView['BaseItemDetails'] = $baseItmDetails;

                    //  Return the Selection by category but if the Selection is already added to the item returns that topping details [ START ]
                    $arrToppingByCategoryCond['`Menu_Special_Item_Details`.`FK_BaseId`'] = $_POST['BaseId'];
                    $tmpArrSpecialItemSelection = $this->Item_Utility_model->returnSpicialItmSelectionArr($arrToppingByCategoryCond);

                    //echo $this->db->last_query();

                    $arrSpecialItemSelection = array();

                    $tmp_Pk_SpecialItmDetails = 0;
                    $tmp_PK_J_SpecialItemBaseDetailsId = 0;
                    $tmp_PK_J_SpecialItemBaseSelectionId = 0;

                    foreach ( $tmpArrSpecialItemSelection as $objSpecialItemSelection) {
                        //  Data Manipulation From 'Menu_Special_Item_Details' Table
                        if( $tmp_Pk_SpecialItmDetails != $objSpecialItemSelection->Pk_SpecialItmDetails ) {
                            $tmp_Pk_SpecialItmDetails = $objSpecialItemSelection->Pk_SpecialItmDetails;
                            $arrSpecialItemSelection[$tmp_Pk_SpecialItmDetails]['Pk_SpecialItmDetails'] = $tmp_Pk_SpecialItmDetails;
                            $arrSpecialItemSelection[$tmp_Pk_SpecialItmDetails]['SpecialItmSelectionName'] = $objSpecialItemSelection->SpecialItmSelectionName;
                        }

                        //  Data Manipulation From 'Menu_Joint_Special_Item_Base_Details' Table
                        if( $tmp_PK_J_SpecialItemBaseDetailsId != $objSpecialItemSelection->PK_J_SpecialItemBaseDetailsId ) {
                            $tmp_PK_J_SpecialItemBaseDetailsId = $objSpecialItemSelection->PK_J_SpecialItemBaseDetailsId;

                            $arrSpecialItemSelection[$tmp_Pk_SpecialItmDetails]['SpecialItemBaseDetails'][$tmp_PK_J_SpecialItemBaseDetailsId]['PK_J_SpecialItemBaseDetailsId'] = $tmp_PK_J_SpecialItemBaseDetailsId;

                            $arrSpecialItemSelection[$tmp_Pk_SpecialItmDetails]['SpecialItemBaseDetails'][$tmp_PK_J_SpecialItemBaseDetailsId]['Fk_CatId'] = $objSpecialItemSelection->Fk_CatId;
                            $arrSpecialItemSelection[$tmp_Pk_SpecialItmDetails]['SpecialItemBaseDetails'][$tmp_PK_J_SpecialItemBaseDetailsId]['CatName'] = $objSpecialItemSelection->CatName;
                            $arrSpecialItemSelection[$tmp_Pk_SpecialItmDetails]['SpecialItemBaseDetails'][$tmp_PK_J_SpecialItemBaseDetailsId]['FK_SubCatId'] = $objSpecialItemSelection->FK_SubCatId;
                            $arrSpecialItemSelection[$tmp_Pk_SpecialItmDetails]['SpecialItemBaseDetails'][$tmp_PK_J_SpecialItemBaseDetailsId]['SubCatName'] = $objSpecialItemSelection->SubCatName;
                            $arrSpecialItemSelection[$tmp_Pk_SpecialItmDetails]['SpecialItemBaseDetails'][$tmp_PK_J_SpecialItemBaseDetailsId]['FK_BaseId'] = $objSpecialItemSelection->FK_BaseId;
                            $arrSpecialItemSelection[$tmp_Pk_SpecialItmDetails]['SpecialItemBaseDetails'][$tmp_PK_J_SpecialItemBaseDetailsId]['BaseName'] = $objSpecialItemSelection->BaseName;
                            $arrSpecialItemSelection[$tmp_Pk_SpecialItmDetails]['SpecialItemBaseDetails'][$tmp_PK_J_SpecialItemBaseDetailsId]['BasePrice'] = $objSpecialItemSelection->BasePrice;
                            $arrSpecialItemSelection[$tmp_Pk_SpecialItmDetails]['SpecialItemBaseDetails'][$tmp_PK_J_SpecialItemBaseDetailsId]['Flag_HasSelection'] = $objSpecialItemSelection->Flag_HasSelection;
                        }

                        //  Data Manipulation From 'Menu_Joint_Special_Item_Base_Selection_Details' Table
                        if( $objSpecialItemSelection->PK_J_SpecialItemBaseSelectionId > 0 && $tmp_PK_J_SpecialItemBaseSelectionId != $objSpecialItemSelection->PK_J_SpecialItemBaseSelectionId ) {
                            $tmp_PK_J_SpecialItemBaseSelectionId = $objSpecialItemSelection->PK_J_SpecialItemBaseSelectionId;

                            $arrSpecialItemSelection[$tmp_Pk_SpecialItmDetails]['SpecialItemBaseDetails'][$tmp_PK_J_SpecialItemBaseDetailsId]['SpecialItemBaseSelectionDetails'][$tmp_PK_J_SpecialItemBaseSelectionId]['PK_J_SpecialItemBaseSelectionId'] = $tmp_PK_J_SpecialItemBaseSelectionId;

                            $arrSpecialItemSelection[$tmp_Pk_SpecialItmDetails]['SpecialItemBaseDetails'][$tmp_PK_J_SpecialItemBaseDetailsId]['SpecialItemBaseSelectionDetails'][$tmp_PK_J_SpecialItemBaseSelectionId]['FK_SelecCatId'] = $objSpecialItemSelection->FK_SelecCatId;
                            $arrSpecialItemSelection[$tmp_Pk_SpecialItmDetails]['SpecialItemBaseDetails'][$tmp_PK_J_SpecialItemBaseDetailsId]['SpecialItemBaseSelectionDetails'][$tmp_PK_J_SpecialItemBaseSelectionId]['SelecCatName'] = $objSpecialItemSelection->SelecCatName;
                            $arrSpecialItemSelection[$tmp_Pk_SpecialItmDetails]['SpecialItemBaseDetails'][$tmp_PK_J_SpecialItemBaseDetailsId]['SpecialItemBaseSelectionDetails'][$tmp_PK_J_SpecialItemBaseSelectionId]['FK_SelecId'] = $objSpecialItemSelection->FK_SelecId;
                            $arrSpecialItemSelection[$tmp_Pk_SpecialItmDetails]['SpecialItemBaseDetails'][$tmp_PK_J_SpecialItemBaseDetailsId]['SpecialItemBaseSelectionDetails'][$tmp_PK_J_SpecialItemBaseSelectionId]['SelecName'] = $objSpecialItemSelection->SelecName;
                            $arrSpecialItemSelection[$tmp_Pk_SpecialItmDetails]['SpecialItemBaseDetails'][$tmp_PK_J_SpecialItemBaseDetailsId]['SpecialItemBaseSelectionDetails'][$tmp_PK_J_SpecialItemBaseSelectionId]['BaseSelectionPrice'] = $objSpecialItemSelection->BaseSelectionPrice;
                        }
                    }
                    $arrSendToView['arrSpecialItemSelection'] = $arrSpecialItemSelection;
                    //printArr($arrSendToView);
                    //die();

                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "content"=>$this->load->view('Item/Special/special_item_base_and_selection_list', $arrSendToView, true)));
                }
                else {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_base_id"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_base_id"));
            }
        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }






    //////          Special Item [ End ]               //////
    /////////////////////////////////////////////////////////

}