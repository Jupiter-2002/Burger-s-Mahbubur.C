<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminPaymentType extends MY_Controller {
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

            $arrSendToView['page_title'] = "Payment Type";
            $arrSendToView['SegmentTitle'] = "Payment Type";

            $arrSendToView['PaymentTypeArr'] = get_global_values('PaymentTypeArr');

            $arrSendToView['currentView'] = 'payment_type/payment_type_base';

            $arrSendToView['respnsHeader'] = 'admin/common/respns_header_admin';

			$this->load->view('admin/base_theme_frame',$arrSendToView);
		} else {
			session_destroy();
			header("Location: ".base_url());
		}
	}

    public function ajaxPaymentTypeList() {
        if( $this->Admin_model->getAdminType() == 1 ) {
            $data['recordList'] = $this->Utility_model->returnRecord("Restaurant_Payment_Type", false, false);
            $returnRespond = array("respond"=>array("error_flag"=>false, "content"=>$this->load->view('payment_type/payment_type_list', $data, true)));
            echo json_encode($returnRespond);
        } else {
            session_destroy();

            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"not_logged_in"));
            echo json_encode( $returnRespond );
        }
    }

    public function ajaxSavePaymentType() {
        $returnRespond = array();

        if( $this->Admin_model->getAdminType() == 1 ) {
            $arrFrIns = array();
            parse_str($_POST['PostDataArr'], $arrFrIns);

            if( isset($arrFrIns['PaymentTypeId']) && trim($arrFrIns['PaymentTypeId']) != "" ) {
                $chkFlag = $this->Utility_model->returnRecord("Restaurant_Payment_Type", false, array("PaymentTypeId"=>$arrFrIns['PaymentTypeId']));

                if( $chkFlag == FALSE ) {
                    $arrFrIns['Name'] = get_global_values('PaymentTypeArr', $arrFrIns['PaymentTypeId']);

                    $this->Utility_model->insertRecort('Restaurant_Payment_Type', $arrFrIns );

                    $tmpRespondArr['error_flag'] = FALSE;
                    $tmpRespondArr['code'] = "SUCCESS";

                    $returnRespond = array("respond"=>$tmpRespondArr);
                } else {
                    $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"ErrorAlreadyExist"));
                }
            }
            else {
                $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"ErrorPaymentTypeIdMissing"));
            }
        } else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"not_logged_in"));
        }

        echo json_encode( $returnRespond );
    }

    public function ajaxDeletePaymentType() {
        $returnRespond = array();

        if( $this->Admin_model->getAdminType() == 1 ) {

            if( isset($_POST['PaymentTypeId']) && trim($_POST['PaymentTypeId']) != "" ) {
                $chkFlag = $this->Utility_model->returnRecord("Restaurant_Payment_Type", false, array("PaymentTypeId"=>$_POST['PaymentTypeId']));

                if( $chkFlag == FALSE ) {
                    $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"ErrorDoesNotExist"));
                } else {
                    $this->db->delete('Restaurant_Payment_Type', array("PaymentTypeId"=>$_POST['PaymentTypeId']));

                    $tmpRespondArr['error_flag'] = FALSE;
                    $tmpRespondArr['code'] = "SUCCESS";

                    $returnRespond = array("respond"=>$tmpRespondArr);
                }
            }
            else {
                $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"ErrorPaymentTypeIdMissing"));
            }
        } else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"not_logged_in"));
        }

        echo json_encode( $returnRespond );
    }









}
