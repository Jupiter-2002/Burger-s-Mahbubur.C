<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminCategory extends MY_Controller {
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
            //	For Category Dropdown
            $data['catListDropdown'] = $this->Utility_model->returnRecord("Menu_Category", false, false, "CatSortNo");

		    //  Admin Dashboard
            $data['page_title'] = "Category";
			$data['respnsHeader'] = 'admin/common/respns_header_admin';

            $data['currentView'] = 'Category/category_base';

            //	For Populating Button On Top Heading
            $data['topjQueryHeadingButtonList'] = (object) array( (object) array("event"=>"onclick", "eventFunction"=>"openAddCategoryDiv()", "class"=>"bars", "label"=>"Add Category"));

			$this->load->view('admin/base_theme_frame',$data);
		} else {
			session_destroy();
			header("Location: ".base_url());
		}
	}


    //  Category Actions [ START ]
	public function ajaxCategoryList() {
        if( $this->Admin_model->getAdminType() == 1 ) {
            $data['categoryList'] = $this->Utility_model->returnRecord("Menu_Category", false, false, "CatSortNo");
            $returnRespond = array("respond"=>array("error_flag"=>false, "content"=>$this->load->view('Category/category_list', $data, true)));
            echo json_encode($returnRespond);
        }
        else {
            session_destroy();
            header("Location: ".base_url());
        }
    }

	public function ajaxCategoryForm() {
	    $returnRespond = array();
        if( $this->Admin_model->getAdminType() == 1 ) {
            if( isset($_POST['Action']) && $_POST['Action'] == "addCategory" ) {
                sleep(1);
                $returnRespond = array("respond"=>array("error_flag"=>false, "content"=>$this->load->view('Category/category_form', array("SegmentTitle"=>"Add New Category"), true)));
            }
            else if( isset($_POST['Action']) && $_POST['Action'] == "editCategory" ) {
                sleep(1);
                if( isset($_POST['CategoryId']) && $_POST['CategoryId'] != "" ) {
                    $arrSendToView = array();

                    $arrSendToView['SegmentTitle'] = "Edit Category";
                    $arrSendToView['CategoryId'] = $_POST['CategoryId'];
                    $arrSendToView['CategoryDetails'] = $this->Utility_model->returnRecord("Menu_Category", false, array('PK_CatId'=>$arrSendToView['CategoryId']), "CatSortNo");

                    if( is_array($arrSendToView['CategoryDetails']) ) {
                        $returnRespond = array("respond"=>array("error_flag"=>false, "content"=>$this->load->view('Category/category_form', $arrSendToView, true)));
                    } else {
                        $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"invalid_category_id"));
                    }
                }
                else {
                    $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"no_category_id"));
                }
            }
            else {
                $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"no_action"));
            }
        }
        else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }

    public function ajaxAddCategory() {
	    $returnRespond = array();

        if( $this->Admin_model->getAdminType() == 1 ) {
            if( isset($_POST['CatName']) && trim($_POST['CatName']) != "" ) {
                $arrCategoryIns = $_POST;

                $chkAddCatFlag = $this->Utility_model->returnRecord("Menu_Category", false, array("CatName"=>$arrCategoryIns['CatName']));

                if( $chkAddCatFlag == FALSE ) {
                    $arrCategoryIns['CatSortNo'] = ($this->Utility_model->returnRecordCount('Menu_Category') + 1);
                    $newCatId = $this->Utility_model->insertRecort('Menu_Category', $arrCategoryIns );

                    $tmpRespondArr = array();
                    if( $newCatId > 0 ) {
                        $tmpRespondArr['error_flag'] = FALSE;
                        $tmpRespondArr['code'] = "SUCCESS";
                        $tmpRespondArr['newCatId'] = $newCatId;
                    } else {
                        $tmpRespondArr['error_flag'] = TRUE;
                        $tmpRespondArr['error_msg'] = "DbInsertError";
                    }

                    $returnRespond = array("respond"=>$tmpRespondArr);
                } else {
                    $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"ErrorAlreadyExistCategory"));
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

    public function ajaxUpdateCategory( $catId ) {
        $returnRespond = array();

        if( $this->Admin_model->getAdminType() == 1 ) {
            if( isset($_POST['CatName']) && trim($_POST['CatName']) != "" ) {
                $arrCategoryUpdate = $_POST;

                $chkAddCatFlag = $this->Utility_model->returnRecord("Menu_Category", false, array("CatName"=>$arrCategoryUpdate['CatName'],"PK_CatId != "=>$catId));

                if( $chkAddCatFlag == FALSE ) {
                    $countUpdateRow = $this->Utility_model->updateRecord('Menu_Category', $arrCategoryUpdate, array("PK_CatId"=>$catId) );

                    $tmpRespondArr = array();
                    if( $countUpdateRow > 0 ) {
                        $tmpRespondArr['error_flag'] = FALSE;
                        $tmpRespondArr['error_msg'] = "SUCCESS";
                    } else {
                        $tmpRespondArr['error_flag'] = TRUE;
                        $tmpRespondArr['error_msg'] = "DbInsertError";
                    }

                    $returnRespond = array("respond"=>$tmpRespondArr);
                } else {
                    $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"ErrorAlreadyExistCategory"));
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
    //  Category Actions [ END ]


    //  Sub Category Actions [ START ]
    public function ajaxSubCategoryList( $catId ) {
        if( $this->Admin_model->getAdminType() == 1 ) {
            if( isset($catId) && $catId != "" ) {
                $arrSendToView['CategoryDetails'] = $this->Utility_model->returnRecord("Menu_Category", false, array('PK_CatId'=>$catId));
                if( is_array($arrSendToView['CategoryDetails']) ) {
                    $arrSendToView['subCategoryList'] = $this->Utility_model->returnRecord("Menu_Sub_Category", false, array("FK_CatId"=>$catId), "SubCatSortNo");

                    $returnRespond = array("respond"=>array("error_flag"=>false, "content"=>$this->load->view('SubCategory/sub_category_list', $arrSendToView, true)));
                }
                else {  $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"invalid_category_id"));   }
            }
            else {  $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"category_id_missing"));   }
        }
        else {  $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"not_logged_in"));     }

        echo json_encode($returnRespond);
    }

    public function ajaxSubCategoryForm() {
        $returnRespond = array();
        if( $this->Admin_model->getAdminType() == 1 ) {
            if( isset($_POST['Action']) && $_POST['Action'] == "addSubCategory" ) {
                $isValid = true;
                if( isset($_POST['CategoryId']) && $_POST['CategoryId'] != "" ) {
                    sleep(1);
                    $arrSendToView = array();

                    $arrSendToView['SegmentTitle'] = "Add New Sub Category";
                    $arrSendToView['arrCategoryDetails'] = $this->Utility_model->returnRecord("Menu_Category", false, array("PK_CatId"=>$_POST['CategoryId']));


                    if( $arrSendToView['arrCategoryDetails'] != FALSE && is_array($arrSendToView['arrCategoryDetails']) ) {
                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "content"=>$this->load->view('SubCategory/sub_category_form', $arrSendToView, true)));
                    } else {
                        $isValid = false;
                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"wrong_cat_id"));
                    }
                }
                else {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_cat_id"));
                }
            }
            else if( isset($_POST['Action']) && $_POST['Action'] == "editSubCategory" ) {
                sleep(1);
                $isValid = true;

                if( isset($_POST['CategoryId']) && $_POST['CategoryId'] != "" ) {
                    if( is_array($this->Utility_model->returnRecord("Menu_Category", false, array('PK_CatId'=>$_POST['CategoryId']))) ) {
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

                $subCategoryDetails = array();
                if( $isValid && isset($_POST['SubCategoryId']) && $_POST['SubCategoryId'] != "" ) {
                    $subCategoryDetails = $this->Utility_model->returnRecord("Menu_Sub_Category", false, array('PK_SubCatId'=>$_POST['SubCategoryId'], 'FK_CatId'=>$_POST['CategoryId']));
                    if( is_array($subCategoryDetails) ) {
                        //  Valid Sub Category ID
                    } else {
                        $isValid = false;
                        $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"invalid_sub_category_id"));
                    }
                }
                else {
                    $isValid = false;
                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_sub_category_id"));
                }


                if( $isValid ) {
                    $arrSendToView = array();

                    $arrSendToView['SegmentTitle'] = "Edit Sub Category";
                    $arrSendToView['SubCategoryDetails'] = $subCategoryDetails;

                    $arrSendToView['CategoryList'] = $this->Utility_model->returnRecord("Menu_Category", array("PK_CatId","CatName"), array('CatStatus'=>1), "CatSortNo");

                    $returnRespond = array("respond"=>array("error_flag"=>false, "content"=>$this->load->view('SubCategory/sub_category_form', $arrSendToView, true)));
                }
            }
            else {
                $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"no_action"));
            }
        }
        else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }

    public function ajaxAddSubCategory( $catId ) {
        $returnRespond = array();

        if( $this->Admin_model->getAdminType() == 1 ) {

            if( isset($_POST['SubCatName']) && trim($_POST['SubCatName']) != "" ) {
                $arrSubCategoryIns = $_POST;

                $chkAddSubCatFlag = $this->Utility_model->returnRecord("Menu_Sub_Category", false, array("SubCatName"=>$arrSubCategoryIns['SubCatName'], "FK_CatId"=>$catId));

                if( $chkAddSubCatFlag == FALSE ) {
                    $arrSubCategoryIns['FK_CatId'] = $catId;
                    $arrSubCategoryIns['SubCatSortNo'] = ($this->Utility_model->returnRecordCount('Menu_Sub_Category', false, array("FK_CatId"=>$catId)) + 1);
                    $newSubCatId = $this->Utility_model->insertRecort('Menu_Sub_Category', $arrSubCategoryIns );

                    $tmpRespondArr = array();
                    if( $newSubCatId > 0 ) {
                        //  Updating the category table
                        $this->Utility_model->updateRecordReturnAffectedRowCount("Menu_Category", array("HasSubCat"=>1), array("PK_CatId"=>$catId));

                        $tmpRespondArr['error_flag'] = FALSE;
                        $tmpRespondArr['code'] = "SUCCESS";
                        $tmpRespondArr['newSubCatId'] = $newSubCatId;
                    } else {
                        $tmpRespondArr['error_flag'] = TRUE;
                        $tmpRespondArr['error_msg'] = "DbInsertError";
                    }

                    $returnRespond = array("respond"=>$tmpRespondArr);
                }
                else {  $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"ErrorAlreadyExistSubCategory"));    }
            }
            else {  $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"ErrorNameFieldMissing"));   }
        }
        else {  $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"not_logged_in"));     }

        echo json_encode( $returnRespond );
    }

    public function ajaxUpdateSubCategory( $subCatId ) {
	    $returnRespond = array();

        $isValid = true;
        if( $this->Admin_model->getAdminType() == 1 ) {

            $currnetSubCategoryDetails = $this->Utility_model->returnRecord("Menu_Sub_Category", "FK_CatId, SubCatName, SubCatDiscount, SubCatDesc", array("PK_SubCatId"=>$subCatId));

            if( is_array($currnetSubCategoryDetails) ) {

                //  Checking for Different Values
                $diffResult = array_diff((array) $currnetSubCategoryDetails[0], $_POST);

                if( count($diffResult) > 0 ) {
                    $arrForUpdate = array();

                    foreach ( $diffResult as $diffKey=>$diffKeyValue ) {
                        if( $diffKey == "FK_CatId" ) {
                            if( isset($_POST['FK_CatId']) && $_POST['FK_CatId'] != "" ) {
                                if( is_array($this->Utility_model->returnRecord("Menu_Category", false, array('PK_CatId'=>$_POST['FK_CatId']))) ) {
                                    $arrForUpdate['FK_CatId'] = $_POST['FK_CatId'];
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

                        if( $diffKey == "SubCatName" ) {
                            if( $isValid && isset($_POST['SubCatName']) && $_POST['SubCatName'] != "" ) {
                                if( is_array(  $this->Utility_model->returnRecord("Menu_Sub_Category", false, array("SubCatName"=>$_POST['SubCatName'], "FK_CatId"=>$_POST['FK_CatId']))  ) ) {
                                    $isValid = false;
                                    $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"already_exist_SubCatName"));
                                }
                                else {
                                    $arrForUpdate['SubCatName'] = $_POST['SubCatName'];
                                }
                            }
                            else {
                                $isValid = false;
                                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_SubCatName"));
                            }
                        }

                        if( $diffKey == "SubCatDiscount" ) {
                            $arrForUpdate['SubCatDiscount'] = $_POST['SubCatDiscount'];
                        }

                        if( $diffKey == "SubCatDesc" ) {
                            $arrForUpdate['SubCatDesc'] = $_POST['SubCatDesc'];
                        }
                    }


                    if( $isValid ) {
                        $countUpdateRow = $this->Utility_model->updateRecord('Menu_Sub_Category', $arrForUpdate, array("PK_SubCatId"=>$subCatId) );

                        $tmpRespondArr = array();
                        if( $countUpdateRow > 0 ) {
                            $tmpRespondArr['error_flag'] = FALSE;
                            $tmpRespondArr['code'] = "SUCCESS";
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

            } else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"sub_cat_id_error"));
            }
        } else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
        }

        echo json_encode( $returnRespond );
    }
    //  Sub Category Actions [ END ]
}