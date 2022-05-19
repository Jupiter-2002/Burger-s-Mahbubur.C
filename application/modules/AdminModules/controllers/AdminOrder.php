<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminOrder extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Admin_model');
		$this->load->model('Utility_model');
        $this->load->model('Order_model');

		if( !$this->Admin_model->isLoggedIn() ) {
			session_destroy();
			header("Location: ".base_url());
		}
	}

	public function index()	{
		if( $this->Admin_model->getAdminType() == 1 ) {
            $arrSendToView = array();

            $arrSendToView['page_title'] = "Order List";
            //$arrSendToView['SegmentTitle'] = "Discount Form";

            $arrSendToView['currentView'] = 'Order/orderList';
            $arrSendToView['respnsHeader'] = 'admin/common/respns_header_admin';


            $arrSendToView['orderStatus'] = get_global_values('OrderStatusArr');

            //  For the Order List
            $arrCondition = array();

            if( isset($_POST['SubmitBTN']) && $_POST['SubmitBTN'] == "Submit" ) {
                if( isset($_POST['startDate']) && $_POST['startDate'] != "" ) {
                    $arrCondition['OrderDateTime > '] = dateForDb(strtotime($_POST['startDate']));
                }
                if( isset($_POST['endDate']) && $_POST['endDate'] != "" ) {
                    $arrCondition['OrderDateTime < '] = dateForDb(strtotime($_POST['endDate']));
                }
                if( isset($_POST['Status']) && $_POST['Status'] != "" ) {
                    $arrCondition['Status'] = $_POST['Status'];
                }
            }

            if( empty($arrCondition) ) {
                $arrCondition['Status'] = 0;
            }

            //  Columns From 'customer'
            $strSelect = "customer.CustFirstName, customer.CustLastName, customer.CustEmail, ";
            $strSelect .= "order_summary.OrderSummaryId, order_summary.Status, order_summary.OrderType, order_summary.PaymentType, ";
            $strSelect .= "order_summary.OrderDateTime, order_summary.DeliveryDate, order_summary.DeliveryTime, ";


            $strSelect .= "order_summary.TotalWithoutCCFee, order_summary.CreditCardFee";

            //printArr($arrCondition);

            $arrSendToView['recordList'] = $this->Order_model->returnOrderListWithCustomer($strSelect, $arrCondition);

            //echo $this->db->last_query();

            $this->load->view('admin/base_theme_frame',$arrSendToView);
		} else {
			session_destroy();
			header("Location: ".base_url());
		}
	}

    public function orderDetails( $encodeOrderId ) {
        //printArr($_SESSION);

        if( $this->Admin_model->getAdminType() == 1 ) {
            $orderId = decodeURLVal($encodeOrderId);


            if( isset($_POST['StatusUpdate']) && $_POST['StatusUpdate'] == "Update" ) {
                $arrUpdateData['Status'] = $_POST['Status'];
                $arrUpdateData['PaymentStatus'] = $_POST['PaymentStatus'];
                $arrUpdateData['RestaurantComments'] = $_POST['RestaurantComments'];

                $affectedRows = $this->Utility_model->updateRecordReturnAffectedRowCount('order_summary', $arrUpdateData, array('OrderSummaryId' => $orderId));

                //echo $this->db->last_query();


                $arrSendToView = array();
                $arrSendToView['orderDetails'] = $this->Order_model->returnOrderDetailsByIdWithCustomer($orderId);

                //printArr($arrSendToView['orderDetails']);

                if( $affectedRows == 1 ) {
                    //  Row Updated Do Triggers
                    $arrSendToMail = array();

                    $flagSendMail = true;

                    if( $arrUpdateData['Status'] == 0 ) {
                        $flagSendMail = false;
                    }
                    if( $arrUpdateData['Status'] == 1 ) {
                        //  Order Accepted
                        $arrSendToMail['mailView'] = "mail/admin/OrderStatus";
                        $arrSendToMail['mailContent']['title'] = "Order Accepted [#".orderIdEncode($orderId)."]";
                        $arrSendToMail['mailContent']['content'] = "Hello ".$arrSendToView['orderDetails']['customer_detail']->CustFirstName.", ";
                        $arrSendToMail['mailContent']['content'] .= "your order [#".orderIdEncode($orderId)."] is accepted at ".$_SESSION['RestaurantBasic']->RestName.". Thank you for considering us.";
                    }
                    if( $arrUpdateData['Status'] == 2 ) {
                        //  Order Rejected
                        $arrSendToMail['mailView'] = "mail/admin/OrderStatus";
                        $arrSendToMail['mailContent']['title'] = "Order Rejected [#".orderIdEncode($orderId)."]";
                        $arrSendToMail['mailContent']['content'] = "Hello ".$arrSendToView['orderDetails']['customer_detail']->CustFirstName.", ";
                        $arrSendToMail['mailContent']['content'] .= "we are extremely sorry to inform you that your order [#".orderIdEncode($orderId)."] was rejected. Thank you for considering us.";
                    }


                    if( $flagSendMail == true ) {
                        $mailTo = $arrSendToView['orderDetails']['customer_detail']->CustEmail;
                        $mailFrom = $_SESSION['RestaurantBasic']->RestEMail;
                        $mailTitle = $arrSendToMail['mailContent']['title'];


                        $mailBody = $this->load->view('mail/mail_base_frame', $arrSendToMail);



                        sendMail($mailTo, $mailFrom, $mailTitle, $mailBody);
                        //echo $this->load->view('mail/mail_base_frame');
                    }
                }
            }

            if( $arrSendToView['orderDetails'] != false ) {
                $arrSendToView['page_title'] = "Order Details: #".orderIdEncode($orderId);
                //$arrSendToView['SegmentTitle'] = "Discount Form";

                $arrSendToView['currentView'] = 'Order/orderDetails';
                $arrSendToView['respnsHeader'] = 'admin/common/respns_header_admin';


                //  Fields Value
                $arrSendToView['orderStatus'] = get_global_values('OrderStatusArr');

                $this->load->view('admin/base_theme_frame',$arrSendToView);
            } else {
                session_destroy();
                header("Location: ".base_url());
            }
        } else {
            session_destroy();
            header("Location: ".base_url());
        }
    }










}
