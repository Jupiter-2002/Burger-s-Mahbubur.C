<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Controller {
	public function __construct() {
		parent::__construct();

        $this->load->model('Customer_model');
        $this->load->model('Front_model');
		$this->load->model('Utility_model');
	}

	public function index()	{
        if( $this->Customer_model->isLoggedIn() ) {
            //  Logged In
			header("Location: ".base_url()."customer/dashboard");
		}
        else {
            //  Not Logged In
			header("Location: ".base_url()."customer/login");
		}
	}

    public function dashboard()	{
        if( $this->Customer_model->isLoggedIn() ) {
            $dataFrView = array();

            //////////////////////////////////////////////////////
            //      Setting Up View and Child View [ Start ]    //

            //  Template Related Segment [ Start ]
            $dataFrView['dataHead'] = $this->Front_model->getDataHead("|| Dashboard");
            $dataFrView['dataHeader'] = $this->Front_model->getDataHeader();
            $dataFrView['dataNavigation'] = $this->Front_model->getDataNavigation();
            $dataFrView['dataFooter'] = $this->Front_model->getDataFooter();
            //  Template Related Segment [ End ]


            //  Main Content Related Segment [ Start ]
            $dataFrView['dataCurrentView'] = array();
            $dataFrView['currentView'] = "dashboard";
            //  Main Content Related Segment [ End ]

            //  For Left Panel  [ Start ]
            $dataFrView['dataLeftPanel']['leftPanelHeading'] = "Account Home";
            $dataFrView['dataLeftPanel']['custUserDetails'] = $_SESSION['CustomerUserDetails'];
            //  For Left Panel  [ End ]

            //      Setting Up View and Child View [ End ]      //
            //////////////////////////////////////////////////////

            //printArr($dataFrView);

            $this->load->view('front/base_theme_frame',$dataFrView);
        } else {
            session_destroy();
            header("Location: ".base_url());
        }
    }

    public function login()	{
        if( !$this->Customer_model->isLoggedIn() ) {
            //  Not Logged In
            $dataFrView = array();

            //  For Login Segment [ START ]
            if( isset($_REQUEST['BtnLogin']) && $_REQUEST['BtnLogin'] == "Login" ) {

                $this->load->library('form_validation');

                $this->form_validation->set_rules('CustEmailFrLogIn', 'E-Mail', 'required');
                $this->form_validation->set_rules('CustPassFrLogIn', 'Password', 'required');

                if ($this->form_validation->run() == FALSE) {
                }
                else {
                    $tmpChkLoginStr = $this->Customer_model->checkLogin($_POST['CustEmailFrLogIn'], $_POST['CustPassFrLogIn']);
                    $arrTmpChkLogin = explode("#",$tmpChkLoginStr);

                    if( isset($arrTmpChkLogin[0]) && $arrTmpChkLogin[0] == "TRUE" ) {
                        if( isset($arrTmpChkLogin[1]) && $arrTmpChkLogin[1] == "Customer" ) {
                            //  Admin Owner Dashboard Redirect
                            if( isset($_SESSION['cartDetails']) && isset($_SESSION['cartDetails']['itemList']) && count($_SESSION['cartDetails']['itemList']) ) {
                                header("Location: ".base_url()."order/placing");
                            }
                            else {
                                header("Location: ".base_url()."customer/dashboard");
                            }
                        }
                    }
                    else if( isset($arrTmpChkLogin[0]) && $arrTmpChkLogin[0] == "FALSE" ) {
                        if( isset($arrTmpChkLogin[1]) && $arrTmpChkLogin[1] == "InvalidLoginDetails" ) {
                            $this->session->set_flashdata('failMsg', "Invalid Login Details.");
                        }
                    }
                }
            }
            //  For Login Segment [ END ]

            //////////////////////////////////////////////////////
            //      Setting Up View and Child View [ Start ]    //

            //  Template Related Segment [ Start ]
            $dataFrView['dataHead'] = $this->Front_model->getDataHead("|| Log In");
            $dataFrView['dataHeader'] = $this->Front_model->getDataHeader();
            $dataFrView['dataNavigation'] = $this->Front_model->getDataNavigation();
            $dataFrView['dataFooter'] = $this->Front_model->getDataFooter();
            //  Template Related Segment [ End ]


            //  Main Content Related Segment [ Start ]
            $dataFrView['dataCurrentView'] = array();
            $dataFrView['currentView'] = "login";
            //  Main Content Related Segment [ End ]

            //      Setting Up View and Child View [ End ]      //
            //////////////////////////////////////////////////////

            //printArr($dataFrView);

            $this->load->view('front/base_theme_frame',$dataFrView);
        } else {
            //  Logged In
            header("Location: ".base_url()."customer/dashboard");
        }
    }

    public function registration()	{
	    if( !$this->Customer_model->isLoggedIn() ) {
            //  Not Logged In
            $dataFrView = array();

            //  For Registration Segment [ START ]
            if( isset($_POST['BtnRegistration']) && $_POST['BtnRegistration'] == "Register" ) {
                $arrValidationReturn = $this->Customer_model->validateRegistrationFields( $_POST );

                if( isset($arrValidationReturn['error_flag']) && $arrValidationReturn['error_flag'] == false ) {

                    $errorFlag = false;
                    $errorDetailsArray = array();

                    //  If 'CustEmail' Already Exists [ START ]
                    if( $errorFlag == false ) {
                        $chkFlag = $this->Utility_model->returnRecord("customer", false, array('CustEmail'=>$_POST['CustEmail']));
                        //echo $this->db->last_query();

                        if( $chkFlag == FALSE ) {
                            //  No Entry so proceed
                        } else {
                            //  Already Exists
                            $errorFlag = true;
                            $errorMsg = "E-Mail Already Registered.";
                            $errorDetailsArray['CustEmail'] = "E-Mail Already Registered.";
                        }
                    }
                    //  If 'CustEmail' Already Exists [ END ]

                    if( $errorFlag ) {
                        //  Has Error
                        $dataFrView['errorMsg'] = $errorMsg;
                        $dataFrView['validationError'] = $errorDetailsArray;
                    }
                    else {
                        $arrFrCustomerInsert = $_POST;

                        unset( $arrFrCustomerInsert['BtnRegistration'] );
                        unset( $arrFrCustomerInsert['CustPassConfirm'] );

                        $arrFrCustomerInsert['CustPass'] = $this->Customer_model->md5Password($arrFrCustomerInsert['CustPass']);

                        $arrFrCustomerInsert['CustRegistrationDate'] = currentDateForDb();
                        $arrFrCustomerInsert['CustUpdateDateTime'] = currentDateTimeForDb();

                        $newCustId = $this->Utility_model->insertRecort('customer', $arrFrCustomerInsert );

                        if( $newCustId > 0 ) {
                            //  For Inserting to 'customer_address_book' [ START ]
                            $insData['CustAddLabel'] = "PRIMARY ADDRESS";
                            $insData['FK_CustId'] = $newCustId;
                            $insData['CustAddress1'] = $arrFrCustomerInsert['CustAddress1'];
                            $insData['CustAddress2'] = $arrFrCustomerInsert['CustAddress2'];
                            $insData['CustCity'] = $arrFrCustomerInsert['CustCity'];
                            $insData['CityPostCode'] = $arrFrCustomerInsert['CityPostCode'];
                            $insData['CustContact'] = $arrFrCustomerInsert['CustContact'];
                            $insData['CustAddStatus'] = 1;

                            $newCustAddId = $this->Utility_model->insertRecort('customer_address_book', $insData );

                            if( $newCustAddId > 0 ) {
                                if( isset($_SESSION['cartDetails']) && isset($_SESSION['cartDetails']['itemList']) && count($_SESSION['cartDetails']['itemList']) ) {
                                    //  Registration with Item on Cart [ Start ]
                                    $this->Customer_model->checkLogin($arrFrCustomerInsert['CustEmail'], $_POST['CustPass']);
                                    header("Location: ".base_url()."order/placing");
                                    //  Registration with Item on Cart [ End ]
                                }
                                else {
                                    $this->session->set_flashdata('successMsg', "Registered Successfully.");
                                    //header("Location: ".base_url()."customer/registration#Registration");
                                }
                            }
                            else {
                                $this->Utility_model->deleteRecord('customer', array('CustEmail'=>$arrFrCustomerInsert['CustEmail']) );
                                $dataFrView['errorMsg'] = "Something Want Wrong. Please Contact The Development Team.";
                            }
                            //  For Inserting to 'customer_address_book' [ END ]
                        }
                    }
                }
                else {
                    $dataFrView['validationError'] = $arrValidationReturn['fields'];
                }
            }
            //  For Registration Segment [ END ]


            //////////////////////////////////////////////////////
            //      Setting Up View and Child View [ Start ]    //

            //  Template Related Segment [ Start ]
            $dataFrView['dataHead'] = $this->Front_model->getDataHead();
            $dataFrView['dataHeader'] = $this->Front_model->getDataHeader();
            $dataFrView['dataNavigation'] = $this->Front_model->getDataNavigation();
            $dataFrView['dataFooter'] = $this->Front_model->getDataFooter();
            //  Template Related Segment [ End ]


            //  Main Content Related Segment [ Start ]
            $dataFrView['dataCurrentView'] = array();
            $dataFrView['currentView'] = "login";
            //  Main Content Related Segment [ End ]

            //      Setting Up View and Child View [ End ]      //
            //////////////////////////////////////////////////////

            //printArr($dataFrView);

            $this->load->view('front/base_theme_frame',$dataFrView);
        } else {
            //  Logged In
            header("Location: ".base_url()."customer/login");
        }
    }

    public function editCustomer() {
        if( $this->Customer_model->isLoggedIn() ) {
            $dataFrView = array();

            //////////////////////////////////////////////////////
            //      Setting Up View and Child View [ Start ]    //

            //  Template Related Segment [ Start ]
            $dataFrView['dataHead'] = $this->Front_model->getDataHead();
            $dataFrView['dataHeader'] = $this->Front_model->getDataHeader();
            $dataFrView['dataNavigation'] = $this->Front_model->getDataNavigation();
            $dataFrView['dataFooter'] = $this->Front_model->getDataFooter();
            //  Template Related Segment [ End ]


            //  Main Content Related Segment [ Start ]
            $dataFrView['dataCurrentView'] = array();
            $dataFrView['currentView'] = "dashboard";
            //  Main Content Related Segment [ End ]

            //      Setting Up View and Child View [ End ]      //
            //////////////////////////////////////////////////////

            //printArr($dataFrView);

            $this->load->view('front/base_theme_frame',$dataFrView);
        } else {
            session_destroy();
            header("Location: ".base_url());
        }
    }
    
    public function addressBook() {
        if( $this->Customer_model->isLoggedIn() ) {
            $dataFrView = array();

            if( isset($_POST['BtnAddress']) && $_POST['BtnAddress'] == "Add Address" ) {
                $arrFrAddressBookInsert = $_POST;
                $arrValidationReturn = $this->Customer_model->validateAddressBookFields( $arrFrAddressBookInsert );

                if( isset($arrValidationReturn['error_flag']) && $arrValidationReturn['error_flag'] == false ) {
                    $errorFlag = false;
                    $errorDetailsArray = array();

                    //  Already Exists [ START ]
                    if( $errorFlag == false ) {
                        $condCustAddress = array('CustAddLabel'=>$arrFrAddressBookInsert['CustAddLabel'], 'FK_CustId'=>$_SESSION['CustomerUserDetails']->PK_CustId);
                        $chkFlag = $this->Utility_model->returnRecord("customer_address_book", false, $condCustAddress);

                        if( $chkFlag == FALSE ) {
                            //  No Entry so proceed
                        }
                        else {
                            //  Already Exists
                            $errorFlag = true;
                            $errorMsg = "Address Label Already Exists.";

                            $errorDetailsArray['CustAddLabel'] = "Address Label Already Exists.";
                        }
                    }
                    //  Already Exists [ END ]

                    if( $errorFlag ) {
                        //  Has Error
                        $this->session->set_flashdata('failMsg', $errorMsg);
                        $dataFrView['validationError'] = $errorDetailsArray;
                    }
                    else {
                        //  Do Insert
                        unset($arrFrAddressBookInsert['BtnAddress']);

                        $arrFrAddressBookInsert['FK_CustId'] = $_SESSION['CustomerUserDetails']->PK_CustId;
                        $arrFrAddressBookInsert['CustAddLabel'] = strtoupper($arrFrAddressBookInsert['CustAddLabel']);
                        $arrFrAddressBookInsert['CityPostCode'] = strtoupper($arrFrAddressBookInsert['CityPostCode']);


                        $newAddressId = $this->Utility_model->insertRecort('customer_address_book', $arrFrAddressBookInsert );

                        if( $newAddressId > 0 ) {
                            $this->session->set_flashdata('successMsg', "Successfully Added.");
                        } else {
                            $this->session->set_flashdata('failMsg', "Something want wrong. Please contact development team.");
                        }
                    }
                }
                else {
                    $dataFrView['validationError'] = $arrValidationReturn['fields'];
                }
            }
            else if( isset($_POST['BtnAddress']) && $_POST['BtnAddress'] == "Update Address" ) {
                $arrFrAddressBook = $_POST;
                $arrValidationReturn = $this->Customer_model->validateAddressBookFields( $arrFrAddressBook );

                if( isset($arrValidationReturn['error_flag']) && $arrValidationReturn['error_flag'] == false ) {
                    $errorFlag = false;
                    $errorDetailsArray = array();

                    //  If Address Details Already Exists [ START ]
                    if( $errorFlag == false ) {
                        $condCustAddress = $_POST;

                        unset($condCustAddress['CustAddLabel']);
                        unset($condCustAddress['BtnAddress']);

                        $condCustAddress['FK_CustId'] = $_SESSION['CustomerUserDetails']->PK_CustId;

                        $chkFlag = $this->Utility_model->returnRecord("customer_address_book", false, $condCustAddress);

                        if( $chkFlag == FALSE ) {
                            //  No Entry so proceed
                        } else {
                            if( isset($chkFlag[0]->CustAddLabel) && $chkFlag[0]->CustAddLabel == $_POST['CustAddLabel'] ) {
                                //  Already Exists
                                $errorFlag = true;
                                $errorMsg = "No Changes.";
                            } else {
                                //  Already Exists
                                $errorFlag = true;
                                $errorMsg = "Address Details Already Exists.";
                            }
                        }
                    }
                    //  If Address Details Already Exists [ START ]


                    if( $errorFlag ) {
                        //  Has Error
                        $this->session->set_flashdata('failMsg', $errorMsg);
                        $dataFrView['validationError'] = $errorDetailsArray;
                    }
                    else {
                        //  Condition array
                        $arrCondUpdateAddressBook['FK_CustId'] = $_SESSION['CustomerUserDetails']->PK_CustId;
                        $arrCondUpdateAddressBook['CustAddLabel'] = $arrFrAddressBook['CustAddLabel'];
                        //printArr($arrCondUpdateAddressBook);

                        //  Insert array modify
                        $arrFrAddressBook['CustAddLabel'] = strtoupper($arrFrAddressBook['CustAddLabel']);
                        $arrFrAddressBook['CityPostCode'] = strtoupper($arrFrAddressBook['CityPostCode']);

                        unset($arrFrAddressBook['BtnAddress']);
                        unset($arrFrAddressBook['CustAddLabel']);
                        //printArr($arrFrAddressBook);

                        $newAddressId = $this->Utility_model->updateRecord('customer_address_book', $arrFrAddressBook, $arrCondUpdateAddressBook );

                        if( $newAddressId > 0 ) {
                            $this->session->set_flashdata('successMsg', "Successfully Updated.");

                            redirect(base_url().'customer/addressBook');
                        } else {
                            $this->session->set_flashdata('failMsg', "Something want wrong. Please contact development team.");
                        }
                    }
                }
                else {
                    $dataFrView['validationError'] = $arrValidationReturn['fields'];
                }
            }

            //  For Address Book List [ Start ]
            $arrCustAddressList = $this->Utility_model->returnRecord("customer_address_book", false, array('FK_CustId'=>$_SESSION['CustomerUserDetails']->PK_CustId));

            if( $arrCustAddressList == FALSE ) {
                $dataFrView['arrCustAddressList'] = array();
            } else {
                $dataFrView['arrCustAddressList'] = $arrCustAddressList;
            }
            //  For Address Book List [ End ]


            //////////////////////////////////////////////////////
            //      Setting Up View and Child View [ Start ]    //

            //  Template Related Segment [ Start ]
            $dataFrView['dataHead'] = $this->Front_model->getDataHead("|| Address Book");
            $dataFrView['dataHeader'] = $this->Front_model->getDataHeader();
            $dataFrView['dataNavigation'] = $this->Front_model->getDataNavigation();
            $dataFrView['dataFooter'] = $this->Front_model->getDataFooter();
            //  Template Related Segment [ End ]


            //  Main Content Related Segment [ Start ]
            $dataFrView['dataCurrentView'] = array();
            $dataFrView['currentView'] = "addressBook";
            //  Main Content Related Segment [ End ]

            //  For Left Panel  [ Start ]
            $dataFrView['dataLeftPanel']['leftPanelHeading'] = "Address Book";
            $dataFrView['dataLeftPanel']['custUserDetails'] = $_SESSION['CustomerUserDetails'];
            //  For Left Panel  [ End ]

            //      Setting Up View and Child View [ End ]      //
            //////////////////////////////////////////////////////

            //printArr($dataFrView);

            $this->load->view('front/base_theme_frame',$dataFrView);
        } else {
            session_destroy();
            header("Location: ".base_url());
        }
    }

    public function orderList() {
        if( $this->Customer_model->isLoggedIn() ) {
            $dataFrView = array();

            //////////////////////////////////////////////////////
            //      Setting Up View and Child View [ Start ]    //

            //  Template Related Segment [ Start ]
            $dataFrView['dataHead'] = $this->Front_model->getDataHead();
            $dataFrView['dataHeader'] = $this->Front_model->getDataHeader();
            $dataFrView['dataNavigation'] = $this->Front_model->getDataNavigation();
            $dataFrView['dataFooter'] = $this->Front_model->getDataFooter();
            //  Template Related Segment [ End ]

            //  For Left Panel  [ Start ]
            $dataFrView['dataLeftPanel']['leftPanelHeading'] = "Account Home";
            $dataFrView['dataLeftPanel']['custUserDetails'] = $_SESSION['CustomerUserDetails'];
            //  For Left Panel  [ End ]

            //  For Main Container [ Start ]
            $this->load->model('Order_model');

            $arrCondition = array("FK_CustId", $_SESSION['CustomerUserDetails']->PK_CustId );

            $dataFrView['orderList'] = $this->Order_model->returnOrderList(false, $arrCondition, "OrderDateTime DESC");
            //  For Main Container [ End ]  

            //  Main Content Related Segment [ Start ]
            $dataFrView['dataCurrentView'] = array();
            $dataFrView['currentView'] = "orderList";
            //  Main Content Related Segment [ End ]

            //      Setting Up View and Child View [ End ]      //
            //////////////////////////////////////////////////////

            $this->load->view('front/base_theme_frame',$dataFrView);
        } else {
            session_destroy();
            header("Location: ".base_url());
        }
    }

    public function orderDetails( $encodeOrderId ) {
        $orderId = decodeURLVal($encodeOrderId);

        if( $this->Customer_model->isLoggedIn() && $orderId != "" && $orderId > 0 ) {


            if( $this->Customer_model->isCustomersOrder( $_SESSION['CustomerUserDetails']->PK_CustId, $orderId) ) {
                $dataFrView = array();


                //  For Main Container [ Start ]
                $this->load->model('Order_model');

                $dataFrView['orderDetails'] = $this->Order_model->returnOrderDetailsById($orderId);
                //  For Main Container [ End ]

                if( $dataFrView['orderDetails'] != false ) {
                    //////////////////////////////////////////////////////
                    //      Setting Up View and Child View [ Start ]    //

                    //  Template Related Segment [ Start ]
                    $dataFrView['dataHead'] = $this->Front_model->getDataHead();
                    $dataFrView['dataHeader'] = $this->Front_model->getDataHeader();
                    $dataFrView['dataNavigation'] = $this->Front_model->getDataNavigation();
                    $dataFrView['dataFooter'] = $this->Front_model->getDataFooter();
                    //  Template Related Segment [ End ]

                    //  For Left Panel  [ Start ]
                    $dataFrView['dataLeftPanel']['leftPanelHeading'] = "Account Home";
                    $dataFrView['dataLeftPanel']['custUserDetails'] = $_SESSION['CustomerUserDetails'];
                    //  For Left Panel  [ End ]

                    //  Main Content Related Segment [ Start ]
                    $dataFrView['dataCurrentView'] = array();
                    $dataFrView['currentView'] = "orderDetails";
                    //  Main Content Related Segment [ End ]

                    //      Setting Up View and Child View [ End ]      //
                    //////////////////////////////////////////////////////

                    $this->load->view('front/base_theme_frame',$dataFrView);
                } else {
                    session_destroy();
                    header("Location: ".base_url());
                }
            } else {
                session_destroy();
                header("Location: ".base_url());
            }
        } else {
            session_destroy();
            header("Location: ".base_url());
        }
    }

    public function logout()	{
        if( $this->Customer_model->isLoggedIn() ) {
            $this->Customer_model->logout();
            header("Location: ".base_url());
        } else {
            session_destroy();
            header("Location: ".base_url());
        }
    }


    ///////////////////////////////////////
    ///         Ajax [ START ]          ///
    ///////////////////////////////////////
    public function ajaxNewAddressFrom() {
        $returnRespond = array();

        if( $this->Customer_model->isLoggedIn() ){
            $dataFrView = array();

            $returnRespond = array("respond"=>array("error_flag"=>false, "content"=>$this->load->view('Customer/ajaxAddressForm', $dataFrView, true)));
        }
        else {
            session_destroy();
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }

    public function ajaxAddAddress() {
        $returnRespond = array();

        if( $this->Customer_model->isLoggedIn() ){
            $dataFrView = array();

            $arrFrInsert = array();
            parse_str($_POST['postData'], $arrFrInsert);

            //printArr($arrFrInsert);

            $errorFlag = false;
            $errorType = "";
            $errorMsg = "";

            if( isset($arrFrInsert['CustAddLabel']) && $arrFrInsert['CustAddLabel'] != "" ) {
                $arrFrInsert['CustAddLabel'] = strtoupper($arrFrInsert['CustAddLabel']);
            } else {
                $errorFlag = true;
                $errorType = "FieldDataError";
                $errorMsg = "{ Label } ";
            }

            if( isset($arrFrInsert['CustContact']) && $arrFrInsert['CustContact'] != "" ) {

            } else {
                $errorFlag = true;
                $errorType = "FieldDataError";
                $errorMsg .= "{ Contact Number } ";
            }

            if( isset($arrFrInsert['CustAddress1']) && $arrFrInsert['CustAddress1'] != "" ) {

            } else {
                $errorFlag = true;
                $errorType = "FieldDataError";
                $errorMsg .= "{ Address 1 } ";
            }

            if( isset($arrFrInsert['CityPostCode']) && $arrFrInsert['CityPostCode'] != "" ) {
                $arrFrInsert['CityPostCode'] = strtoupper($arrFrInsert['CityPostCode']);
            } else {
                $errorFlag = true;
                $errorType = "FieldDataError";
                $errorMsg .= "{ Post Code } ";
            }

            if( $errorFlag == false ) {
                $condCustAddress = array('CustAddLabel'=>trim($arrFrInsert['CustAddLabel']), 'FK_CustId'=>$_SESSION['CustomerUserDetails']->PK_CustId);
                $chkFlag = $this->Utility_model->returnRecord("customer_address_book", false, $condCustAddress);

                if( $chkFlag == FALSE ) {
                    //  No Entry so proceed
                    $arrFrInsert['FK_CustId'] = $_SESSION['CustomerUserDetails']->PK_CustId;

                    //printArr($arrFrInsert);

                    $newAddressId = $this->Utility_model->insertRecort('customer_address_book', $arrFrInsert );

                    if( $newAddressId > 0 ) {
                        $errorFlag = false;
                        $errorMsg = $arrFrInsert['CustAddLabel'];
                    } else {
                        $errorFlag = true;
                        $errorType = "insertError";
                        $errorMsg = "Something is wrong.";
                    }
                } else {
                    $errorFlag = true;
                    $errorType = "alreadyExist";
                    $errorMsg = "Address Label Already Exists.";
                }

                $returnRespond = array("respond"=>array("error_flag"=>$errorFlag, "error_type"=>$errorType, "error_msg"=>$errorMsg));
            }
            else {
                $returnRespond = array("respond"=>array("error_flag"=>$errorFlag, "error_type"=>$errorType, "error_msg"=>$errorMsg));
            }
        }
        else {
            session_destroy();
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }
    ///////////////////////////////////////
    ///         Ajax [ END ]            ///
    ///////////////////////////////////////
}
