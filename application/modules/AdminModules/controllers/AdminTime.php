<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminTime extends MY_Controller {
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

            $this->load->model('Front_model');
            $arrSendToView['arrTimeScheduleOpening'] = $this->Front_model->timeSchedule("Opening");
            $arrSendToView['arrTimeScheduleCollection'] = $this->Front_model->timeSchedule("Collection");
            $arrSendToView['arrTimeScheduleDelivery'] = $this->Front_model->timeSchedule("Delivery");

            //  For View [ START ]
            $arrSendToView['page_title'] = "Admin Time";
            $arrSendToView['SegmentTitle'] = "Admin Time Form";

            $arrSendToView['currentView'] = 'User/user_base';
            $arrSendToView['respnsHeader'] = 'admin/common/respns_header_admin';

            //	For Populating Button On Top Heading
            $arrSendToView['topjQueryHeadingButtonList'] = (object) array( (object) array("event"=>"onclick", "eventFunction"=>"openAddDiscountDiv()", "class"=>"bars", "label"=>"Add Discount"));
            //  For View [ END ]

            printArr($arrSendToView);

            $this->load->view('admin/base_theme_frame',$arrSendToView);
		} else {
			session_destroy();
			header("Location: ".base_url());
		}
	}






















}
