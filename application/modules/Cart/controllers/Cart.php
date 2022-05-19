<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends MY_Controller {
	public function __construct() {
		parent::__construct();

        $this->load->model('Customer_model');
        $this->load->model('Front_model');
		$this->load->model('Utility_model');
        $this->load->model('Item_Utility_model');   //  For Item Based Functions
        
        $this->load->model('Cart_Utility_model');   //  For Cart Based Functions
	}

    //////////////////////////////////////////
    //        Cart Actions [ START ]        //
    public function ajaxAddToCart() {
        $returnRespond = array();

        if( isset($_POST['ItemId']) && $_POST['ItemId'] != "" ) {
            if( isset($_POST['Qty']) && $_POST['Qty'] != "" ) {
                $ItmOrderQty = decodeVal( urldecode($_POST['Qty'] ) );

                if( isValidDigit($ItmOrderQty) ) {
                    $arrItemDetails = $this->Item_Utility_model->returnItemDetailsBasedOnItemId( $_POST['ItemId'] );

                    //printArr($arrItemDetails);
                    
                    if( $arrItemDetails != false ) {
                        if( isset($arrItemDetails->BaseType) && $arrItemDetails->BaseType == 1 ) {

                            $processedData = $this->Cart_Utility_model->processAddedItem( $arrItemDetails );


                            //  Identification Key Genaration
                            //  New Version
                            $identificationKey = $processedData['IdentificationKey'];
                            //  Old Version
                            //  $identificationKey = $this->Cart_Utility_model->generateIdentificationKey( $arrItemDetails );


                            ////////////////////////////////////
                            //      Adding To CART [ START ]
                            ////////////////////////////////////

                            //  New Version
                            $itemUnitPrice = number_formate( $processedData['itemUnitPrice'] );
                            $itmDiscount = number_formate( $processedData['itmDiscount'] );

                            //  Old Version
                            //  $itemUnitPrice = number_formate( $this->Cart_Utility_model->getItemUnitPrice( $arrItemDetails ) );
                            //  $itmDiscount = number_formate( $this->Cart_Utility_model->getItemDiscount( $arrItemDetails ) );

                            $itmAfterDiscountUnitPrice = number_formate( $itemUnitPrice - $itmDiscount );

                            /*
                            $CatSortNo = (int) $arrItemDetails->CatSortNo??0;
                            $SubCatSortNo = (int) $arrItemDetails->SubCatSortNo??0;
                            $BaseSortNo = (int) $arrItemDetails->BaseSortNo??0;
                            */

                            $CatSortNo = (isset($arrItemDetails->CatSortNo)) ? (int) $arrItemDetails->CatSortNo : 0;
                            $SubCatSortNo = (isset($arrItemDetails->SubCatSortNo)) ? (int) $arrItemDetails->SubCatSortNo : 0;
                            $BaseSortNo = (isset($arrItemDetails->BaseSortNo)) ? (int) $arrItemDetails->BaseSortNo : 0;

                            if( isset($_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmQty']) && $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmQty'] > 0 ) {
                                $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmQty'] += (int) $ItmOrderQty;
                            }
                            else {
                                //  For Category Details [ START ]
                                $_SESSION['cartDetails']['itemList'][$CatSortNo]['CatDetails']['CatId'] = $arrItemDetails->FK_CatId;
                                $_SESSION['cartDetails']['itemList'][$CatSortNo]['CatDetails']['CatName'] = $arrItemDetails->CatName;
                                //  For Category Details [ END ]

                                //  For Sub Category Details [ START ]
                                if( isset($arrItemDetails->FK_SubCatId) && $arrItemDetails->FK_SubCatId != "" && $arrItemDetails->FK_SubCatId > 0 ) {
                                    $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['SubCatDetails']['SubCatId'] = $arrItemDetails->FK_SubCatId;
                                    $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['SubCatDetails']['SubCatName'] = $arrItemDetails->SubCatName;
                                }
                                //  For Sub Category Details [ END ]

                                //  For Basic Item Details [ START ]
                                $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmDetails'] = (array) $arrItemDetails;

                                $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmQty'] = (int) $ItmOrderQty;
                                $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmUnitPrice'] = $itemUnitPrice;
                                $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmDiscount'] = $itmDiscount;
                                $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmUnitPriceAfterDiscount'] = $itmAfterDiscountUnitPrice;
                                //  For Basic Item Details [ END ]
                            
                                //  For Sorting The Items
                                ksort($_SESSION['cartDetails']['itemList'], SORT_NUMERIC);
                                ksort($_SESSION['cartDetails']['itemList'][$CatSortNo], SORT_NUMERIC); 
                                ksort($_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'], SORT_NUMERIC);
                            }

                            $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmPrice'] = $itmAfterDiscountUnitPrice * $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmQty'];

                            /*
                             * OLD Section
                            if( isset($_SESSION['cartDetails']['itemTotal']) && $_SESSION['cartDetails']['itemTotal'] > 0 ) {
                                //  Already has ITEM in the CART so adding ONLY the Newly Added Item Price
                                $_SESSION['cartDetails']['itemTotal'] += number_formate($itmAfterDiscountUnitPrice * $ItmOrderQty);
                            } else {
                                //  Fresh Cart NO ITEM ADDED YET so adding the whole price of the item
                                $_SESSION['cartDetails']['itemTotal'] = number_formate($itmAfterDiscountUnitPrice * $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmQty']);
                            }
                            */

                            //  NEW Section
                            if( isset($_SESSION['cartDetails']['itemTotal']) && $_SESSION['cartDetails']['itemTotal'] > 0 ) {
                                //  Do Nothing
                            } else {
                                $_SESSION['cartDetails']['itemTotal'] = 0;
                            }

                            //  Add the price to cart
                            $_SESSION['cartDetails']['itemTotal'] = $_SESSION['cartDetails']['itemTotal'] + number_formate($itmAfterDiscountUnitPrice * $ItmOrderQty);
                            ////////////////////////////////////
                            //      Adding To CART [ END ]
                            ////////////////////////////////////

                            //  Discount Details
                            $_SESSION['cartDetails']['discountDetails'] = $this->Cart_Utility_model->cartDiscountDetails( $_SESSION['cartDetails']['itemTotal'] );

                            $returnRespond = array("respond"=>array("error_flag"=>false, "error_msg"=>""));
                        }
                        else {
                            // Send the 'itemDetails' as RESPOND and Trigger the POP Up in front end
                            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"invalid_ItemId"));
                        }
                    } 
                    else {
                        // Send the 'itemDetails' as RESPOND and Trigger the POP Up in front end
                        $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"invalid_ItemId"));  
                    }
                } else {
                    // Send the 'itemDetails' as RESPOND and Trigger the POP Up in front end
                    $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"invalid_qty"));      
                }
            } else {
                // Send the 'itemDetails' as RESPOND and Trigger the POP Up in front end
                $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"no_Qty"));      
            }
        } else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"no_ItemId"));       
        }

        echo json_encode($returnRespond);
        die();
    }

    public function ajaxAddToCartFrmPopUp() {
        $returnRespond = array();

        //printArr($_POST);
        //die();

        if( isset($_POST['ItemId']) && $_POST['ItemId'] != "" ) {
            if( isset($_POST['FormData']) ) {
                parse_str($_POST['FormData'], $postFormData);

                if (isset($postFormData['PopUpQty']) && isValidDigit($postFormData['PopUpQty']) && $postFormData['PopUpQty'] > 0) {
                    $ItmOrderQty = $postFormData['PopUpQty'];

                    $arrItemDetails = $this->Item_Utility_model->returnItemDetailsBasedOnItemId( $_POST['ItemId'] );

                    if( $arrItemDetails != false ) {
                        //  SELECTION Segments [ START ]
                        if( isset($postFormData['Base_Selec']) && count($postFormData['Base_Selec']) > 0 ) {
                            $arrSelectionDetailsBySelectionIDCond['Menu_Joint_Selections_To_Element.FK_ItemId'] = $_POST['ItemId'];
                            $arrItemDetails->SelectionDetails = $this->Item_Utility_model->returnSelectionDetailsBySelectionID_Arr( $postFormData['Base_Selec'], $arrSelectionDetailsBySelectionIDCond );
                        }

                        //  SELECTION Segments [ END ]

                        //  TOPPINGS Segments [ START ]
                        if( isset($postFormData['Base_Topping']) && count($postFormData['Base_Topping']) > 0 ) {
                            $tmpToppingsArr = array();

                            foreach ( $postFormData['Base_Topping'] as $selectedToppings ) {
                                $tmpToppingsArr = array_unique (array_merge ($tmpToppingsArr, array_keys($selectedToppings)));
                            }

                            if( is_array($tmpToppingsArr) && count($tmpToppingsArr) > 0 ) {
                                $arrToppingsDetailsByToppingIDCond['Menu_Joint_Toppings_To_Element.FK_ItemId'] = $_POST['ItemId'];
                                $arrItemDetails->ToppingsDetails = $this->Item_Utility_model->returnToppingDetailsByToppingID_Arr( $tmpToppingsArr, $arrToppingsDetailsByToppingIDCond );
                            }
                        }
                        //  TOPPINGS Segments [ END ]

                        //  Processing the Item for adding to CART
                        $processedData = $this->Cart_Utility_model->processAddedItem( $arrItemDetails );

                        ////////////////////////////////////
                        //      Adding To CART [ START ]
                        ////////////////////////////////////
                        $identificationKey = $processedData['IdentificationKey'];

                        $itemUnitPrice = number_formate( $processedData['itemUnitPrice'] );
                        $itmDiscount = number_formate( $processedData['itmDiscount'] );

                        $itmAfterDiscountUnitPrice = number_formate( $itemUnitPrice - $itmDiscount );

                        $CatSortNo = (isset($arrItemDetails->CatSortNo)) ? (int) $arrItemDetails->CatSortNo : 0;
                        $SubCatSortNo = (isset($arrItemDetails->SubCatSortNo)) ? (int) $arrItemDetails->SubCatSortNo : 0;
                        $BaseSortNo = (isset($arrItemDetails->BaseSortNo)) ? (int) $arrItemDetails->BaseSortNo : 0;

                        if( isset($_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmQty']) && $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmQty'] > 0 ) {
                            $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmQty'] += (int) $ItmOrderQty;
                        }
                        else {
                            //  For Category Details [ START ]
                            $_SESSION['cartDetails']['itemList'][$CatSortNo]['CatDetails']['CatId'] = $arrItemDetails->FK_CatId;
                            $_SESSION['cartDetails']['itemList'][$CatSortNo]['CatDetails']['CatName'] = $arrItemDetails->CatName;
                            //  For Category Details [ END ]

                            //  For Sub Category Details [ START ]
                            if( isset($arrItemDetails->FK_SubCatId) && $arrItemDetails->FK_SubCatId != "" && $arrItemDetails->FK_SubCatId > 0 ) {
                                $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['SubCatDetails']['SubCatId'] = $arrItemDetails->FK_SubCatId;
                                $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['SubCatDetails']['SubCatName'] = $arrItemDetails->SubCatName;
                            }
                            //  For Sub Category Details [ END ]

                            //  For Basic Item Details [ START ]
                            $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmDetails'] = (array) $arrItemDetails;

                            //  Item Comments
                            if (isset($postFormData['PopUpComment']) && $postFormData['PopUpComment'] != "") {
                                $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmComment'] = $postFormData['PopUpComment'];
                            }

                            $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmQty'] = (int) $ItmOrderQty;
                            $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmUnitPrice'] = $itemUnitPrice;
                            $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmDiscount'] = $itmDiscount;
                            $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmUnitPriceAfterDiscount'] = $itmAfterDiscountUnitPrice;
                            //  For Basic Item Details [ END ]

                            //  For Sorting The Items
                            ksort($_SESSION['cartDetails']['itemList'], SORT_NUMERIC);
                            ksort($_SESSION['cartDetails']['itemList'][$CatSortNo], SORT_NUMERIC);
                            ksort($_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'], SORT_NUMERIC);
                        }

                        $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmPrice'] = $itmAfterDiscountUnitPrice * $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmQty'];

                        /*
                         * OLD Section
                        if( isset($_SESSION['cartDetails']['itemTotal']) && $_SESSION['cartDetails']['itemTotal'] > 0 ) {
                            //  Already has ITEM in the CART so adding ONLY the Newly Added Item Price
                            $_SESSION['cartDetails']['itemTotal'] += number_formate($itmAfterDiscountUnitPrice * $ItmOrderQty);
                        } else {
                            //  Fresh Cart NO ITEM ADDED YET so adding the whole price of the item
                            $_SESSION['cartDetails']['itemTotal'] = number_formate($itmAfterDiscountUnitPrice * $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmQty']);
                        }
                        */

                        //  NEW Section
                        if( isset($_SESSION['cartDetails']['itemTotal']) && $_SESSION['cartDetails']['itemTotal'] > 0 ) {
                            //  Do Nothing
                        } else {
                            $_SESSION['cartDetails']['itemTotal'] = 0;
                        }

                        //  Add the price to cart
                        $_SESSION['cartDetails']['itemTotal'] += number_formate($itmAfterDiscountUnitPrice * $ItmOrderQty);
                        ////////////////////////////////////
                        //      Adding To CART [ END ]
                        ////////////////////////////////////

                        //  Discount Details
                        $_SESSION['cartDetails']['discountDetails'] = $this->Cart_Utility_model->cartDiscountDetails( $_SESSION['cartDetails']['itemTotal'] );

                        $returnRespond = array("respond"=>array("error_flag"=>false, "error_msg"=>""));
                    }
                    else {
                        // Send the 'itemDetails' as RESPOND and Trigger the POP Up in front end
                        $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"invalid_ItemId"));
                    }
                } else {
                    // Send the 'itemDetails' as RESPOND and Trigger the POP Up in front end
                    $returnRespond = array("respond" => array("error_flag" => true, "error_msg" => "invalid_qty"));
                }
            }
        } else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"no_ItemId"));
        }

        echo json_encode($returnRespond);
        die();
    }

    public function ajaxCartItemIncrease() {
        $returnRespond = array();
        $itemList = $_SESSION['cartDetails']['itemList'];

        $IncreaseQty = 0;
        $CatSortNo = "";
        $SubCatSortNo = "";
        $BaseSortNo = "";
        $identificationKey = "";

        if( isset($_POST['IncreaseQty']) && $_POST['IncreaseQty'] != "" && filter_var(decodeVal($_POST['IncreaseQty']), FILTER_VALIDATE_INT) ) {
            $IncreaseQty = (int) decodeVal($_POST['IncreaseQty']);
        } else {
            $IncreaseQty = 1;
        }


        //  Validation Part [ START ]
        if( isset($_POST['CatSortNo']) && $_POST['CatSortNo'] != "" ) {
            $CatSortNo = decodeVal($_POST['CatSortNo']);

            if( isset($itemList[$CatSortNo]) && is_array($itemList[$CatSortNo]) ) {
                
            } else {
                $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"invalid_CatSortNo"));
                echo json_encode($returnRespond);
                die();
            }
        } else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"no_CatSortNo"));      
            echo json_encode($returnRespond);
            die(); 
        }
        
        if( isset($_POST['SubCatSortNo']) && $_POST['SubCatSortNo'] != "" ) {
            $SubCatSortNo = decodeVal($_POST['SubCatSortNo']);

            if( isset($itemList[$CatSortNo][$SubCatSortNo]) && is_array($itemList[$CatSortNo][$SubCatSortNo]) ) {
                
            } else {
                $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"invalid_SubCatSortNo"));
                echo json_encode($returnRespond);
                die();
            }
        } else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"no_SubCatSortNo"));  
            echo json_encode($returnRespond);
            die();     
        }
        
        if( isset($_POST['ItemSortNo']) && $_POST['ItemSortNo'] != "" ) {
            $BaseSortNo = decodeVal($_POST['ItemSortNo']);

            if( isset($itemList[$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo]) && is_array($itemList[$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo]) ) {
                
            } else {
                $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"invalid_ItemSortNo"));
                echo json_encode($returnRespond);
                die();
            }
        } else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"no_ItemSortNo"));      
            echo json_encode($returnRespond);
            die(); 
        }
        
        if( isset($_POST['ItmIdentificationKey']) && $_POST['ItmIdentificationKey'] != "" ) {
            $identificationKey = decodeVal($_POST['ItmIdentificationKey']);

            if( isset($itemList[$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]) && is_array($itemList[$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]) ) {
                
            } else {
                $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"invalid_ItmIdentificationKey"));
                echo json_encode($returnRespond);
                die();
            }
        } else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"no_ItmIdentificationKey"));   
            echo json_encode($returnRespond);
            die();    
        }
        //  Validation Part [ END ]

        //  After validation of all data INCREASE item amount
        $itmUnitPriceAfterDiscount = $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmUnitPriceAfterDiscount'];

        $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmQty'] += (int) $IncreaseQty;

        //echo "#".$IncreaseQty."-".$_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmQty']."#";

        $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmPrice'] += number_formate($itmUnitPriceAfterDiscount * $IncreaseQty);

        //  Item Total Price
        $_SESSION['cartDetails']['itemTotal'] += number_formate($itmUnitPriceAfterDiscount * $IncreaseQty);
        
        //  Discount Details
        $_SESSION['cartDetails']['discountDetails'] = $this->Cart_Utility_model->cartDiscountDetails( $_SESSION['cartDetails']['itemTotal'] );
        
        echo json_encode( array("respond"=>array("error_flag"=>false, "error_msg"=>"")) );
        die();
    }
    
    public function ajaxCartItemDecrease() {
        $returnRespond = array();
        $itemList = $_SESSION['cartDetails']['itemList'];

        $DecreaseQty = "";
        $CatSortNo = "";
        $SubCatSortNo = "";
        $BaseSortNo = "";
        $identificationKey = "";

        
        if( isset($_POST['DecreaseQty']) && $_POST['DecreaseQty'] != "" && filter_var(decodeVal($_POST['DecreaseQty']), FILTER_VALIDATE_INT) ) {
            $DecreaseQty = (int) decodeVal($_POST['DecreaseQty']);
        } else {
            $DecreaseQty = 1;
        }

        //  Validation Part [ START ]
        if( isset($_POST['CatSortNo']) && $_POST['CatSortNo'] != "" ) {
            $CatSortNo = decodeVal($_POST['CatSortNo']);

            if( isset($itemList[$CatSortNo]) && is_array($itemList[$CatSortNo]) ) {
            } else {
                $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"invalid_CatSortNo"));
                echo json_encode($returnRespond);
                die();
            }
        } else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"no_CatSortNo"));      
            echo json_encode($returnRespond);
            die(); 
        }
        
        if( isset($_POST['SubCatSortNo']) && $_POST['SubCatSortNo'] != "" ) {
            $SubCatSortNo = decodeVal($_POST['SubCatSortNo']);

            if( isset($itemList[$CatSortNo][$SubCatSortNo]) && is_array($itemList[$CatSortNo][$SubCatSortNo]) ) {
            } else {
                $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"invalid_SubCatSortNo"));
                echo json_encode($returnRespond);
                die();
            }
        } else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"no_SubCatSortNo"));  
            echo json_encode($returnRespond);
            die();     
        }
        
        if( isset($_POST['ItemSortNo']) && $_POST['ItemSortNo'] != "" ) {
            $BaseSortNo = decodeVal($_POST['ItemSortNo']);

            if( isset($itemList[$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo]) && is_array($itemList[$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo]) ) {
            } else {
                $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"invalid_ItemSortNo"));
                echo json_encode($returnRespond);
                die();
            }
        } else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"no_ItemSortNo"));      
            echo json_encode($returnRespond);
            die(); 
        }
        
        if( isset($_POST['ItmIdentificationKey']) && $_POST['ItmIdentificationKey'] != "" ) {
            $identificationKey = decodeVal($_POST['ItmIdentificationKey']);

            if( isset($itemList[$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]) && is_array($itemList[$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]) ) {
            } else {
                $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"invalid_ItmIdentificationKey"));
                echo json_encode($returnRespond);
                die();
            }
        } else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"no_ItmIdentificationKey"));   
            echo json_encode($returnRespond);
            die();    
        }

        if( $DecreaseQty > $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmQty'] ) {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"invalid_qty"));   
            echo json_encode($returnRespond);
            die(); 
        }
        //  Validation Part [ END ]

        //echo "DecreaseQty: ".$DecreaseQty." itmQty: ".$_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmQty'];
        if( $DecreaseQty >= $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmQty'] ) {
            //  If 'DecreaseQty' is same or somehow bigger re-adjust the 'itemTotal'
            $_SESSION['cartDetails']['itemTotal'] -= $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmPrice'];

            unset($_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo]);

            if( count($_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails']) == 0 ) {
                //  IMPORTANT: The value of this 'COUNT' will always be MINIMUM 1 cause 'SubCatDetails' NODE is there, so if the 'COUNT' is 1 delete the NODE
                unset($_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]);
            }

            //  IMPORTANT: The value of this 'COUNT' will always be MINIMUM 1 cause 'CatDetails' NODE is there, so if the 'COUNT' is 1 delete the NODE
            if( count($_SESSION['cartDetails']['itemList'][$CatSortNo]) == 1 && isset($_SESSION['cartDetails']['itemList'][$CatSortNo]['CatDetails']) ) {
                unset($_SESSION['cartDetails']['itemList'][$CatSortNo]);
            }

            //  IMPORTANT: As no more Item is on the CART itemList Remove the whole 'cartDetails'
            if( count($_SESSION['cartDetails']['itemList']) == 0 ) {
                unset($_SESSION['cartDetails']);
            }
        } else {
            $itmUnitPriceAfterDiscount = $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmUnitPriceAfterDiscount'];

            $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmQty'] -= (int) $DecreaseQty;
            $_SESSION['cartDetails']['itemList'][$CatSortNo][$SubCatSortNo]['ItemListDetails'][$BaseSortNo][$identificationKey]['itmPrice'] -= number_formate($itmUnitPriceAfterDiscount * $DecreaseQty);

            //  Item Total Price
            $_SESSION['cartDetails']['itemTotal'] -= number_formate($itmUnitPriceAfterDiscount * $DecreaseQty);

            //  Discount Details
            $_SESSION['cartDetails']['discountDetails'] = $this->Cart_Utility_model->cartDiscountDetails( $_SESSION['cartDetails']['itemTotal'] );

        }

        echo json_encode( array("respond"=>array("error_flag"=>false, "error_msg"=>"")) );
    }
    
    public function ajaxLoadCart() {
        $returnRespond = array();

        //  Sorts the Array By NUMERIC values in the KEY        
        if( isset($_SESSION['cartDetails']) && is_array($_SESSION['cartDetails']) ) {
            $returnRespond['cartDetails'] = $_SESSION['cartDetails'];
        }

        //  Logged In Status
        $returnRespond['loggedInStatus'] = $this->Customer_model->isLoggedIn();

        $returnRespond['deliveryDetails'] = getDeliveryDetailsWithKey();

        $returnRespond['restauranOrderType'] = restauranOrderTypeByTime(time());
        
        //  Settings Items
        $returnRespond['currency'] = get_global_values('OtherSettings', 'Currency');
        
        //printArr( json_encode($returnRespond['cartDetails']) );
        //die();
        //printArr( $returnRespond );

        $returnRespond = array("respond"=>array("error_flag"=>false, "content"=>$this->load->view('cart/cart', $returnRespond, true)));
        echo json_encode($returnRespond);
    }
    
    public function ajaxLoadOrderCart() {
        $returnRespond = array();

        //  Sorts the Array By NUMERIC values in the KEY        
        if( isset($_SESSION['cartDetails']) && is_array($_SESSION['cartDetails']) ) {
            $returnRespond['cartDetails'] = $_SESSION['cartDetails'];
        }

        //  Logged In Status
        $returnRespond['loggedInStatus'] = $this->Customer_model->isLoggedIn();

        $returnRespond['deliveryDetails'] = getDeliveryDetailsWithKey();

        $returnRespond['restauranOrderType'] = restauranOrderTypeByTime(time());
        
        //  Settings Items
        $returnRespond['currency'] = get_global_values('OtherSettings', 'Currency');


        //////////////////////////////////////////////////////////
        //      Minimum Delivery amount segment [ START ]       //
        //echo "<br />itemTotal: ".$returnRespond['cartDetails']['itemTotal'];
        //echo "<br />MinDeliveryAmount: ".$returnRespond['deliveryDetails']['MinDeliveryAmount'];

        $validDeliveryOrderAmountFlag = true;
        $validDeliveryOrderAmountMsg = "";
        if( selectedOrderType() == 2 ) {
            if( isset($returnRespond['cartDetails']['itemTotal']) && isset($returnRespond['deliveryDetails']['MinDeliveryAmount']) && $returnRespond['cartDetails']['itemTotal'] < $returnRespond['deliveryDetails']['MinDeliveryAmount'] ) {
                $validDeliveryOrderAmountFlag = false;
                $validDeliveryOrderAmountMsg = "Please add more items as Total Item Price needs to be bigger than ".number_formate($returnRespond['deliveryDetails']['MinDeliveryAmount']);
            }
        }
        //      Minimum Delivery amount segment [ END ]         //
        //////////////////////////////////////////////////////////

        //printArr( $returnRespond );

        $returnRespond = array("respond"=>array(
            "error_flag"=>false,
            "content"=>$this->load->view('cart/order_cart', $returnRespond, true),
            "validDeliveryOrderAmountFlag"=>$validDeliveryOrderAmountFlag,
            "validDeliveryOrderAmountMsg"=>$validDeliveryOrderAmountMsg
        ));

        echo json_encode($returnRespond);
    }
    //         Cart Actions [ END ]         //
    //////////////////////////////////////////
}
?>