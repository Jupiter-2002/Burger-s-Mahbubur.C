<?php
class Admin_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		// Your own constructor code
	}

	public function apiValidDetails($email, $password, $restId) {
		if( $email == "rest_owner_1@gmail.com" && $password == "21232f297a57a5a743894a0e4a801fc3" && $restId == "1" ) {
			return TRUE;
		} else {
			return FALSE;
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

    public function getAdminType() {
        if( isset($_SESSION['IsLoggedIn']) && $_SESSION['IsLoggedIn'] == true ) {
            if( isset($_SESSION['AdminUserDetails']->UserType) ) {
                //	1 – Admin
                return $_SESSION['AdminUserDetails']->UserType;
            }
        } else {
            return FALSE;
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
