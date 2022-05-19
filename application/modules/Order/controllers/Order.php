<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends MY_Controller {
	public function __construct() {
		parent::__construct();

        $this->load->model('Customer_model');
        $this->load->model('Front_model');
        
		$this->load->model('Utility_model');
		$this->load->model('Cart_Utility_model');
	}
    
    public function index() {
        if( isset($_SESSION['cartDetails']) && isset($_SESSION['cartDetails']['itemList']) && count($_SESSION['cartDetails']['itemList']) ) {
            if( $this->Customer_model->isLoggedIn() ) {
                //  Logged In
                header("Location: ".base_url()."order/placing");
            }
            else {
                //  Logged In
                header("Location: ".base_url()."order/login");
            }
        }
        else {
            //  Logged In
            header("Location: ".base_url()."menu");
        }        
    }

    public function login() {
        if( !$this->Customer_model->isLoggedIn() ) {
            if( isset($_SESSION['cartDetails']) && isset($_SESSION['cartDetails']['itemList']) && count($_SESSION['cartDetails']['itemList']) ) {
                //  Not Logged In
                $dataFrView = array();

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

                $this->load->view('front/base_theme_frame',$dataFrView);
            } else {
                header("Location: ".base_url()."menu");
            }
        }
        else {
            header("Location: ".base_url()."order");
        }
    }

    public function placing() {
	    if( $this->Customer_model->isLoggedIn() && isset($_SESSION['selectedOrderType']) && $_SESSION['selectedOrderType'] != "" ) {
            //  Not Logged In
            $dataFrView = array();

            $dataFrView['restaurantInfo'] = restaurantInfo();
            $dataFrView['activePaymentType'] = activePaymentType();

            if( isset($_SESSION['selectedOrderType']) && $_SESSION['selectedOrderType'] == 2 ) {
                $dataFrView['arrDeliveryAddress'] = $this->Utility_model->returnRecord("customer_address_book", false, array('FK_CustId'=>$_SESSION['CustomerUserDetails']->PK_CustId));

                if( $dataFrView['arrDeliveryAddress'] == FALSE ) {
                    unset($_SESSION);
                    header("Location: ".base_url());
                }
            }

            //////////////////////////////////////////////////////
            //      Setting Up View and Child View [ Start ]    //
            //////////////////////////////////////////////////////
            //  Template Related Segment [ Start ]
            $dataFrView['dataHead'] = $this->Front_model->getDataHead("|| Order Placing");
            $dataFrView['dataHeader'] = $this->Front_model->getDataHeader();
            $dataFrView['dataNavigation'] = $this->Front_model->getDataNavigation();
            $dataFrView['dataFooter'] = $this->Front_model->getDataFooter();
            //  Template Related Segment [ End ]


            //  Main Content Related Segment [ Start ]
            $dataFrView['dataCurrentView'] = array();
            $dataFrView['currentView'] = "placing";
            //  Main Content Related Segment [ End ]
            //////////////////////////////////////////////////////
            //      Setting Up View and Child View [ End ]      //
            //////////////////////////////////////////////////////


            //printArr($dataFrView['arrDeliveryAddress']);
            //printArr($_SESSION);

            $this->load->view('front/base_theme_frame',$dataFrView);
        } else {
            header("Location: ".base_url());
        }
    }
    
    public function submit() {
	    if( $this->Customer_model->isLoggedIn() && isset($_SESSION['selectedOrderType']) && $_SESSION['selectedOrderType'] != "" && isset($_POST['submitBtn']) && $_POST['submitBtn'] == "Submit Order" ) {
            $arrOrderSummary = array();

            $arrOrderSummary['FK_CustId'] = $_SESSION['CustomerUserDetails']->PK_CustId;
            $arrOrderSummary['OrderDateTime'] = currentDateTimeForDb();

            ////////////////////////////////////////////////////////////////
            //  PENDING SECTION [ START ]
            $arrOrderSummary['DeliveryDate'] = date("Y-m-d");

            if( isset($_POST['selectedTime']) && $_POST['selectedTime'] != "" ) {
                $arrOrderSummary['DeliveryTime'] = date("H:i", strtotime($_POST['selectedTime']));
            }
            //  PENDING SECTION [ END ]
            ////////////////////////////////////////////////////////////////

            //  [ 0 - pending, 1 - accept, 2 - reject ]
            $arrOrderSummary['Status'] = 0;

            if( isset($_SESSION['selectedOrderType']) && $_SESSION['selectedOrderType'] != "" ) {
                //  [ 1 - Collection, 2 - Delivery ]
                $arrOrderSummary['OrderType'] = $_SESSION['selectedOrderType'];
            }
            if( isset($_POST['pay_mathod']) && $_POST['pay_mathod'] != "" ) {
                //  [ 1 - COD, 2 - Paypal, 3 - Stripe ]
                $arrOrderSummary['PaymentType'] = $_POST['pay_mathod'];

                //  [ 0 - False, 1 - True ]
                if( $_POST['pay_mathod'] == 1 ) {   $arrOrderSummary['PaymentStatus'] = 1;  }
                else {  $arrOrderSummary['PaymentStatus'] = 0; }
            }
            if( isset($_SESSION['checkboxASAP']) && $_SESSION['checkboxASAP'] != "" ) {
                //  [ 0 - False, 1 - True ]
                $arrOrderSummary['CheckBoxASAP'] = $_SESSION['checkboxASAP'];
            }


            //////////////////////////////////////////
            //      Address Section [ START ]
            //      Note: For 'COLLECTION' order the address is the 'RESTAURANT' address, for 'DELIVERY' order the address is 'CUSTOMER' address
            if( $_SESSION['selectedOrderType'] == 1 ) {
                //      COLLECTION ORDER
                $restaurantInfo = restaurantInfo();
                //printArr( $restaurantInfo );

                if( isset($restaurantInfo->RestAddress1) && $restaurantInfo->RestAddress1 != "" ) {
                    $arrOrderSummary['Address1'] = $restaurantInfo->RestAddress1;
                }
                if( isset($restaurantInfo->RestAddress2) && $restaurantInfo->RestAddress2 != "" ) {
                    $arrOrderSummary['Address2'] = $restaurantInfo->RestAddress2;
                }
                if( isset($restaurantInfo->RestCity) && $restaurantInfo->RestCity != "" ) {
                    $arrOrderSummary['City'] = $restaurantInfo->RestCity;
                }
                if( isset($restaurantInfo->RestTown) && $restaurantInfo->RestTown != "" ) {
                    $arrOrderSummary['Town'] = $restaurantInfo->RestTown;
                }
                if( isset($restaurantInfo->RestPostCode) && $restaurantInfo->RestPostCode != "" ) {
                    $arrOrderSummary['PostCode'] = $restaurantInfo->RestPostCode;
                }
            }
            else if( $_SESSION['selectedOrderType'] == 2 ) {
                //      DELIVERY ORDER
                if( isset($_SESSION['deliveryAddressDetails']->CustAddress1) && $_SESSION['deliveryAddressDetails']->CustAddress1 != "" ) {
                    $arrOrderSummary['Address1'] = $_SESSION['deliveryAddressDetails']->CustAddress1;
                }
                if( isset($_SESSION['deliveryAddressDetails']->CustAddress2) && $_SESSION['deliveryAddressDetails']->CustAddress2 != "" ) {
                    $arrOrderSummary['Address2'] = $_SESSION['deliveryAddressDetails']->CustAddress2;
                }
                if( isset($_SESSION['deliveryAddressDetails']->CustCity) && $_SESSION['deliveryAddressDetails']->CustCity != "" ) {
                    $arrOrderSummary['City'] = $_SESSION['deliveryAddressDetails']->CustCity;
                }
                if( isset($_SESSION['deliveryAddressDetails']->CustTown) && $_SESSION['deliveryAddressDetails']->CustTown != "" ) {
                    $arrOrderSummary['Town'] = $_SESSION['deliveryAddressDetails']->CustTown;
                }
                if( isset($_SESSION['deliveryAddressDetails']->CityPostCode) && $_SESSION['deliveryAddressDetails']->CityPostCode != "" ) {
                    $arrOrderSummary['PostCode'] = $_SESSION['deliveryAddressDetails']->CityPostCode;
                }
            }
            else {
                header("Location: ".base_url());
            }
            //      Address Section [ END ]
            //////////////////////////////////////////

            //  CUSTOMER CONTACT WILL ALWAYS BE HERE EVEN FOR 'GUEST CUSTOMER'
            if( isset($_SESSION['CustomerUserDetails']->CustContact) && $_SESSION['CustomerUserDetails']->CustContact != "" ) {
                $arrOrderSummary['CustContact'] = $_SESSION['CustomerUserDetails']->CustContact;
            }

            //  Delivery Fee
            if( isset($_SESSION['cartExtraDetails']['deliveryDetails']['DeliveryCharge']) && $_SESSION['cartExtraDetails']['deliveryDetails']['DeliveryCharge'] > 0 ) {
                $arrOrderSummary['DeliveryFee'] = number_formate($_SESSION['cartExtraDetails']['deliveryDetails']['DeliveryCharge']);
            }

            /*
            //  PENDING SECTION [ START ]
            CreditCardFee
            if( isset($_SESSION['CustomerUserDetails']->CustAddress2) ) {
                //  PENDING SECTION FOR 'CREDIT CARD FEE'
                $arrOrderSummary['CreditCardFee'] = 0;
            }

            Order Selected Time
            if( isset($_POST['selectedTime']) && $_POST['selectedTime'] != "" ) {
                //$arrOrderSummary['DeliveryDateTime'] = $_POST['selectedTime'];
            }
            //  PENDING SECTION [ END ]
            */

            if( isset($_SESSION['cartDetails']['itemTotal']) && $_SESSION['cartDetails']['itemTotal'] != "" ) {
                $arrOrderSummary['ItemTotal'] = number_formate($_SESSION['cartDetails']['itemTotal']);
            }
            if( isset($_SESSION['cartDetails']['discountTotal']) && $_SESSION['cartDetails']['discountTotal'] != "" ) {
                $arrOrderSummary['DiscountTotal'] = number_formate($_SESSION['cartDetails']['discountTotal']);
            }
            if( isset($_SESSION['cartDetails']['discountDetails']) && $_SESSION['cartDetails']['discountDetails'] != "" ) {
                $arrOrderSummary['DiscountDetailsJson'] = json_encode($_SESSION['cartDetails']['discountDetails']);
            }
            if( isset($_SESSION['cartDetails']['totalWithoutCCFee']) && $_SESSION['cartDetails']['totalWithoutCCFee'] != "" ) {
                $arrOrderSummary['TotalWithoutCCFee'] = number_formate($_SESSION['cartDetails']['totalWithoutCCFee']);
            }
            //printArr($arrOrderSummary);

            //  Order Comments [ START ]
            if( isset($_POST['CustComments']) && $_POST['CustComments'] != "" ) {
                $arrOrderSummary['CustComments'] = $_POST['CustComments'];
            }

            //  [ 1 - COD, 2 - Paypal, 3 - Stripe ]
            if( isset($_POST['pay_mathod']) && $_POST['pay_mathod'] != "" && $_POST['pay_mathod'] == 1 ) {
                //////////////////////////////////
                //          COD Order           //
                //////////////////////////////////

                //  'order_summary'
                $newOrderSummaryId  = $this->Utility_model->insertRecort('order_summary', $arrOrderSummary );

                //  Insert Into 'order_detail' table [ START ]
                if( $newOrderSummaryId > 0 ) {
                    foreach( $_SESSION['cartDetails']['itemList'] as $catSortKey => $catItems ) {
                        foreach( $catItems as $mixedKey => $catObjDetails ) {
                            //echo "<br /><--<br />--->".$mixedKey;

                            if( $mixedKey != "CatDetails" ) {
                                $SubCatSortNo = $mixedKey;

                                $FK_SubCatId = 0;
                                $SubCatName = "";

                                foreach( $catObjDetails as $mixedItemListDetailsKey => $itemListDetails ) {
                                    //echo "<br />----->".$mixedItemListDetailsKey;

                                    if( $mixedItemListDetailsKey == "SubCatDetails" ) {
                                        $FK_SubCatId = $itemListDetails['SubCatId'];
                                        $SubCatName = $itemListDetails['SubCatName'];

                                        //echo "<br />---------->FK_SubCatId: ".$FK_SubCatId." SubCatName: ".$SubCatName;
                                    }
                                    else if( $mixedItemListDetailsKey == "ItemListDetails" ) {
                                        foreach( $itemListDetails as $itemSortKey => $itemObjectDetails ) {
                                            //echo "<br />---".$itemSortKey;

                                            foreach( $itemObjectDetails as $itmIdentificationKey => $itmObjDetails ) {
                                                //echo "<br />---->".$itmIdentificationKey."<br />";
                                                //printArr($itmObjDetails);

                                                $arrOrderDetail = array();
                                                $arrOrderDetail['FK_OrderSummaryId'] = $newOrderSummaryId;
                                                $arrOrderDetail['FK_CustId'] = $_SESSION['CustomerUserDetails']->PK_CustId;
                                                $arrOrderDetail['GeneratedItemKey'] = $itmIdentificationKey;
                                                $arrOrderDetail['FK_CatId'] = $itmObjDetails['itmDetails']['FK_CatId'];
                                                $arrOrderDetail['CatName'] = $itmObjDetails['itmDetails']['CatName'];
                                                $arrOrderDetail['CatSortNo'] = $itmObjDetails['itmDetails']['CatSortNo'];
                                                $arrOrderDetail['FK_SubCatId'] = $FK_SubCatId;
                                                $arrOrderDetail['SubCatName'] = $SubCatName;
                                                $arrOrderDetail['SubCatSortNo'] = $SubCatSortNo;
                                                $arrOrderDetail['PK_BaseId'] = $itmObjDetails['itmDetails']['PK_BaseId'];
                                                $arrOrderDetail['BaseName'] = $itmObjDetails['itmDetails']['BaseName'];
                                                $arrOrderDetail['BaseSortNo'] = $itmObjDetails['itmDetails']['BaseSortNo'];
                                                $arrOrderDetail['BaseType'] = $itmObjDetails['itmDetails']['BaseType'];
                                                $arrOrderDetail['BaseNo'] = $itmObjDetails['itmDetails']['BaseNo'];
                                                $arrOrderDetail['BasePrice'] = $itmObjDetails['itmDetails']['BasePrice'];
                                                $arrOrderDetail['itmQty'] = $itmObjDetails['itmQty'];
                                                $arrOrderDetail['itmUnitPrice'] = $itmObjDetails['itmUnitPrice'];
                                                $arrOrderDetail['itmDiscount'] = $itmObjDetails['itmDiscount'];
                                                $arrOrderDetail['itmUnitPriceAfterDiscount'] = $itmObjDetails['itmUnitPriceAfterDiscount'];
                                                $arrOrderDetail['itmPrice'] = number_formate($itmObjDetails['itmPrice']);

                                                //  For 'itmComment'
                                                if( isset($itmObjDetails['itmComment']) && $itmObjDetails['itmComment'] != "" ) {
                                                    $arrOrderDetail['itmComment'] = $itmObjDetails['itmComment'];
                                                }

                                                //  For Selection [ START ]
                                                if( isset($itmObjDetails['itmDetails']['SelectionDetails']) && count($itmObjDetails['itmDetails']['SelectionDetails']) > 0 ) {
                                                    $arrOrderDetail['SelectionJSON'] = json_encode($itmObjDetails['itmDetails']['SelectionDetails']);
                                                }
                                                //  For Selection [ END ]

                                                //  For Toppings [ START ]
                                                if( isset($itmObjDetails['itmDetails']['ToppingsDetails']) && count($itmObjDetails['itmDetails']['ToppingsDetails']) > 0 ) {
                                                    $arrOrderDetail['ToppingJSON'] = json_encode($itmObjDetails['itmDetails']['ToppingsDetails']);
                                                }
                                                //  For Toppings [ END ]


                                                $newOrderDetailId  = $this->Utility_model->insertRecort('order_detail', $arrOrderDetail );
                                            }
                                        }
                                    }
                                }
                            }

                            //echo "<br />--><br /><br />";
                        }
                    }

                    resetFrNextOrder();
                }
                //  Insert Into 'order_detail' table [ END ]

                header("Location: ".base_url()."order/success/".encodeURLVal($newOrderSummaryId));
            }
            else {
                /////////////////////////////////////
                //          ONLINE Order           //
                /////////////////////////////////////

                //  'order_summary'
                $newOrderSummaryBufferId  = $this->Utility_model->insertRecort('order_summary_buffer', $arrOrderSummary );

                //  Insert Into 'order_detail' table [ START ]
                if( $newOrderSummaryBufferId > 0 ) {
                    foreach( $_SESSION['cartDetails']['itemList'] as $catSortKey => $catItems ) {
                        foreach( $catItems as $mixedKey => $catObjDetails ) {
                            //echo "<br /><--<br />--->".$mixedKey;

                            if( $mixedKey != "CatDetails" ) {
                                $SubCatSortNo = $mixedKey;

                                $FK_SubCatId = 0;
                                $SubCatName = "";

                                foreach( $catObjDetails as $mixedItemListDetailsKey => $itemListDetails ) {
                                    //echo "<br />----->".$mixedItemListDetailsKey;

                                    if( $mixedItemListDetailsKey == "SubCatDetails" ) {
                                        $FK_SubCatId = $itemListDetails['SubCatId'];
                                        $SubCatName = $itemListDetails['SubCatName'];

                                        //echo "<br />---------->FK_SubCatId: ".$FK_SubCatId." SubCatName: ".$SubCatName;
                                    }
                                    else if( $mixedItemListDetailsKey == "ItemListDetails" ) {
                                        foreach( $itemListDetails as $itemSortKey => $itemObjectDetails ) {
                                            //echo "<br />---".$itemSortKey;

                                            foreach( $itemObjectDetails as $itmIdentificationKey => $itmObjDetails ) {
                                                //echo "<br />---->".$itmIdentificationKey."<br />";
                                                //printArr($itmObjDetails);

                                                $arrOrderDetail = array();
                                                $arrOrderDetail['FK_OrderSummaryBufferId'] = $newOrderSummaryBufferId;
                                                $arrOrderDetail['FK_CustId'] = $_SESSION['CustomerUserDetails']->PK_CustId;
                                                $arrOrderDetail['GeneratedItemKey'] = $itmIdentificationKey;
                                                $arrOrderDetail['FK_CatId'] = $itmObjDetails['itmDetails']['FK_CatId'];
                                                $arrOrderDetail['CatName'] = $itmObjDetails['itmDetails']['CatName'];
                                                $arrOrderDetail['CatSortNo'] = $itmObjDetails['itmDetails']['CatSortNo'];
                                                $arrOrderDetail['FK_SubCatId'] = $FK_SubCatId;
                                                $arrOrderDetail['SubCatName'] = $SubCatName;
                                                $arrOrderDetail['SubCatSortNo'] = $SubCatSortNo;
                                                $arrOrderDetail['PK_BaseId'] = $itmObjDetails['itmDetails']['PK_BaseId'];
                                                $arrOrderDetail['BaseName'] = $itmObjDetails['itmDetails']['BaseName'];
                                                $arrOrderDetail['BaseSortNo'] = $itmObjDetails['itmDetails']['BaseSortNo'];
                                                $arrOrderDetail['BaseType'] = $itmObjDetails['itmDetails']['BaseType'];
                                                $arrOrderDetail['BaseNo'] = $itmObjDetails['itmDetails']['BaseNo'];
                                                $arrOrderDetail['BasePrice'] = $itmObjDetails['itmDetails']['BasePrice'];
                                                $arrOrderDetail['itmQty'] = $itmObjDetails['itmQty'];
                                                $arrOrderDetail['itmUnitPrice'] = $itmObjDetails['itmUnitPrice'];
                                                $arrOrderDetail['itmDiscount'] = $itmObjDetails['itmDiscount'];
                                                $arrOrderDetail['itmUnitPriceAfterDiscount'] = $itmObjDetails['itmUnitPriceAfterDiscount'];
                                                $arrOrderDetail['itmPrice'] = number_formate($itmObjDetails['itmPrice']);

                                                //  For 'itmComment'
                                                if( isset($itmObjDetails['itmComment']) && $itmObjDetails['itmComment'] != "" ) {
                                                    $arrOrderDetail['itmComment'] = $itmObjDetails['itmComment'];
                                                }

                                                //  For Selection [ START ]
                                                if( isset($itmObjDetails['itmDetails']['SelectionDetails']) && count($itmObjDetails['itmDetails']['SelectionDetails']) > 0 ) {
                                                    $arrOrderDetail['SelectionJSON'] = json_encode($itmObjDetails['itmDetails']['SelectionDetails']);
                                                }
                                                //  For Selection [ END ]

                                                //  For Toppings [ START ]
                                                if( isset($itmObjDetails['itmDetails']['ToppingsDetails']) && count($itmObjDetails['itmDetails']['ToppingsDetails']) > 0 ) {
                                                    $arrOrderDetail['ToppingJSON'] = json_encode($itmObjDetails['itmDetails']['ToppingsDetails']);
                                                }
                                                //  For Toppings [ END ]


                                                $newOrderDetailBufferId  = $this->Utility_model->insertRecort('order_detail_buffer', $arrOrderDetail );
                                            }
                                        }
                                    }
                                }
                            }

                            //echo "<br />--><br /><br />";
                        }
                    }

                    //resetFrNextOrder();
                }
                //  Insert Into 'order_detail' table [ END ]

                //header("Location: ".base_url()."order/success/".encodeURLVal($newOrderSummaryId));
            }
        }
	    else {
            header("Location: ".base_url());
        }
    }

    public function success( $encodeOrderId ) {
	    $successOrderId = decodeURLVal($encodeOrderId);

        if( $this->Customer_model->isLoggedIn() && $successOrderId != "" && $successOrderId > 0 ) {
            $dataFrView = array();

            //////////////////////////////////////////////////////
            //      Setting Up View and Child View [ Start ]    //
            //////////////////////////////////////////////////////
            //  Template Related Segment [ Start ]
            $dataFrView['dataHead'] = $this->Front_model->getDataHead("|| Order Success");
            $dataFrView['dataHeader'] = $this->Front_model->getDataHeader();
            $dataFrView['dataNavigation'] = $this->Front_model->getDataNavigation();
            $dataFrView['dataFooter'] = $this->Front_model->getDataFooter();
            //  Template Related Segment [ End ]


            //  Main Content Related Segment [ Start ]
            $dataFrView['dataCurrentView'] = array();
            $dataFrView['currentView'] = "success";
            //  Main Content Related Segment [ End ]
            //////////////////////////////////////////////////////
            //      Setting Up View and Child View [ End ]      //
            //////////////////////////////////////////////////////


            $dataFrView['encodeOrderId'] = $encodeOrderId;

            $this->load->view('front/base_theme_frame',$dataFrView);
        } else {
            header("Location: ".base_url());
        }
    }

    //////////////////////////////////////////////
    //           AJAX Works [ START ]           //
    public function ajaxSelectOrderType() {
        if( isset($_POST['OrderType']) && $_POST['OrderType'] != "" ) { 
            $arrSelectedOrderType = restauranOrderType($_POST['OrderType']);
            
            if( $arrSelectedOrderType != false ) {
                if( $arrSelectedOrderType[0]->OrderTypeId == 2 ) {
                    //  Delivery Order Type
                    $arrDeliveryAddress['postcode'] = $_POST['PostCode'];

                    $deliveryDetails = $this->Utility_model->getDeliveryDetails( $arrDeliveryAddress );

                    //echo $this->db->last_query();

                    if( $deliveryDetails != false ) {
                        $_SESSION['cartExtraDetails']['deliveryDetails'] = (array) $deliveryDetails;
                        $_SESSION['selectedOrderType'] = 2;

                        $returnRespond = array("respond"=>array("error_flag"=>false, "error_msg"=>""));
                    } else {
                        $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"not_inside_delivery_area"));
                    }
                } 
                else if( $arrSelectedOrderType[0]->OrderTypeId == 1 ) {
                    //  Collection Order Type
                    $_SESSION['selectedOrderType'] = 1;
                    unset($_SESSION['cartExtraDetails']['deliveryDetails']);
                    unset($_SESSION['deliveryAddressDetails']);

                    $returnRespond = array("respond"=>array("error_flag"=>false, "error_msg"=>""));
                }

                //  Discount Details
                if( isset($_SESSION['cartDetails']) && isset($_SESSION['cartDetails']['itemTotal']) && $_SESSION['cartDetails']['itemTotal'] > 0 ) {
                    $_SESSION['cartDetails']['discountDetails'] = $this->Cart_Utility_model->cartDiscountDetails( $_SESSION['cartDetails']['itemTotal'] );
                }
            }
            else {
                $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"invalid_OrderType"));
            }
        }
        else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"no_OrderType"));
        }

        echo json_encode($returnRespond);
    }

    public function ajaxOrderTiming() {
        $returnRespond = array();

	    if( $this->Customer_model->isLoggedIn() && isset($_SESSION['selectedOrderType']) && $_SESSION['selectedOrderType'] != "" ) {
            //  Not Logged In
            $arrSendToView = array();

            //////////////////////////////////////////////////////
            //      Order time related segment [ START ]        //
            $dataFrView['currentNumericDay'] = date('N');
            $dataFrView['currentTime'] = currentTimeValue();
            $dataFrView['currentDate'] = currentDateForDisplay();
            $dataFrView['currentDateTime'] = currentDateTimeForDisplay();

            $dataFrView['FoodPrepTime'] = date("H:i", strtotime(get_global_values( "OtherSettings", "FoodPrepTime" )) );

            $arrAvailableTime = array();

            $this->load->model('Order_model');

            if( isset($_SESSION['selectedOrderType']) && $_SESSION['selectedOrderType'] == 1 ) {
                //echo "COLLECTION ORDER SEGMENT";

                $dataFrView['dataCollectionTimeSlot'] = $this->Order_model->returnCollectionTimeSlot(false, $dataFrView['currentTime'], array('DayKey'=>$dataFrView['currentNumericDay']));
                //printArr($dataFrView['dataCollectionTimeSlot']);

                $tmpCollectionTime = "";
                $tmpCollectionTimeString = "";

                foreach ( $dataFrView['dataCollectionTimeSlot'] as $collectionSlotKey => $collectionSlotVal ) {
                    if( time() > strtotime($collectionSlotVal->StartTime) ) {
                        $tmpCollectionTime = ceil(time() / 300 ) * 300;
                        $tmpCollectionTimeString = timeForDisplay($tmpCollectionTime);
                    }
                    else {
                        $tmpCollectionTime = strtotime($collectionSlotVal->StartTime);
                        $tmpCollectionTimeString = timeForDisplay($tmpCollectionTime);
                    }

                    do {
                        $arrAvailableTime[$tmpCollectionTime] = $tmpCollectionTimeString;

                        $tmpCollectionTime = strtotime('+30 minutes', $tmpCollectionTime);
                        $tmpCollectionTimeString = timeForDisplay($tmpCollectionTime);
                    } while ( $tmpCollectionTime < strtotime($collectionSlotVal->EndTime) );
                }
            }
            else if( isset($_SESSION['selectedOrderType']) && $_SESSION['selectedOrderType'] == 2 ) {
                //echo "DELIVERY ORDER SEGMENT";

                $dataFrView['dataDeliveryTimeSlot'] = $this->Order_model->returnDeliveryTimeSlot(false, $dataFrView['currentTime'], array('DayKey'=>$dataFrView['currentNumericDay']));

                $tmpDeliveryTime = "";
                $tmpDeliveryTimeString = "";

                if( isset($_SESSION['cartExtraDetails']['deliveryDetails']['DeliveryTime']) ) {
                    $deliveryStartTime = strtotime('+'.$_SESSION['cartExtraDetails']['deliveryDetails']['DeliveryTime'].' minutes', time());
                }
                else {
                    $deliveryStartTime = time();
                }

                foreach ( $dataFrView['dataDeliveryTimeSlot'] as $deliverySlotKey => $deliverySlotVal ) {
                    if( $deliveryStartTime > strtotime($deliverySlotVal->StartTime) ) {
                        $tmpDeliveryTime = ceil($deliveryStartTime / 300 ) * 300;
                        $tmpDeliveryTimeString = timeForDisplay($tmpDeliveryTime);
                    }
                    else {
                        $tmpDeliveryTime = strtotime($deliverySlotVal->StartTime);
                        $tmpDeliveryTimeString = timeForDisplay($tmpDeliveryTime);
                    }

                    do {
                        $arrAvailableTime[$tmpDeliveryTime] = $tmpDeliveryTimeString;

                        $tmpDeliveryTime = strtotime('+30 minutes', $tmpDeliveryTime);
                        $tmpDeliveryTimeString = timeForDisplay($tmpDeliveryTime);
                    } while ( $tmpDeliveryTime < strtotime($deliverySlotVal->EndTime) );
                }
            }
            else {
                $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"no_valid_time"));
                echo json_encode($returnRespond);
                die();
            }

            if( count($arrAvailableTime) > 0 ) {
                $dataFrView['arrAvailableTime'] = $arrAvailableTime;
                //printArr($dataFrView['arrAvailableTime']);

                $returnRespond = array("respond"=>array("error_flag"=>false, "content"=>$this->load->view('Order/time_segment', $dataFrView, true)));
            }
            else {
                //session_destroy();
                $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"no_valid_time"));
            }
            //      Order time related segment [ END ]          //
            //////////////////////////////////////////////////////
        }
	    else {
            session_destroy();
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"not_logged_in"));
        }

        echo json_encode($returnRespond);
    }

    public function ajaxOrderAddress() {
	    //$_POST['DeliveryAreaTitle'] = "PRIMARY ADDRESS";
        //$_POST['DeliveryAreaTitle'] = "Office";

        $dataFrView = array();

        if( $this->Customer_model->isLoggedIn() && isset($_SESSION['selectedOrderType']) && $_SESSION['selectedOrderType'] != "" ) {
            $arrCondtion = array();
            if( isset($_POST['DeliveryAreaTitle']) && $_POST['DeliveryAreaTitle'] != "" ) {
                $arrCondtion['CustAddLabel'] = $_POST['DeliveryAreaTitle'];
            }
            else {
                $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"no_delivery_label"));
                echo json_encode($returnRespond);
                die();
            }

            $arrCondtion['FK_CustId'] = $_SESSION['CustomerUserDetails']->PK_CustId;
            $arrCondtion['CustAddStatus'] = 1;

            $dataFrView['arrDeliveryAddress'] = $this->Utility_model->returnRecord("customer_address_book", false, $arrCondtion);
            //echo $this->db->last_query();

            //printArr($dataFrView['arrDeliveryAddress']);

            if( $dataFrView['arrDeliveryAddress'] == FALSE ) {
                $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"invalid_delivery_label"));
            }
            else {
                $returnRespond = array("respond"=>array("error_flag"=>false, "content"=>$this->load->view('Order/address_segment', $dataFrView, true)));

                //  Address inside delivery area [ START ]
                $arrDeliveryAddress['postcode'] = $dataFrView['arrDeliveryAddress'][0]->CityPostCode;
                $deliveryDetails = $this->Utility_model->getDeliveryDetails( $arrDeliveryAddress );

                if( $deliveryDetails != false ) {
                    //  Discount Details
                    if( isset($_SESSION['cartDetails']) && isset($_SESSION['cartDetails']['itemTotal']) && $_SESSION['cartDetails']['itemTotal'] > 0 ) {
                        $_SESSION['cartDetails']['discountDetails'] = $this->Cart_Utility_model->cartDiscountDetails( $_SESSION['cartDetails']['itemTotal'] );
                    }

                    $_SESSION['cartExtraDetails']['deliveryDetails'] = (array) $deliveryDetails;
                    $_SESSION['deliveryAddressDetails'] = $dataFrView['arrDeliveryAddress'][0];

                    $returnRespond["respond"]["delivery_details"] = array("error_flag"=>false, "msg"=>"inside_delivery_area");
                } else {
                    unset($_SESSION['cartDetails']['discountDetails']);
                    unset($_SESSION['cartExtraDetails']['deliveryDetails']);
                    unset($_SESSION['deliveryAddressDetails']);
;
                    $returnRespond["respond"]["delivery_details"] = array("error_flag"=>true, "error_msg"=>"not_inside_delivery_area");
                }
                //  Address inside delivery area [ END ]

                //printArr($_SESSION['deliveryAddressDetails']);
            }
        }
        else {
            session_destroy();
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"not_logged_in"));
        }


        //printArr( $returnRespond );
        echo json_encode($returnRespond);
    }
    //           AJAX Works [ END ]             //
    //////////////////////////////////////////////
    


}
