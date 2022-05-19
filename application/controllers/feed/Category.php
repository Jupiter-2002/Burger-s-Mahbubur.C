<?php
/*
 * THIS IS FOR ALL THE CATEGORY RELATED FEEDS
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Admin_model');
		$this->load->model('Utility_model');
	}

	/*
	 * This can be called from both admin and front end so we need to check if the user is logged in or not based on
	 * cases. We are using '$chkLoggedIn' to determine if login check is needed or not.
	 */
	public function categoryList( $chkLoggedIn ) {
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

            if( isset($_POST['CatStatus']) && $_POST['CatStatus'] != "" ) {
                $arrCondition['CatStatus'] = $_POST['CatStatus'];
            }

            $arrSendToRespond['arrCategoryDetails'] = $this->Utility_model->returnRecord("Menu_Category", false, $arrCondition);


            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "content"=>$arrSendToRespond));
        }

        echo json_encode($returnRespond);
    }


    /*
     * This can be called from both admin and front end so we need to check if the user is logged in or not based on
     * cases. We are using '$chkLoggedIn' to determine if login check is needed or not.
     */
    public function subCategoryList( $chkLoggedIn ) {
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

        if( isset($_POST['catId']) && $_POST['catId'] != "" ) {
            //  NOTHING FOR NOW
        }
        else {
            $isValid = false;
            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "error_msg"=>"no_catId"));
        }

        if( $isValid ) {
            $arrCondition = array();

            if( isset($_POST['CatStatus']) && $_POST['CatStatus'] != "" ) {
                $arrCondition['CatStatus'] = $_POST['CatStatus'];
            }
            $arrCondition['FK_CatId'] = $_POST['catId'];

            $arrSendToRespond['arrSubCategoryDetails'] = $this->Utility_model->returnRecord("Menu_Sub_Category", false, $arrCondition);


            $returnRespond = array("respond"=>array("error_flag"=>!$isValid, "content"=>$arrSendToRespond));
        }

        echo json_encode($returnRespond);
    }
}
