<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends MY_Controller {
	public function __construct() {
		parent::__construct();

        $this->load->model('Customer_model');
        $this->load->model('Front_model');
		$this->load->model('Utility_model');
	}

	public function index()
    {
        $dataFrView = array();

        //////////////////////////////////////////////////////
        //      Setting Up View and Child View [ Start ]    //

        //  Template Related Segment [ Start ]
        $dataFrView['dataHead'] = $this->Front_model->getDataHead("|| HOME");
        $dataFrView['dataHeader'] = $this->Front_model->getDataHeader();
        $dataFrView['dataNavigation'] = $this->Front_model->getDataNavigation();
        $dataFrView['dataFooter'] = $this->Front_model->getDataFooter();
        //  Template Related Segment [ End ]


        //  Main Content Related Segment [ Start ]
        $dataFrView['dataCurrentView'] = array();
        $dataFrView['currentView'] = "front/includes/home";
        //  Main Content Related Segment [ End ]

        //      Setting Up View and Child View [ End ]      //
        //////////////////////////////////////////////////////

        //printArr($dataFrView);

        $this->load->view('front/base_theme_frame',$dataFrView);
    }
}
