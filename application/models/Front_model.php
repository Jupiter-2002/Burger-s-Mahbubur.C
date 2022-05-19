<?php
class Front_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		// Your own constructor code
	}

    public function getDataHead( $concatText = false ) {
        get_global_values('OtherSettings', 'FrontTitle');

        $dataFrReturn['page_title'] = get_global_values('OtherSettings', 'FrontTitle')." ".( ( $concatText ) ? $concatText:"" );

        return $dataFrReturn;
    }

	public function getDataHeader() {
	    $dataFrReturn['logoUrl'] = asset_url()."front_dist/images/logo.png";
        $dataFrReturn['contactNumber'] = "[CONTACT NUMBER: 111-222-333-444-555]";

        return $dataFrReturn;
    }

    public function getDataNavigation() {
        $this->load->model('Customer_model');       //  For checking If CUSTOMER is logged in or not

	    $arrNavigation = array();

        $arrNavigation['home']['Label'] = "HOME";
        $arrNavigation['home']['URL'] = base_url();

        $arrNavigation['ord_online']['Label'] = "ORDER ONLINE";
        $arrNavigation['ord_online']['URL'] = base_url()."menu";

        $arrNavigation['spcl_ord']['Label'] = "SPECIAL ORDER";
        $arrNavigation['spcl_ord']['URL'] = base_url();

        $arrNavigation['busnes_hr']['Label'] = "BUSINESS HOUR";
        $arrNavigation['busnes_hr']['URL'] = base_url();

        $arrNavigation['contact']['Label'] = "INFORMATION";
        $arrNavigation['contact']['URL'] = base_url()."front/info";

        if( $this->Customer_model->isLoggedIn() ) {
            $arrNavigation['my_account']['Label'] = "MY ACCOUNT";
            $arrNavigation['my_account']['URL'] = base_url()."customer/dashboard";

            $arrNavigation['logout']['Label'] = "LOG OUT";
            $arrNavigation['logout']['URL'] = base_url()."customer/logout";
        } else {
            $arrNavigation['login']['Label'] = "LOGIN";
            $arrNavigation['login']['URL'] = base_url()."customer/login";
        }

        return $arrNavigation;
    }

    public function getDataFooter() {
        $dataFrReturn['footerTitle'] = "Burger";
        $dataFrReturn['footerMessage'] = "Lorem ipusm dolore sit adipscing veroeroes aliquam amet. Lorem ipusm dolore sit adipscing sit adipscing veroeroes aliquam amet sit adipscing veroeroes lorem ipusm dolore sit adipscing sit adipscing veroeroes aliquam amet sit adipscing veroeroes.";

        $dataFrReturn['addressTitle'] = "Postal Address";
        $address1 = "Address Line 1";
        $address2 = "Address Line 2";
        $postCode = "AB12 ABC";
        $city = "City Name";
        $town = "Town Name";
        $country = "Country Name";

        $dataFrReturn['addressText'] = $address1.",<br />".$address2.",<br />".$postCode.", ".$city.",<br />".$town.",<br />".$country.",<br />";

        $dataFrReturn['socialTitle_1'] = "Find os på Facebook!";
        $dataFrReturn['socialUrl_1'] = asset_url()."front_dist/images/facebook.jpg";

        $dataFrReturn['socialTitle_2'] = "Følg på os Twitter";
        $dataFrReturn['socialUrl_2'] = asset_url()."front_dist/images/twitter.jpg";


        $dataFrReturn['copyRightTxtLeft'] = "Copyright © 2022, All right reserved.";
        $dataFrReturn['copyRightTxtRight'] = "Design &amp; Developed by <a href='http://www.max9.co.uk'>max9.co.uk</a>";

        return $dataFrReturn;
    }

    public function timeSchedule( $scheduleType ) {
	    $this->db->select('`time_table`.`Day`, `time_table`.`DayKey`, `time_table`.`CloseFlag`');
        $this->db->select('GROUP_CONCAT(CONCAT(" ",date_format(`time_table`.`StartTime`, "%h:%i %p"), "-", date_format(`time_table`.`EndTime`, "%h:%i %p"))) as `tim_slot_text`');

        $this->db->group_by("`time_table`.`DayKey`");
        $this->db->order_by("`time_table`.`DayKey`");

        $tableName = "";
        if( $scheduleType == "Opening" ) {
            $tableName = "timeschedule_opening";
        }
        else if( $scheduleType == "Collection" ) {
            $tableName = "timeschedule_collection";
        }
        else if( $scheduleType == "Delivery" ) {
            $tableName = "timeschedule_delivery";
        }

        $this->db->from($tableName." as `time_table`");
        $query = $this->db->get();

        //echo $this->db->last_query();

        //	Checks if user is logged in
        if ($query->num_rows() > 0 ) {
            return $query->result();
        }
        else {
            return false;
        }

    }















    public function isLoggedIn() {
        //	Checks if user is logged in
        if( isset($_SESSION['IsLoggedIn']) && $_SESSION['IsLoggedIn'] == true ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function checkLogin( $username, $password ) {
        $array = array('Email' => $username, 'Password' => $this->md5Password($password));
        $this->db->select('PK_AdminUserId, Name, Email, UserType, RegistrationDate, UpdateTime, LastLogin, Status');
        $this->db->where($array);
        $query = $this->db->get('admin_user');

        //	Checks if user is logged in
        if ($query->num_rows() == 1) {
            $tmpAdminUser = array();
            foreach ($query->result() as $row) {
                $tmpAdminUser = $row;
            }

            if( isset($tmpAdminUser->Status) && $tmpAdminUser->Status == 1 ) {
                if( isset($tmpAdminUser->UserType) && $tmpAdminUser->UserType == 1 ) {
                    //  Admin User
                    $_SESSION['AdminUserDetails'] = $tmpAdminUser;
                    $_SESSION['IsLoggedIn'] = true;

                    return "TRUE#Admin";
                }
                else {
                    //	Error
                    unset($_SESSION['AdminUserDetails']);
                    unset($_SESSION['IsLoggedIn']);

                    return "FALSE#UnknownUserType";
                }
            }

        }
        else {
            unset($_SESSION['AdminUserDetails']);
            unset($_SESSION['IsLoggedIn']);

            return "FALSE#InvalidLoginDetails";
        }

    }

    public function logout() {
        //	For Logout
        session_destroy();
    }

    public function md5Password($password) {
        return md5($password);
    }

}
?>
