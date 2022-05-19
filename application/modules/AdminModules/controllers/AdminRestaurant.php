<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminRestaurant extends MY_Controller {
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

            $arrSendToView['page_title'] = "Restaurant";
            $arrSendToView['SegmentTitle'] = "Restaurant Details";

            $arrSendToView['dataArr'] = $this->Utility_model->returnRecord("restaurant_info", false, false);

            printArr($arrSendToView['dataArr']);

            $arrSendToView['currentView'] = 'Restaurant/restaurant_details';

            $arrSendToView['respnsHeader'] = 'admin/common/respns_header_admin';

			$this->load->view('admin/base_theme_frame',$arrSendToView);
		} else {
			session_destroy();
			header("Location: ".base_url());
		}
	}

    public function ajaxUpdateRestaurantDetails( $restaurantId = 1971 ) {
        $returnRespond = array();

        if( $this->Admin_model->getAdminType() == 1 ) {
            $currnetDetails = $this->Utility_model->returnRecord("restaurant_info", false, array("RestId"=>$restaurantId));

            if( is_array($currnetDetails) ) {
                $diffResult = array_diff_assoc($_POST, (array) $currnetDetails[0]);

                if( count($diffResult) > 0 ) {
                    $countUpdateRow = $this->Utility_model->updateRecord('restaurant_info', $diffResult, array("RestId"=>$restaurantId) );

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
        } else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"not_logged_in"));
        }

        echo json_encode( $returnRespond );
    }

    public function ownerDetails()	{
        if( $this->Admin_model->getAdminType() == 1 ) {
            $arrSendToView = array();

            $arrSendToView['page_title'] = "Restaurant Owner";
            $arrSendToView['SegmentTitle'] = "Owner Details";

            $arrSendToView['dataArr'] = $this->Utility_model->returnRecord("restaurant_owner_info", false, false);

            $arrSendToView['currentView'] = 'Restaurant/restaurant_owner_details';

            $arrSendToView['respnsHeader'] = 'admin/common/respns_header_admin';

            $this->load->view('admin/base_theme_frame',$arrSendToView);
        } else {
            session_destroy();
            header("Location: ".base_url());
        }
    }

    public function ajaxUpdateRestaurantOwnerDetails( $PK_OwnerId = 1 ) {
        $returnRespond = array();

        if( $this->Admin_model->getAdminType() == 1 ) {
            $currnetDetails = $this->Utility_model->returnRecord("restaurant_owner_info", false, array("PK_OwnerId"=>$PK_OwnerId));

            if( is_array($currnetDetails) ) {
                $diffResult = array_diff_assoc($_POST, (array) $currnetDetails[0]);

                if( count($diffResult) > 0 ) {
                    $countUpdateRow = $this->Utility_model->updateRecord('restaurant_owner_info', $diffResult, array("PK_OwnerId"=>$PK_OwnerId) );

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
        }
        else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"not_logged_in"));
        }

        echo json_encode( $returnRespond );
    }








}
