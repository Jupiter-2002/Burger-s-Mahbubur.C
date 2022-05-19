<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminMenu extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Admin_model');
		$this->load->model('Utility_model');

		if( !$this->Admin_model->isLoggedIn() ) {
		    session_destroy();
			header("Location: ".base_url()."/admin");
		}
	}

	public function index() {
        if( $this->Admin_model->getAdminType() == 1 ) {





            header("Location: ".base_url()."AdminMenu/AdminCategory");
        } else {
            session_destroy();
            header("Location: ".base_url());
        }
    }



}