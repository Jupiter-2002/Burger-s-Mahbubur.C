<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboards extends MY_Controller {
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
		    //  Admin Dashboard
            $data['page_title'] = "Admin Dashboard";
            $data['currentView'] = 'admin_dashboard';

			$data['respnsHeader'] = 'common/respns_header_admin';

			$this->load->view('base_theme_frame',$data);
		} else {
			session_destroy();
			header("Location: ".base_url());
		}
	}

    public function adminDashboard() {
        if( $this->Admin_model->getAdminType() == 1 ) {
            //	Common Portion [ Start ]
            $data['page_title'] = "Admin Dashboard";
            $data['currentView'] = 'admin_dashboard';

            $data['respnsHeader'] = 'common/respns_header_admin';
            //	Common Portion [ End ]

            $this->load->view('base_theme_frame',$data);
        } else {
            session_destroy();
            header("Location: ".base_url());
        }
    }








}
