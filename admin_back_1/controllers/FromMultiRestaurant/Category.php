<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct() {
		parent::__construct();

		// Your own constructor code
        $this->load->model('Admin_model');
        $this->load->model('Utility_model');
	}

	public function index()
	{
		$arrRespond['errorFlag'] = FALSE;
		$arrRespond['code'] = "";
		$arrRespond['specialRespond'] = "";

		if( isset($_SERVER['HTTP_AUTHORIZATIONOWNEREMAIL']) && $_SERVER['HTTP_AUTHORIZATIONOWNEREMAIL'] != "" && isset($_SERVER['HTTP_AUTHORIZATIONOWNERPASS']) && $_SERVER['HTTP_AUTHORIZATIONOWNERPASS'] != ""  && isset($_SERVER['HTTP_AUTHORIZATIONRESTID']) && $_SERVER['HTTP_AUTHORIZATIONRESTID'] != "" ) {

			//	For API Validation [ Start ]
			if( $this->Admin_model->apiValidDetails($_SERVER['HTTP_AUTHORIZATIONOWNEREMAIL'], $_SERVER['HTTP_AUTHORIZATIONOWNERPASS'], $_SERVER['HTTP_AUTHORIZATIONRESTID']) == FALSE ) {
				$arrRespond['errorFlag'] = TRUE;
				$arrRespond['code'] = "ApiAuthDetailInvalid";
			}
			//	For API Validation [ End ]


			if( $arrRespond['errorFlag'] == FALSE ) {
				if( isset($_POST['action']) && trim($_POST['action']) != "" ) {

				    //  Decision Maker Segment [ Start ]
					if( $_POST['action'] == "AddCategory" ) {
						$arrRespond = $this->addCategory( json_decode($_POST['instData']) );
					}
                    //  Decision Maker Segment [ End ]





				}
                else {
                    $arrRespond['errorFlag'] = TRUE;
                    $arrRespond['code'] = "ApiActionMissing";
                }
			}










		}
		else {
			$arrRespond['errorFlag'] = TRUE;
			$arrRespond['code'] = "ApiAuthDetailMissing";
		}








		echo json_encode($arrRespond);
	}

    public function addCategory( $instData ) {
        $arrReturn = array();

        //$newCatId = 0;
        $newCatId = $this->Utility_model->insertRecort('Menu_Category', $instData );

        if( $newCatId > 0 ) {
            $arrReturn['errorFlag'] = FALSE;
            $arrReturn['code'] = "SUCCESS";
            $arrReturn['specialRespond'] = "newCatId-".$newCatId;
        } else {
            $arrReturn['errorFlag'] = TRUE;
            $arrReturn['code'] = "DbInsertError";
        }

        return $arrReturn;
    }

	public function testRequest() {
	    $arrRespond['post']['action'] = $_POST['action'];
        $arrRespond['post']['instData'] = json_decode($_POST['instData']);


        $arrRespond['server'] = $_SERVER;

        echo json_encode($arrRespond);
    }
}
