<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminSelection extends MY_Controller {
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
            $data['page_title'] = "Selection";
			$data['respnsHeader'] = 'admin/common/respns_header_admin';

            $data['currentView'] = 'SelectionCategory/selection_category_base';

            //	For Populating Button On Top Heading
            $data['topjQueryHeadingButtonList'] = (object) array( (object) array("event"=>"onclick", "eventFunction"=>"openSelectionCategoryDiv()", "class"=>"bars", "label"=>"Add Category"));

			$this->load->view('admin/base_theme_frame',$data);
		} else {
			session_destroy();
			header("Location: ".base_url());
		}
	}

    //  Selection Category Actions [ START ]
	public function ajaxSelectionCategoryList() {
        if( $this->Admin_model->getAdminType() == 1 ) {
            $data['recordList'] = $this->Utility_model->returnRecord("Menu_Selection_Category", false, false, "SelecCatSortNo");
            $returnRespond = array("respond"=>array("error_flag"=>false, "content"=>$this->load->view('SelectionCategory/selection_category_list', $data, true)));
            echo json_encode($returnRespond);
        } else {
            session_destroy();
            header("Location: ".base_url());
        }
    }

    public function ajaxSelectionCategoryForm() {
        $returnRespond = array();
        if( $this->Admin_model->getAdminType() == 1 ) {
            if( isset($_POST['Action']) && $_POST['Action'] == "addSegment" ) {
                $returnRespond = array("respond"=>array("error_flag"=>false, "content"=>$this->load->view('SelectionCategory/selection_category_form', array("SegmentTitle"=>"Add Selection Category"), true)));
            }
            else if( isset($_POST['Action']) && $_POST['Action'] == "editSegment" ) {
                sleep(1);
                if( isset($_POST['SelCatId']) && $_POST['SelCatId'] != "" ) {
                    $arrSendToView = array();

                    $arrSendToView['SegmentTitle'] = "Edit Selection Category";
                    $arrSendToView['SelCatId'] = $_POST['SelCatId'];
                    $arrSendToView['ObjectDetails'] = $this->Utility_model->returnRecord("Menu_Selection_Category", false, array('PK_SelecCatId'=>$arrSendToView['SelCatId']), "SelecCatSortNo");

                    if( is_array($arrSendToView['ObjectDetails']) ) {
                        $returnRespond = array("respond"=>array("error_flag"=>false, "content"=>$this->load->view('SelectionCategory/selection_category_form', $arrSendToView, true)));
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

    public function ajaxAddSelectionCategory() {
        $returnRespond = array();

        if( $this->Admin_model->getAdminType() == 1 ) {
            $arrFrIns = array();
            parse_str($_POST['PostDataArr'], $arrFrIns);

            //printArr($arrFrIns);

            if( isset($arrFrIns['SelecCatName']) && trim($arrFrIns['SelecCatName']) != "" ) {
                $chkFlag = $this->Utility_model->returnRecord("Menu_Selection_Category", false, array("SelecCatName"=>$arrFrIns['SelecCatName']));

                if( $chkFlag == FALSE ) {

                    $arrFrIns['SelecCatSortNo'] = ($this->Utility_model->returnRecordCount('Menu_Selection_Category') + 1);
                    $newId = $this->Utility_model->insertRecort('Menu_Selection_Category', $arrFrIns );

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

    public function ajaxUpdateSelectionCategory( $selCatId ) {
        $returnRespond = array();
        $isValid = true;

        if( $this->Admin_model->getAdminType() == 1 ) {

            $arrFrUpdate = array();
            parse_str($_POST['PostDataArr'], $arrFrUpdate);

            if( isset($arrFrUpdate['SelecCatName']) && $arrFrUpdate['SelecCatName'] != "" ) {
                $currnetDetails = $this->Utility_model->returnRecord("Menu_Selection_Category", "SelecCatName", array("PK_SelecCatId"=>$selCatId));

                if( is_array($currnetDetails) ) {
                    $diffResult = array_diff_assoc($arrFrUpdate, (array) $currnetDetails[0]);

                    if( count($diffResult) > 0 ) {
                        //printArr($diffResult);

                        $arrForUpdate = array();

                        foreach ( $diffResult as $diffKey=>$diffKeyValue ) {

                            if( $diffKey == "SelecCatName" && $isValid ) {
                                if( $this->Utility_model->returnRecord("Menu_Selection_Category", false, array('SelecCatName'=>$arrFrUpdate['SelecCatName'], 'PK_SelecCatId != '=>$selCatId)) == false ) {
                                    $arrForUpdate['SelecCatName'] = $arrFrUpdate['SelecCatName'];
                                }
                                else {
                                    $isValid = false;
                                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"ErrorAlreadyExist"));
                                }
                            }
                        }

                        if( $isValid ) {
                            $countUpdateRow = $this->Utility_model->updateRecord('Menu_Selection_Category', $arrForUpdate, array("PK_SelecCatId"=>$selCatId) );

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
    //  Selection Category Actions [ END ]

    //  Selection Actions [ Start ]
    public function ajaxSelectionList( $selecCatId ) {
        $isValid = true;
        if( $this->Admin_model->getAdminType() == 1 ) {
            if( isset($selecCatId) && $selecCatId != "" ) {
                $arrSendToView['selecCatDetails'] = $this->Utility_model->returnRecord("Menu_Selection_Category", false, array('PK_SelecCatId'=>$selecCatId));
                if( is_array($arrSendToView['selecCatDetails']) ) {

                    $arrSendToView['selecList'] = $this->Utility_model->returnRecord("Menu_Selection", false, array("FK_SelecCatId"=>$selecCatId), "SelecSortNo");

                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "content"=>$this->load->view('Selection/selection_list', $arrSendToView, true)));
                }
                else {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_sel_cat_id"));
                }
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"selec_cat_id_missing"));
            }
        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }

    public function ajaxSelectionForm() {
        $isValid = true;
        $returnRespond = array();

        if( $this->Admin_model->getAdminType() == 1 ) {
            if( isset($_POST['Action']) && $_POST['Action'] == "addSelection" ) {
                if( isset($_POST['SelecCatId']) && $_POST['SelecCatId'] != "" ) {
                    sleep(1);
                    $arrSendToView = array();

                    $arrSendToView['SegmentTitle'] = "Add Selection";
                    $arrSendToView['arrSelecCatDetails'] = $this->Utility_model->returnRecord("Menu_Selection_Category", false, array("PK_SelecCatId"=>$_POST['SelecCatId']));

                    if( $arrSendToView['arrSelecCatDetails'] != FALSE && is_array($arrSendToView['arrSelecCatDetails']) ) {
                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "content"=>$this->load->view('Selection/selection_form', $arrSendToView, true)));
                    } else {
                        $isValid = false;
                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"wrong_selec_cat_id"));
                    }
                }
                else {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_selec_cat_id"));
                }
            }
            else if( isset($_POST['Action']) && $_POST['Action'] == "editSelection" ) {
                sleep(1);
                $isValid = true;

                if( isset($_POST['SelCategoryId']) && $_POST['SelCategoryId'] != "" ) {
                    if( is_array($this->Utility_model->returnRecord("Menu_Selection_Category", false, array('PK_SelecCatId'=>$_POST['SelCategoryId']))) ) {
                        //  Valid Category ID
                    } else {
                        $isValid = false;
                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_category_id"));
                    }
                }
                else {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_category_id"));
                }

                $editObjectDetails = array();
                if( $isValid && isset($_POST['SelecId']) && $_POST['SelecId'] != "" ) {
                    $editObjectDetails = $this->Utility_model->returnRecord("Menu_Selection", array("PK_SelecId","FK_SelecCatId","SelecName","SelecDefaultPrice"), array('PK_SelecId'=>$_POST['SelecId'], 'FK_SelecCatId'=>$_POST['SelCategoryId']));
                    if( is_array($editObjectDetails) ) {
                        //  Valid Sub Category ID
                    } else {
                        $isValid = false;
                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_selection_id"));
                    }
                }
                else {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_selection_id"));
                }


                if( $isValid ) {
                    $arrSendToView = array();

                    $arrSendToView['SegmentTitle'] = "Edit Selection";
                    $arrSendToView['ObjectDetails'] = $editObjectDetails;

                    $arrSendToView['CategoryList'] = $this->Utility_model->returnRecord("Menu_Selection_Category", array("PK_SelecCatId","SelecCatName"), array('SelecCatStatus'=>1), "SelecCatSortNo");

                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "content"=>$this->load->view('Selection/selection_form', $arrSendToView, true)));
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

    public function ajaxAddSelection( $selecCatId ) {
        $isValid = true;
        $returnRespond = array();

        if( $this->Admin_model->getAdminType() == 1 ) {
            $arrFrIns = array();
            parse_str($_POST['PostDataArr'], $arrFrIns);

            if( isset($arrFrIns['SelecName']) && trim($arrFrIns['SelecName']) != "" ) {
                $chkFlag = $this->Utility_model->returnRecord("Menu_Selection", false, array("SelecName"=>$arrFrIns['SelecName'], "FK_SelecCatId"=>$selecCatId));

                if( $chkFlag == FALSE ) {
                    $currentSelecCounter = $this->Utility_model->returnRecordCount('Menu_Selection', false, array("FK_SelecCatId"=>$selecCatId));
                    $arrFrIns['SelecSortNo'] = ($currentSelecCounter + 1);
                    $arrFrIns['FK_SelecCatId'] = $selecCatId;

                    //printArr($arrFrIns);

                    $newId = $this->Utility_model->insertRecort('Menu_Selection', $arrFrIns );

                    $tmpRespondArr = array();
                    if( $newId > 0 ) {
                        //  Updating the category table
                        $this->Utility_model->updateRecordReturnAffectedRowCount("Menu_Selection_Category", array("HasSelec"=>1), array("PK_SelecCatId"=>$selecCatId));

                        $tmpRespondArr['error_flag'] = FALSE;
                        $tmpRespondArr['code'] = "SUCCESS";
                        $tmpRespondArr['newId'] = $newId;

                        $tmpRespondArr['firstEntry'] = FALSE;
                        if( $currentSelecCounter == 0 ) {
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

    public function ajaxUpdateSelection( $selecId ) {
        $returnRespond = array();
        $isValid = true;

        if( $this->Admin_model->getAdminType() == 1 ) {
            $arrFrUpdateTmp = array();
            parse_str($_POST['PostDataArr'], $arrFrUpdateTmp);

            //printArr($arrFrUpdate);

            if( isset($arrFrUpdateTmp['SelecName']) && $arrFrUpdateTmp['SelecName'] != "" ) {
                $currnetDetails = $this->Utility_model->returnRecord("Menu_Selection", array('FK_SelecCatId','SelecName','SelecDefaultPrice'), array("PK_SelecId"=>$selecId));

                if( is_array($currnetDetails) ) {
                    $diffResult = array_diff_assoc($arrFrUpdateTmp, (array) $currnetDetails[0]);

                    if( count($diffResult) > 0 ) {
                        $arrForUpdateFinal = array();

                        foreach ( $diffResult as $diffKey=>$diffKeyValue ) {
                            if( $diffKey == "FK_SelecCatId" && $isValid ) {
                                if( $this->Utility_model->returnRecord("Menu_Selection", false, array('FK_SelecCatId'=>$arrFrUpdateTmp['FK_SelecCatId'], 'SelecName'=>$arrFrUpdateTmp['SelecName'])) == false ) {
                                    $arrForUpdateFinal['FK_SelecCatId'] = $arrFrUpdateTmp['FK_SelecCatId'];
                                }
                                else {
                                    $isValid = false;
                                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"ErrorAlreadyExist"));
                                }
                            }
                            else if( $diffKey == "SelecName" && $isValid ) {
                                if( $this->Utility_model->returnRecord("Menu_Selection", false, array('FK_SelecCatId'=>$arrFrUpdateTmp['FK_SelecCatId'], 'SelecName'=>$arrFrUpdateTmp['SelecName'])) == false ) {
                                    $arrForUpdateFinal['SelecName'] = $arrFrUpdateTmp['SelecName'];
                                }
                                else {
                                    $isValid = false;
                                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"ErrorAlreadyExist"));
                                }
                            }
                            else if( $diffKey == "SelecDefaultPrice" && $isValid ) {
                                $arrForUpdateFinal['SelecDefaultPrice'] = $arrFrUpdateTmp['SelecDefaultPrice'];
                            }
                        }

                        if( $isValid ) {
                            $countUpdateRow = $this->Utility_model->updateRecord('Menu_Selection', $arrForUpdateFinal, array("PK_SelecId"=>$selecId) );

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
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"SelecName_missing_error"));
            }
        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode( $returnRespond );
    }
    //  Selection Actions [ End ]
}