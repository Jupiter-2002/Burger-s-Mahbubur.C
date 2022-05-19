<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Admin_model');
		$this->load->model('Utility_model');
	}

	public function index()	{
        if( $this->Admin_model->isLoggedIn() && $this->Admin_model->isLoggedIn() ) {
            header("Location: admindashboards");
        }
        else {
            $data = array();

            if( isset($_POST['submit']) && $_POST['submit'] == 'submit' ) {
                $this->load->library('form_validation');

                $this->form_validation->set_rules('username', 'username', 'required');
                $this->form_validation->set_rules('password', 'password', 'required');

                if ($this->form_validation->run() == FALSE) {
                }
                else {
                    $tmpChkLoginStr = $this->Admin_model->checkLogin($_POST['username'], $_POST['password']);

                    $arrTmpChkLogin = explode("#",$tmpChkLoginStr);

                    //printArr($arrTmpChkLogin);
                    //die();

                    if( isset($arrTmpChkLogin[0]) && $arrTmpChkLogin[0] == "TRUE" ) {
                        if( isset($arrTmpChkLogin[1]) && $arrTmpChkLogin[1] == "Admin" ) {
                            //  Admin Owner Dashboard Redirect
                            header("Location: ".base_url()."admindashboards");
                        }
                    }
                    else if( isset($arrTmpChkLogin[0]) && $arrTmpChkLogin[0] == "FALSE" ) {
                        if( isset($arrTmpChkLogin[1]) && $arrTmpChkLogin[1] == "InvalidLoginDetails" ) {
                            $data['log_in_error_message'] = "<span style='color: red'><b>Invalid Login Details</b></span>";
                        }
                        else if( isset($arrTmpChkLogin[1]) && $arrTmpChkLogin[1] == "InactiveUser" ) {
                            $data['log_in_error_message'] = "<span style='color: red'><b>Inactive User</b></span>";
                        }
                        else if( isset($arrTmpChkLogin[1]) && $arrTmpChkLogin[1] == "UnknownUserType" ) {
                            $data['log_in_error_message'] = "<span style='color: red'><b>User Type Unknown</b></span>";
                        }
                    }
                }
            }

            $data['page_title'] = "Admin Login";

            echo "<pre>";   print_r($data);     echo "</pre>";

            $this->load->view('admin/admin_login',$data);
        }
	}

	public function logout() {
		$this->Admin_model->logout();
		header("Location: ".base_url()."admin");
	}
}
