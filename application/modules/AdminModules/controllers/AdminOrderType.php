<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminOrderType extends MY_Controller {
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

            $arrSendToView['page_title'] = "Order Type";
            $arrSendToView['SegmentTitle'] = "Order Type";

            $arrSendToView['OrderTypeArr'] = get_global_values('OrderTypeArr');

            $arrSendToView['currentView'] = 'order_type/order_type_base';

            $arrSendToView['respnsHeader'] = 'admin/common/respns_header_admin';

			$this->load->view('admin/base_theme_frame',$arrSendToView);
		} else {
			session_destroy();
			header("Location: ".base_url());
		}
	}

    public function ajaxOrderTypeList() {
        if( $this->Admin_model->getAdminType() == 1 ) {
            $data['recordList'] = $this->Utility_model->returnRecord("Restaurant_Order_Type", false, false);
            $returnRespond = array("respond"=>array("error_flag"=>false, "content"=>$this->load->view('order_type/order_type_list', $data, true)));
            echo json_encode($returnRespond);
        } else {
            session_destroy();

            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"not_logged_in"));
            echo json_encode( $returnRespond );
        }
    }

    public function ajaxSaveOrderType() {
        $returnRespond = array();

        if( $this->Admin_model->getAdminType() == 1 ) {
            $arrFrIns = array();
            parse_str($_POST['PostDataArr'], $arrFrIns);

            if( isset($arrFrIns['OrderTypeId']) && trim($arrFrIns['OrderTypeId']) != "" ) {
                $chkFlag = $this->Utility_model->returnRecord("Restaurant_Order_Type", false, array("OrderTypeId"=>$arrFrIns['OrderTypeId']));

                if( $chkFlag == FALSE ) {
                    $arrFrIns['Name'] = get_global_values('OrderTypeArr', $arrFrIns['OrderTypeId']);

                    $this->Utility_model->insertRecort('Restaurant_Order_Type', $arrFrIns );

                    $tmpRespondArr['error_flag'] = FALSE;
                    $tmpRespondArr['code'] = "SUCCESS";

                    $returnRespond = array("respond"=>$tmpRespondArr);
                } else {
                    $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"ErrorAlreadyExist"));
                }
            }
            else {
                $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"ErrorOrderTypeIdMissing"));
            }
        } else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"not_logged_in"));
        }

        echo json_encode( $returnRespond );
    }

    public function ajaxDeleteOrderType() {
        $returnRespond = array();

        if( $this->Admin_model->getAdminType() == 1 ) {

            if( isset($_POST['OrderTypeId']) && trim($_POST['OrderTypeId']) != "" ) {
                $chkFlag = $this->Utility_model->returnRecord("Restaurant_Order_Type", false, array("OrderTypeId"=>$_POST['OrderTypeId']));

                if( $chkFlag == FALSE ) {
                    $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"ErrorDoesNotExist"));
                } else {
                    $this->db->delete('Restaurant_Order_Type', array("OrderTypeId"=>$_POST['OrderTypeId']));

                    $tmpRespondArr['error_flag'] = FALSE;
                    $tmpRespondArr['code'] = "SUCCESS";

                    $returnRespond = array("respond"=>$tmpRespondArr);
                }
            }
            else {
                $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"ErrorOrderTypeIdMissing"));
            }
        } else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"not_logged_in"));
        }

        echo json_encode( $returnRespond );
    }









}
