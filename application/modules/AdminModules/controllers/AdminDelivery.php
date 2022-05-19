    <?php
//  NOT DONE

defined('BASEPATH') OR exit('No direct script access allowed');

class AdminDelivery extends MY_Controller {
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

            $arrSendToView['page_title'] = "Delivery Area Management";
            $arrSendToView['SegmentTitle'] = "Delivery Area";

            $arrSendToView['currentView'] = 'Delivery/delivery_base';
            $arrSendToView['respnsHeader'] = 'admin/common/respns_header_admin';

            //	For Populating Button On Top Heading
            $arrSendToView['topjQueryHeadingButtonList'] = (object) array( (object) array("event"=>"onclick", "eventFunction"=>"openAddDiscountDiv()", "class"=>"bars", "label"=>"Add Discount"));

            $this->load->view('admin/base_theme_frame',$arrSendToView);
		} else {
			session_destroy();
			header("Location: ".base_url());
		}
	}

    public function ajaxDeliveryList() {
        if( $this->Admin_model->getAdminType() == 1 ) {
            $data['recordList'] = $this->Utility_model->returnRecord("delivery_area");
            $returnRespond = array("respond"=>array("error_flag"=>false, "content"=>$this->load->view('Delivery/delivery_list', $data, true)));
            echo json_encode($returnRespond);
        } else {
            session_destroy();
            header("Location: ".base_url());
        }
    }

    public function ajaxAddDelivery() {
        $returnRespond = array();

        if( $this->Admin_model->getAdminType() == 1 ) {
            $arrFrInsert = $_POST;

            $arrFrInsert['HalfPostCodeFlag'] = 0;
            if( isset($arrFrInsert['PostCodeList']) && $arrFrInsert['PostCodeList'] != "" ) {
                $arrFrInsert['HalfPostCode'] = "";
                $arrFrInsert['PostCodeList'] = strtoupper($arrFrInsert['PostCodeList']).",";
            }
            else if ( isset($arrFrInsert['HalfPostCode']) && $arrFrInsert['HalfPostCode'] != "" ) {
                $arrFrInsert['HalfPostCodeFlag'] = 1;
                $arrFrInsert['HalfPostCode'] = strtoupper($arrFrInsert['HalfPostCode']).",";
            }

            $newInsertedId = $this->Utility_model->insertRecort('delivery_area', $arrFrInsert );

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

    public function ajaxDeliveryForm() {
        $returnRespond = array();
        if( $this->Admin_model->getAdminType() == 1 ) {

            if( isset($_POST['Action']) && $_POST['Action'] == "editDelivery" ) {
                sleep(1);
                if( isset($_POST['DeliveryAreaID']) && $_POST['DeliveryAreaID'] != "" ) {
                    $arrSendToView = array();
                    $arrSendToView['SegmentTitle'] = "Edit Delivery Area";
                    $arrSendToView['deliveryDetails'] = $this->Utility_model->returnRecord("delivery_area", false, array('PK_DeliveryAreaID'=>$_POST['DeliveryAreaID']));

                    if( is_array($arrSendToView['deliveryDetails']) ) {
                        $returnRespond = array("respond"=>array("error_flag"=>false, "content"=>$arrSendToView));
                    } else {
                        $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"invalid_delivery_id"));
                    }
                }
                else {
                    $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"missing_delivery_id"));
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





    public function ajaxUpdateDelivery( $deliveryAreaId ) {
        $returnRespond = array();

        if( $this->Admin_model->getAdminType() == 1 ) {
            $currnetDetails = $this->Utility_model->returnRecord("delivery_area", false, array("PK_DeliveryAreaID"=>$deliveryAreaId));

            //printArr($currnetDetails);

            if( is_array($currnetDetails) ) {
                $diffResult = array_diff_assoc($_POST, (array) $currnetDetails[0]);

                if( count($diffResult) > 0 ) {
                    $countUpdateRow = $this->Utility_model->updateRecord('delivery_area', $diffResult, array("PK_DeliveryAreaID"=>$deliveryAreaId) );

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
                $returnRespond = array("respond"=>array("error_flag"=>false, "error_msg"=>"invalidDeliveryAreaId"));
            }


        } else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"not_logged_in"));
        }

        echo json_encode( $returnRespond );
    }


















    /*


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
    */



}
