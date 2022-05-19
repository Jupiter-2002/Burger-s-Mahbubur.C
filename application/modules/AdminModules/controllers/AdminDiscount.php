<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminDiscount extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Admin_model');
		$this->load->model('Utility_model');

		if( !$this->Admin_model->isLoggedIn() ) {
			session_destroy();
			header("Location: ".base_url());
		}
	}

	public function index()	{
		if( $this->Admin_model->getAdminType() == 1 ) {
            $arrSendToView = array();

            $arrSendToView['page_title'] = "Discount";
            $arrSendToView['SegmentTitle'] = "Discount Form";

            $arrSendToView['OrderTypeArr'] = get_global_values('OrderTypeArr');
            $arrSendToView['DiscountTypeArr'] = get_global_values('DiscountTypeArr');

            $arrSendToView['currentView'] = 'Discount/discount_base';
            $arrSendToView['respnsHeader'] = 'admin/common/respns_header_admin';

            //	For Populating Button On Top Heading
            $arrSendToView['topjQueryHeadingButtonList'] = (object) array( (object) array("event"=>"onclick", "eventFunction"=>"openAddDiscountDiv()", "class"=>"bars", "label"=>"Add Discount"));

            $this->load->view('admin/base_theme_frame',$arrSendToView);
		} else {
			session_destroy();
			header("Location: ".base_url());
		}
	}

    public function ajaxDiscountList() {
        if( $this->Admin_model->getAdminType() == 1 ) {
            $data['recordList'] = $this->Utility_model->returnRecord("Restaurant_Discount");
            $returnRespond = array("respond"=>array("error_flag"=>false, "content"=>$this->load->view('Discount/discount_list', $data, true)));
            echo json_encode($returnRespond);
        } else {
            session_destroy();
            header("Location: ".base_url());
        }
    }

    public function ajaxDiscountForm() {
        $returnRespond = array();
        if( $this->Admin_model->getAdminType() == 1 ) {

            if( isset($_POST['Action']) && $_POST['Action'] == "editDiscount" ) {
                sleep(1);
                if( isset($_POST['discountId']) && $_POST['discountId'] != "" ) {
                    $arrSendToView = array();
                    $arrSendToView['SegmentTitle'] = "Edit Discount";
                    $arrSendToView['discountDetails'] = $this->Utility_model->returnRecord("Restaurant_Discount", false, array('PK_DiscountId'=>$_POST['discountId']));

                    if( is_array($arrSendToView['discountDetails']) ) {
                        //printArr($arrSendToView['discountDetails']);
                        $arrSendToView['discountDetails'][0]->StartDate = dateForDisplay(strtotime($arrSendToView['discountDetails'][0]->StartDate));
                        $arrSendToView['discountDetails'][0]->EndDate = dateForDisplay(strtotime($arrSendToView['discountDetails'][0]->EndDate));

                        $returnRespond = array("respond"=>array("error_flag"=>false, "content"=>$arrSendToView));
                    } else {
                        $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"invalid_discount_id"));
                    }
                }
                else {
                    $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"missing_discount_id"));
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

	public function ajaxAddDiscount() {
        $returnRespond = array();

        if( $this->Admin_model->getAdminType() == 1 ) {
            $arrFrInsert = $_POST;
            $arrFrInsert['StartDate'] = dateForDb(strtotime($_POST['StartDate']));
            $arrFrInsert['EndDate'] = dateForDb(strtotime($_POST['EndDate']));
            $newInsertedId = $this->Utility_model->insertRecort('Restaurant_Discount', $arrFrInsert );

            //echo $this->db->last_query();

            $tmpRespondArr = array();
            if( $newInsertedId > 0 ) {
                $tmpRespondArr['error_flag'] = FALSE;
                $tmpRespondArr['code'] = "SUCCESS";
                $tmpRespondArr['newInsertedId'] = $newInsertedId;
            } else {
                $tmpRespondArr['error_flag'] = TRUE;
                $tmpRespondArr['error_msg'] = "DbInsertError";
            }

            $returnRespond = array("respond"=>$tmpRespondArr);
        } else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"not_logged_in"));
        }

        echo json_encode( $returnRespond );
    }

    public function ajaxUpdateDiscount( $discountId ) {
        $returnRespond = array();

        if( $this->Admin_model->getAdminType() == 1 ) {
            $currnetDetails = $this->Utility_model->returnRecord("Restaurant_Discount", "OrderTypeId, DiscountType, DiscountAmount, StartAmount, EndAmount, StartDate, EndDate", array("PK_DiscountId"=>$discountId));

            //printArr($currnetDetails);

            if( is_array($currnetDetails) ) {
                if( isset($_POST['StartDate']) && $_POST['StartDate'] != "" ) {
                    $_POST['StartDate'] = dateForDb(strtotime($_POST['StartDate']));
                }
                if( isset($_POST['EndDate']) && $_POST['EndDate'] != "" ) {
                    $_POST['EndDate'] = dateForDb(strtotime($_POST['EndDate']));
                }
                $diffResult = array_diff_assoc($_POST, (array) $currnetDetails[0]);

                //printArr($diffResult);

                if( count($diffResult) > 0 ) {
                    $countUpdateRow = $this->Utility_model->updateRecord('Restaurant_Discount', $diffResult, array("PK_DiscountId"=>$discountId) );

                    if( $countUpdateRow > 0 ) {
                        $returnRespond = array("respond"=>array("error_flag"=>FALSE, "error_msg"=>"SUCCESS"));
                    } else {
                        $returnRespond = array("respond"=>array("error_flag"=>TRUE, "error_msg"=>"DbInsertError"));
                    }
                }
                else {
                    $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"no_Changes"));
                }
            }
            else {
                $returnRespond = array("respond"=>array("error_flag"=>false, "error_msg"=>"invalidDiscountId"));
            }
        } else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"not_logged_in"));
        }

        echo json_encode( $returnRespond );
    }

    public function ajaxDeleteDiscount() {
        $returnRespond = array();

        if( $this->Admin_model->getAdminType() == 1 ) {
            if( isset($_POST['discountId']) && trim($_POST['discountId']) != "" ) {
                $chkFlag = $this->Utility_model->returnRecord("Restaurant_Discount", false, array("PK_DiscountId"=>$_POST['discountId']));

                if( $chkFlag == FALSE ) {
                    $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"ErrorDoesNotExist"));
                } else {
                    $this->db->delete('Restaurant_Discount', array("PK_DiscountId"=>$_POST['discountId']));

                    $tmpRespondArr['error_flag'] = FALSE;
                    $tmpRespondArr['code'] = "SUCCESS";

                    $returnRespond = array("respond"=>$tmpRespondArr);
                }
            }
            else {
                $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"ErrorDiscountIdMissing"));
            }
        } else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"not_logged_in"));
        }

        echo json_encode( $returnRespond );
    }



}
