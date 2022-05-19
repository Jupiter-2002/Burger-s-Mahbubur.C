<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminTopping extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Admin_model');
		$this->load->model('Utility_model');

		if( !$this->Admin_model->isLoggedIn() ) {
		    session_destroy();
			header("Location: ".base_url()."/admin");
		}
	}

	public function index()	{
		if( $this->Admin_model->getAdminType() == 1 ) {
		    //  Admin Dashboard
            $data['page_title'] = "Toppings";
			$data['respnsHeader'] = 'admin/common/respns_header_admin';

            $data['currentView'] = 'ToppingCategory/topping_category_base';

            //	For Populating Button On Top Heading
            $data['topjQueryHeadingButtonList'] = (object) array( (object) array("event"=>"onclick", "eventFunction"=>"openToppingCategoryDiv()", "class"=>"bars", "label"=>"Add Category"));

			$this->load->view('admin/base_theme_frame',$data);
		} else {
			session_destroy();
			header("Location: ".base_url());
		}
	}

    //  Topping Category Actions [ START ]
    public function ajaxToppingCategoryList() {
        if( $this->Admin_model->getAdminType() == 1 ) {
            $data['recordList'] = $this->Utility_model->returnRecord("Menu_Topping_Category", false, false, "ToppCatSortNo");
            $returnRespond = array("respond"=>array("error_flag"=>false, "content"=>$this->load->view('ToppingCategory/topping_category_list', $data, true)));
            echo json_encode($returnRespond);
        } else {
            session_destroy();
            header("Location: ".base_url());
        }
    }

    public function ajaxToppingCategoryForm() {
        $returnRespond = array();
        if( $this->Admin_model->getAdminType() == 1 ) {
            if( isset($_POST['Action']) && $_POST['Action'] == "addSegment" ) {
                sleep(1);
                $returnRespond = array("respond"=>array("error_flag"=>false, "content"=>$this->load->view('ToppingCategory/topping_category_form', array("SegmentTitle"=>"Add Topping Category"), true)));
            }
            else if( isset($_POST['Action']) && $_POST['Action'] == "editSegment" ) {
                sleep(1);
                if( isset($_POST['ToppCatId']) && $_POST['ToppCatId'] != "" ) {
                    $arrSendToView = array();

                    $arrSendToView['SegmentTitle'] = "Edit Topping Category";
                    $arrSendToView['PK_ToppCatId'] = $_POST['ToppCatId'];
                    $arrSendToView['ObjectDetails'] = $this->Utility_model->returnRecord("Menu_Topping_Category", false, array('PK_ToppCatId'=>$arrSendToView['PK_ToppCatId']));

                    if( is_array($arrSendToView['ObjectDetails']) ) {
                        $returnRespond = array("respond"=>array("error_flag"=>false, "content"=>$this->load->view('ToppingCategory/topping_category_form', $arrSendToView, true)));
                    } else {
                        $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"invalid_id"));
                    }
                }
                else {
                    $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"no_id"));
                }
            }
            else {
                $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"no_action"));
            }
        } else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }

    public function ajaxAddToppingCategory() {
        $returnRespond = array();

        if( $this->Admin_model->getAdminType() == 1 ) {
            $arrFrIns = array();
            parse_str($_POST['PostDataArr'], $arrFrIns);

            //printArr($arrFrIns);

            if( isset($arrFrIns['ToppCatName']) && trim($arrFrIns['ToppCatName']) != "" ) {
                $chkFlag = $this->Utility_model->returnRecord("Menu_Topping_Category", false, array("ToppCatName"=>$arrFrIns['ToppCatName']));

                if( $chkFlag == FALSE ) {
                    $arrFrIns['ToppCatSortNo'] = ($this->Utility_model->returnRecordCount('Menu_Topping_Category') + 1);
                    $newId = $this->Utility_model->insertRecort('Menu_Topping_Category', $arrFrIns );

                    $tmpRespondArr = array();
                    if( $newId > 0 ) {
                        $tmpRespondArr['error_flag'] = FALSE;
                        $tmpRespondArr['code'] = "SUCCESS";
                        $tmpRespondArr['newId'] = $newId;
                    } else {
                        $tmpRespondArr['error_flag'] = TRUE;
                        $tmpRespondArr['error_msg'] = "DbInsertError";
                    }

                    $returnRespond = array("respond"=>$tmpRespondArr);

                } else {
                    $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"ErrorAlreadyExist"));
                }
            }
            else {
                $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"ErrorNameFieldMissing"));
            }
        } else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"not_logged_in"));
        }

        echo json_encode( $returnRespond );
    }

    public function ajaxUpdateToppingCategory( $toppCatId ) {
        $returnRespond = array();
        $isValid = true;

        if( $this->Admin_model->getAdminType() == 1 ) {
            $arrFrUpdateTmp = array();
            parse_str($_POST['PostDataArr'], $arrFrUpdateTmp);

            if( isset($arrFrUpdateTmp['ToppCatName']) && $arrFrUpdateTmp['ToppCatName'] != "" ) {
                $currnetDetails = $this->Utility_model->returnRecord("Menu_Topping_Category", "ToppCatName", array("PK_ToppCatId"=>$toppCatId));

                if( is_array($currnetDetails) ) {
                    $diffResult = array_diff_assoc($arrFrUpdateTmp, (array) $currnetDetails[0]);

                    if( count($diffResult) > 0 ) {
                        //printArr($diffResult);

                        $arrForUpdateFinal = array();

                        foreach ( $diffResult as $diffKey=>$diffKeyValue ) {

                            if( $diffKey == "ToppCatName" && $isValid ) {
                                if( $this->Utility_model->returnRecord("Menu_Topping_Category", false, array('ToppCatName'=>$arrFrUpdateTmp['ToppCatName'], 'PK_ToppCatId !='=>$toppCatId)) == false ) {
                                    $arrForUpdateFinal['ToppCatName'] = $arrFrUpdateTmp['ToppCatName'];
                                }
                                else {
                                    $isValid = false;
                                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"ErrorAlreadyExist"));
                                }
                            }

                        }

                        if( $isValid ) {
                            $countUpdateRow = $this->Utility_model->updateRecord('Menu_Topping_Category', $arrForUpdateFinal, array("PK_ToppCatId"=>$toppCatId) );

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
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"id_error"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"data_missing_error"));
            }
        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode( $returnRespond );
    }
    //  Topping Category Actions [ END ]






    //  Topping Actions [ Start ]
    public function ajaxToppingList( $toppCatId ) {
        $isValid = true;
        if( $this->Admin_model->getAdminType() == 1 ) {
            if( isset($toppCatId) && $toppCatId != "" ) {
                $arrSendToView['catObjDetails'] = $this->Utility_model->returnRecord("Menu_Topping_Category", false, array('PK_ToppCatId'=>$toppCatId));
                if( is_array($arrSendToView['catObjDetails']) ) {
                    $arrSendToView['objList'] = $this->Utility_model->returnRecord("Menu_Topping", false, array("FK_ToppCatId"=>$toppCatId), "ToppSortNo");

                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "content"=>$this->load->view('Topping/topping_list', $arrSendToView, true)));
                }
                else {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_topp_cat_id"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"topp_cat_id_missing"));
            }
        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }

    public function ajaxToppingForm() {
        $isValid = true;
        $returnRespond = array();

        if( $this->Admin_model->getAdminType() == 1 ) {
            if( isset($_POST['Action']) && $_POST['Action'] == "addTopping" ) {
                if( isset($_POST['ToppCatId']) && $_POST['ToppCatId'] != "" ) {
                    sleep(1);
                    $arrSendToView = array();

                    $arrSendToView['SegmentTitle'] = "Add Topping";
                    $arrSendToView['arrObjCatDetails'] = $this->Utility_model->returnRecord("Menu_Topping_Category", false, array("PK_ToppCatId"=>$_POST['ToppCatId']));

                    if( $arrSendToView['arrObjCatDetails'] != FALSE && is_array($arrSendToView['arrObjCatDetails']) ) {
                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "content"=>$this->load->view('Topping/topping_form', $arrSendToView, true)));
                    } else {
                        $isValid = false;
                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"wrong_topp_cat_id"));
                    }
                }
                else {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_topp_cat_id"));
                }
            }
            else if( isset($_POST['Action']) && $_POST['Action'] == "editTopping" ) {
                sleep(1);
                $isValid = true;

                if( isset($_POST['toppCatId']) && $_POST['toppCatId'] != "" ) {
                    if( is_array($this->Utility_model->returnRecord("Menu_Topping_Category", false, array('PK_ToppCatId'=>$_POST['toppCatId']))) ) {
                    } else {
                        $isValid = false;
                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_topp_cat_id"));
                    }
                }
                else {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_topp_cat_id"));
                }

                $editObjectDetails = array();
                if( $isValid && isset($_POST['toppId']) && $_POST['toppId'] != "" ) {
                    $editObjectDetails = $this->Utility_model->returnRecord("Menu_Topping", array("PK_ToppId","FK_ToppCatId","ToppName","ToppDefaultPrice"), array('PK_ToppId'=>$_POST['toppId'], 'FK_ToppCatId'=>$_POST['toppCatId']));
                    if( is_array($editObjectDetails) ) {
                    } else {
                        $isValid = false;
                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_topp_id"));
                    }
                }
                else {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_topp_id"));
                }


                if( $isValid ) {
                    $arrSendToView = array();

                    $arrSendToView['SegmentTitle'] = "Edit Toppgin";
                    $arrSendToView['ObjectDetails'] = $editObjectDetails;

                    $arrSendToView['CategoryList'] = $this->Utility_model->returnRecord("Menu_Topping_Category", array("PK_ToppCatId","ToppCatName"), array('ToppCatStatus'=>1), "ToppCatSortNo");

                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "content"=>$this->load->view('Topping/topping_form', $arrSendToView, true)));
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

    public function ajaxAddTopping( $toppCatId ) {
        $isValid = true;
        $returnRespond = array();

        if( $this->Admin_model->getAdminType() == 1 ) {
            $arrFrIns = array();
            parse_str($_POST['PostDataArr'], $arrFrIns);

            if( isset($arrFrIns['ToppName']) && trim($arrFrIns['ToppName']) != "" ) {
                $chkFlag = $this->Utility_model->returnRecord("Menu_Topping", false, array("ToppName"=>$arrFrIns['ToppName'], "FK_ToppCatId"=>$toppCatId));

                if( $chkFlag == FALSE ) {
                    $currentObjCounter = $this->Utility_model->returnRecordCount('Menu_Topping', false, array("FK_ToppCatId"=>$toppCatId));
                    $arrFrIns['ToppSortNo'] = ($currentObjCounter + 1);
                    $arrFrIns['FK_ToppCatId'] = $toppCatId;

                    //printArr($arrFrIns);

                    $newId = $this->Utility_model->insertRecort('Menu_Topping', $arrFrIns );

                    $tmpRespondArr = array();
                    if( $newId > 0 ) {
                        //  Updating the category table
                        $this->Utility_model->updateRecordReturnAffectedRowCount("Menu_Topping_Category", array("HasTopp"=>1), array("PK_ToppCatId"=>$toppCatId));

                        $tmpRespondArr['error_flag'] = FALSE;
                        $tmpRespondArr['code'] = "SUCCESS";
                        $tmpRespondArr['newId'] = $newId;

                        $tmpRespondArr['firstEntry'] = FALSE;
                        if( $currentObjCounter == 0 ) {
                            $tmpRespondArr['firstEntry'] = TRUE;
                        }

                    } else {
                        $tmpRespondArr['error_flag'] = TRUE;
                        $tmpRespondArr['error_msg'] = "DbInsertError";
                    }

                    $returnRespond = array("respond"=>$tmpRespondArr);
                } else {
                    $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"ErrorAlreadyExist"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"ErrorNameFieldMissing"));
            }
        } else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode( $returnRespond );
    }






    public function ajaxUpdateTopping( $toppId ) {
        $returnRespond = array();
        $isValid = true;

        if( $this->Admin_model->getAdminType() == 1 ) {
            $arrFrUpdateTmp = array();
            parse_str($_POST['PostDataArr'], $arrFrUpdateTmp);

            //printArr($arrFrUpdate);

            if( isset($arrFrUpdateTmp['ToppName']) && $arrFrUpdateTmp['ToppName'] != "" ) {
                $currnetDetails = $this->Utility_model->returnRecord("Menu_Topping", array('FK_ToppCatId','ToppName','ToppDefaultPrice'), array("PK_ToppId"=>$toppId));

                if( is_array($currnetDetails) ) {
                    $diffResult = array_diff_assoc($arrFrUpdateTmp, (array) $currnetDetails[0]);

                    if( count($diffResult) > 0 ) {
                        $arrForUpdateFinal = array();

                        foreach ( $diffResult as $diffKey=>$diffKeyValue ) {
                            if( $diffKey == "FK_ToppCatId" && $isValid ) {
                                if( $this->Utility_model->returnRecord("Menu_Topping", false, array('FK_ToppCatId'=>$arrFrUpdateTmp['FK_ToppCatId'], 'ToppName'=>$arrFrUpdateTmp['ToppName'])) == false ) {
                                    $arrForUpdateFinal['FK_ToppCatId'] = $arrFrUpdateTmp['FK_ToppCatId'];
                                }
                                else {
                                    $isValid = false;
                                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"ErrorAlreadyExist"));
                                }
                            }
                            else if( $diffKey == "ToppName" && $isValid ) {
                                if( $this->Utility_model->returnRecord("Menu_Topping", false, array('FK_ToppCatId'=>$arrFrUpdateTmp['FK_ToppCatId'], 'ToppName'=>$arrFrUpdateTmp['ToppName'])) == false ) {
                                    $arrForUpdateFinal['ToppName'] = $arrFrUpdateTmp['ToppName'];
                                }
                                else {
                                    $isValid = false;
                                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"ErrorAlreadyExist"));
                                }
                            }
                            else if( $diffKey == "ToppDefaultPrice" && $isValid ) {
                                $arrForUpdateFinal['ToppDefaultPrice'] = $arrFrUpdateTmp['ToppDefaultPrice'];
                            }
                        }

                        if( $isValid ) {
                            $countUpdateRow = $this->Utility_model->updateRecord('Menu_Topping', $arrForUpdateFinal, array("PK_ToppId"=>$toppId) );

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
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"id_error"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"ToppName_missing_error"));
            }
        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode( $returnRespond );
    }
    //  Topping Actions [ End ]










}