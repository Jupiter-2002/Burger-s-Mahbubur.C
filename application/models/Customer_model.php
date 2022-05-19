<?php
class Customer_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		// Your own constructor code
	}

    public function isLoggedIn() {
        //	Checks if user is logged in
        if( isset($_SESSION['IsCustLoggedIn']) && $_SESSION['IsCustLoggedIn'] == true ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function logout() {
        //	For Logout
        session_destroy();
    }

    public function validateRegistrationFields( $arrInput ) {
	    $errorFlag = false;
        $errorDetailsArray = array();

        if( trim($_POST['CustFirstName']) == "" ) {
            $errorFlag = true;
            $errorDetailsArray['CustFirstName'] = "Value Must Be Provided.";
        }
        else {
            if (!preg_match("/^[a-zA-Z ]*$/",$_POST['CustFirstName'])) {
                $errorFlag = true;
                $errorDetailsArray['CustFirstName'] = "Only letters are allowed";
            }
        }

        if( trim($_POST['CustLastName']) == "" ) {
            $errorFlag = true;
            $errorDetailsArray['CustLastName'] = "Value Must Be Provided.";
        }
        else {
            if (!preg_match("/^[a-zA-Z ]*$/",$_POST['CustLastName'])) {
                $errorFlag = true;
                $errorDetailsArray['CustLastName'] = "Only letters are allowed";
            }
        }

        if( trim($_POST['CustEmail']) == "" ) {
            $errorFlag = true;
            $errorDetailsArray['CustEmail'] = "Value Must Be Provided.";
        }
        else {
            if (!filter_var($_POST['CustEmail'], FILTER_VALIDATE_EMAIL)) {
                $errorFlag = true;
                $errorDetailsArray['CustEmail'] = "Invalid email format";
            }
        }

        if( trim($_POST['CustPass']) == "" ) {
            $errorFlag = true;
            $errorDetailsArray['CustPass'] = "Value Must Be Provided.";
        }
        if( trim($_POST['CustPassConfirm']) == "" ) {
            $errorFlag = true;
            $errorDetailsArray['CustPassConfirm'] = "Value Must Be Provided.";
        }
        if( trim($_POST['CustPass']) != trim($_POST['CustPassConfirm']) ) {
            $errorFlag = true;
            $errorDetailsArray['CustPass'] = "Value Must Be Same.";
            $errorDetailsArray['CustPassConfirm'] = "Value Must Be Same.";
        }

        if( trim($_POST['CustAddress1']) == "" ) {
            $errorFlag = true;
            $errorDetailsArray['CustAddress1'] = "Value Must Be Provided.";
        }
        else {
            if (!preg_match("/^[a-zA-Z0-9, ]*$/",$_POST['CustAddress1'])) {
                $errorFlag = true;
                $errorDetailsArray['CustAddress1'] = "Only letters and numbers are allowed";
            }
        }

        if( trim($_POST['CustAddress2']) == "" ) {
        }
        else {
            if (!preg_match("/^[a-zA-Z0-9, ]*$/",$_POST['CustAddress2'])) {
                $errorFlag = true;
                $errorDetailsArray['CustAddress2'] = "Only letters and numbers are allowed";
            }
        }

        if( trim($_POST['CustCity']) == "" ) {
            $errorFlag = true;
            $errorDetailsArray['CustCity'] = "Value Must Be Provided.";
        }
        else {
            if (!preg_match("/^[a-zA-Z ]*$/",$_POST['CustCity'])) {
                $errorFlag = true;
                $errorDetailsArray['CustCity'] = "Only letters are allowed";
            }
        }

        if( trim($_POST['CityPostCode']) == "" ) {
            $errorFlag = true;
            $errorDetailsArray['CityPostCode'] = "Value Must Be Provided.";
        }
        else {
            if (!preg_match("/^[a-zA-Z0-9 ]*$/",$_POST['CityPostCode'])) {
                $errorFlag = true;
                $errorDetailsArray['CityPostCode'] = "Only letters and numbers are allowed";
            }
        }

        $arrReturnResult = array( 'error_flag'=>$errorFlag, 'fields'=>$errorDetailsArray );

        //printArr($arrReturnResult);


	    return $arrReturnResult;

    }

    public function validateAddressBookFields( $arrInput ) {
        $errorFlag = false;
        $errorDetailsArray = array();

        if( trim($_POST['CustAddLabel']) == "" ) {
            $errorFlag = true;
            $errorDetailsArray['CustAddLabel'] = "Value Must Be Provided.";
        }
        else {
            if (!preg_match("/^[a-zA-Z0-9, ]*$/",$_POST['CustAddLabel'])) {
                $errorFlag = true;
                $errorDetailsArray['CustAddLabel'] = "Only letters and numbers are allowed";
            }
        }

        if( trim($_POST['CustContact']) == "" ) {
            $errorFlag = true;
            $errorDetailsArray['CustContact'] = "Value Must Be Provided.";
        }
        else {
            if (!preg_match("/^[a-zA-Z0-9, ]*$/",$_POST['CustContact'])) {
                $errorFlag = true;
                $errorDetailsArray['CustContact'] = "Only letters and numbers are allowed";
            }
        }

        if( trim($_POST['CustAddress1']) == "" ) {
            $errorFlag = true;
            $errorDetailsArray['CustAddress1'] = "Value Must Be Provided.";
        }
        else {
            if (!preg_match("/^[a-zA-Z0-9, ]*$/",$_POST['CustAddress1'])) {
                $errorFlag = true;
                $errorDetailsArray['CustAddress1'] = "Only letters and numbers are allowed";
            }
        }

        if( trim($_POST['CustAddress2']) == "" ) {
        }
        else {
            if (!preg_match("/^[a-zA-Z0-9, ]*$/",$_POST['CustAddress2'])) {
                $errorFlag = true;
                $errorDetailsArray['CustAddress2'] = "Only letters and numbers are allowed";
            }
        }

        if( trim($_POST['CustCity']) == "" ) {
            $errorFlag = true;
            $errorDetailsArray['CustCity'] = "Value Must Be Provided.";
        }
        else {
            if (!preg_match("/^[a-zA-Z ]*$/",$_POST['CustCity'])) {
                $errorFlag = true;
                $errorDetailsArray['CustCity'] = "Only letters are allowed";
            }
        }

        if( trim($_POST['CityPostCode']) == "" ) {
            $errorFlag = true;
            $errorDetailsArray['CityPostCode'] = "Value Must Be Provided.";
        }
        else {
            if (!preg_match("/^[a-zA-Z0-9 ]*$/",$_POST['CityPostCode'])) {
                $errorFlag = true;
                $errorDetailsArray['CityPostCode'] = "Only letters and numbers are allowed";
            }
        }

        $arrReturnResult = array( 'error_flag'=>$errorFlag, 'fields'=>$errorDetailsArray );

        //printArr($arrReturnResult);


        return $arrReturnResult;

    }

    public function checkLogin( $username, $password ) {
        $array = array('CustEmail' => $username, 'CustPass' => $this->md5Password($password));
        $this->db->select('PK_CustId, CustStatus, CustFirstName, CustLastName, CustEmail, CustProfilePic, CustAddress1, CustAddress2, CustCity, CustTown, CityPostCode, CustContact, CustRegistrationDate, CustUpdateDateTime');
        $this->db->where($array);
        $query = $this->db->get('customer');

        //	Checks if user is logged in
        if ($query->num_rows() == 1) {
            $tmpAdminUser = array();
            foreach ($query->result() as $row) {
                $tmpCustomerUser = $row;
            }

            if( isset($tmpCustomerUser->CustStatus) && $tmpCustomerUser->CustStatus == 1 ) {
                $_SESSION['CustomerUserDetails'] = $tmpCustomerUser;
                $_SESSION['IsCustLoggedIn'] = true;

                return "TRUE#Customer";
            }
        }
        else {
            unset($_SESSION['CustomerUserDetails']);
            unset($_SESSION['IsCustLoggedIn']);

            return "FALSE#InvalidLoginDetails";
        }
    }

    public function md5Password($password) {
        return md5($password);
    }

    public function isCustomersOrder( $custId, $orderId ) {
	    $array = array('FK_CustId' => $custId, 'OrderSummaryId' => $orderId);
        $this->db->where($array);
        $query = $this->db->get('order_summary');

        //echo $this->db->last_query();

        //	Checks if user is logged in
        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }

    }



}
?>
