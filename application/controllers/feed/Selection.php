<?php
/*
 * THIS IS FOR ALL THE CATEGORY RELATED FEEDS
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Selection extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Admin_model');
		$this->load->model('Utility_model');
	}

	/*
	 * This can be called from both admin and front end so we need to check if the user is logged in or not based on
	 * cases. We are using '$chkLoggedIn' to determine if login check is needed or not.
	 */
	public function selectionCategoryList( $chkLoggedIn ) {
        $returnRespond = array();
        $isValid = true;

	    if( $chkLoggedIn ) {
            if( $this->Admin_model->isLoggedIn() ) {
                //  NOTHING FOR NOW
            }
            else {
                $isValid = false;
                $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"not_logged_in"));
            }
        }

        if( $isValid ) {
            $arrCondition = array();

            if( isset($_POST['SelecCatStatus']) && $_POST['SelecCatStatus'] != "" ) {
                $arrCondition['SelecCatStatus'] = $_POST['SelecCatStatus'];
            }

            $arrSendToRespond['arrSelectionDetails'] = $this->Utility_model->returnRecord("Menu_Selection_Category", false, $arrCondition);


            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "content"=>$arrSendToRespond));
        }

        echo json_encode($returnRespond);
    }








}
