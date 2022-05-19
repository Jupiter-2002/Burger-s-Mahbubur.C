<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//////////////////////////////////////////////////////
//          For Input Validation [ Start ]          //
//  Accepts '0-9' only
if ( ! function_exists('isValidDigit')) {
    function isValidDigit( $parm ) {
        if( $parm != "" && ctype_digit($parm) ) {   return true;    }
        else {  return false;   }
    }
}
//          For Input Validation [ End ]            //
//////////////////////////////////////////////////////

//////////////////////////////////////////////////////
//                  Utility [ START ]               //
if ( ! function_exists('asset_url')) {
	function asset_url() {
		return base_url().'assets/';
	}
}
if ( ! function_exists('printArr')) {
    function printArr( $parmArr ) {
        echo "<pre>";   print_r($parmArr);  echo "</pre>";
    }
}
if ( ! function_exists('number_formate')) {
    function number_formate($value) {
        return number_format((float)$value, 2, '.', '');
    }
}
if ( ! function_exists('issetAndNotEmpty')) {
    function issetAndNotEmpty($value) {
        if( isset($value) && $value != "" && $value != null )  {
            return true;
        } else {
            return false;
        }
    }
}
if ( ! function_exists('resetFrNextOrder')) {
    function resetFrNextOrder() {
        clearCart();
        clearDeliveryAddress();
        clearOthers();
    }
}
if ( ! function_exists('clearCart')) {
    function clearCart() {
        unset($_SESSION['cartDetails']);
    }
}
if ( ! function_exists('clearDeliveryAddress')) {
    function clearDeliveryAddress() {
        unset($_SESSION['deliveryAddressDetails']);
    }
}
if ( ! function_exists('clearOthers')) {
    function clearOthers() {
        unset($_SESSION['cartExtraDetails']);
        unset($_SESSION['selectedOrderType']);
    }
}
if ( ! function_exists('sendMail')) {
    function sendMail( $to, $from, $title, $body ) {
        echo "to: ".$to."<br />";
        echo "from: ". $from."<br />";
        echo "title: ".$title."<br />";
        echo $body."<br />";
    }
}
//                  Utility [ END ]                 //
//////////////////////////////////////////////////////

//////////////////////////////////////////////////////
//      For Date and time portions [ START ]        //
//////////////////////////////////////////////////////

//      For Database Parsing [ Start ]
if ( ! function_exists('currentDateTimeForDb')) {
    function currentDateTimeForDb() {
        return date("Y-m-d H:i:s");
    }
}
if ( ! function_exists('currentDateForDb')) {
    function currentDateForDb() {
        return date("Y-m-d");
    }
}
if ( ! function_exists('dateTimeForDb')) {
    function dateTimeForDb( $strToTimeValue ) {
        return date("Y-m-d H:i:s", $strToTimeValue);
    }
}
if ( ! function_exists('dateForDb')) {
    function dateForDb( $strToTimeValue ) {
        return date("Y-m-d", $strToTimeValue);
    }
}
//      For Database Parsing [ End ]

//      For Display Parsing [ Start ]
if ( ! function_exists('currentTimeValue')) {
    function currentTimeValue() {
        return date("H:i");
    }
}
if ( ! function_exists('currentDateTimeForDisplay')) {
    function currentDateTimeForDisplay() {
        return date("d-m-Y H:i");
    }
}
if ( ! function_exists('currentDateForDisplay')) {
    function currentDateForDisplay() {
        return date("d-m-Y");
    }
}
if ( ! function_exists('dateTimeForDisplay')) {
    function dateTimeForDisplay( $strToTimeValue ) {
        return date("Y/m/d H:i", $strToTimeValue);
    }
}
if ( ! function_exists('dateForDisplay')) {
    function dateForDisplay( $strToTimeValue ) {
        return date("Y/m/d", $strToTimeValue);
    }
}
if ( ! function_exists('timeForDisplay')) {
    function timeForDisplay( $strToTimeValue ) {
        return date("H:i", $strToTimeValue);
    }
}
//      For Display Parsing [ End ]

//////////////////////////////////////////////////////
//      For Date and time portions [ END ]          //
//////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////
//          For Order Related Segments [ START ]                //
if ( ! function_exists('restauranOrderType')) {
    function restauranOrderType( $searchTypeId = null ) {
        $CI =& get_instance();

        $CI->db->from('restaurant_order_type');
        $CI->db->where('Status', 1);

        if( $searchTypeId != null &&  $searchTypeId != "" && $searchTypeId != 0 ) {
            $CI->db->where('OrderTypeId', $searchTypeId);
        }

        $query = $CI->db->get();

        if( $query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return false;
        }
    }
}
if ( ! function_exists('restauranOrderTypeByTime')) {
    function restauranOrderTypeByTime( $time ) {
        $CI =& get_instance();

        $CI->db->from('restaurant_order_type');
        $CI->db->where('Status', 1);
        $query = $CI->db->get();

        if( $query->num_rows() > 0 ) {
            $returnArr = array();
            foreach ( $query->result() as $row ) {
                if( orderTypeValidByTime($row->OrderTypeId, $time) ) {
                    $returnArr[] = $row;
                }
            }
            return $returnArr;
        } else {
            return false;
        }
    }
}
if ( ! function_exists('orderTypeValidByTime')) {
    function orderTypeValidByTime( $orderType, $time ) {
        //  Check the 'OrderType' with valid time from database[opeing, collection, delivery]
        //  If valid return 'true' if false return 'false'
        if( $orderType == 1 || $orderType == 2 ) {
            return true;
        } 
        else {
            return false;
        }
    }
}
if ( ! function_exists('selectedOrderType')) {
    function selectedOrderType() {
        //  Collection  -->  1
        //  Delivery    -->  2
        if( isset($_SESSION['selectedOrderType']) && $_SESSION['selectedOrderType'] != "" ) {
            return $_SESSION['selectedOrderType'];
        } else {
            return false;
        }
    }
}
if ( ! function_exists('orderIdEncode')) {
    function orderIdEncode( $orderId ) {
        return (10000 + $orderId);
    }
}
if ( ! function_exists('orderIdDecode')) {
    function orderIdDecode( $orderId ) {
        return ($orderId - 10000);
    }
}
if ( ! function_exists('orderToatlCalculation')) {
    function orderToatlCalculation( $orderSummaryObject ) {
        $orderTotal = $orderSummaryObject->TotalWithoutCCFee;

        if( $orderSummaryObject->CreditCardFee > 0 ) {
            $orderTotal += $orderSummaryObject->CreditCardFee;
        }

        return number_formate($orderTotal);
    }
}
//          For Order Related Segments [ END ]                  //
//////////////////////////////////////////////////////////////////



//  Decoding Value
if ( ! function_exists('decodeVal')) {
    function decodeVal( $parm ) {
        return base64_decode( $parm );
        //return $parm;
    }
}

//  Encoding Value
if ( ! function_exists('encodeVal')) {
    function encodeVal( $parm ) {
        return base64_encode( $parm );
        //return $parm;
    }
}

//  Decoding Value
if ( ! function_exists('decodeURLVal')) {
    function decodeURLVal( $parm ) {
        return base64_decode( urldecode( $parm ) );
        //return $parm;
    }
}

//  Encoding Value
if ( ! function_exists('encodeURLVal')) {
    function encodeURLVal( $parm ) {
        return urlencode( base64_encode( $parm ) );
        //return $parm;
    }
}

//  Get Restuarnt Info
if ( ! function_exists('restaurantInfo')) {
    function restaurantInfo() {
        $CI =& get_instance();

        $CI->db->from('restaurant_info');
        $CI->db->where('RestId', 1971);
        
        $query = $CI->db->get();

        if( $query->num_rows() > 0 ) {
            return $query->row();
        } else {
            return false;
        }
    }
}

//  Activate Payment Type
if ( ! function_exists('activePaymentType')) {
    function activePaymentType() {
        $CI =& get_instance();

        $CI->db->from('restaurant_payment_type');
        $CI->db->where('Status', 1);
        
        $query = $CI->db->get();

        if( $query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return false;
        }
    }
}

//  Unset Session after Order
if ( ! function_exists('unsetSessionAfterOrder')) {
    function unsetSessionAfterOrder() {
        unset($_SESSION['cartDetails']);
    }
}

//  Get the Delivery Details from the SESSION
if ( ! function_exists('getDeliveryDetailsWithKey')) {
    function getDeliveryDetailsWithKey( $KEY = NULL ) {
        if( isset($_SESSION['cartExtraDetails']['deliveryDetails']) && is_array($_SESSION['cartExtraDetails']['deliveryDetails']) ) {
            if( $KEY !== NULL ) {
                if( isset($_SESSION['cartExtraDetails']['deliveryDetails'][$KEY]) ) {	
                    return $_SESSION['cartExtraDetails']['deliveryDetails'][$KEY];	
                }
            }
            else {
                return $_SESSION['cartExtraDetails']['deliveryDetails'];
            }

        } else {
            return false;
        }
    }
}


//////////////////////////////////////////////////////////////////////////////
//      NOTE: All the 'Global' value as Name-Value pair are listed her      //
if(! function_exists('get_global_values')) {
    /*
     * NOTE : This Function For Global Name Value Pair Array Values
     * Return : With Key Parameter only the Key Value, For Without Key the whole Array
     * Syntex : get_global_values('OrderTypeArr', [key_value]);
     */
    function get_global_values( $var, $KEY = NULL, $KEY_LIMIT = NULL ) {
        $return = false;
        switch ($var) {
            case 'BaseTypeArr':
                $return = array('1'=>'Normal', '2'=>'Has Selection', '3'=>'Has Toppings', '4'=>'Combo Item', '5'=>'Selection Base Only', '6'=>'Special Item', '7'=>'Special Offer');
                if( $KEY !== NULL ) {
                    if( isset($return[$KEY]) )
                    {	$return = $return[$KEY];	}
                    else
                    {	$return = "no_such_key";	}
                }
                break;
            case 'BaseHotLevelArr':
                $return = array('1'=>'Extremely Hot', '2'=>'Extra Hot', '3'=>'Hot', '4'=>'Medium', '5'=>'Mild');
                if( $KEY !== NULL ) {
                    if( isset($return[$KEY]) )
                    {	$return = $return[$KEY];	}
                    else
                    {	$return = "no_such_key";	}
                }
                break;
            case 'GlobalDayArr':
                $return = array('7'=>'Sunday','1'=>'Monday','2'=>'Tuesday','3'=>'Wednesday','4'=>'Thursday','5'=>'Friday','6'=>'Saturday');
                if( $KEY !== NULL ) {
                    if( isset($return[$KEY]) )
                    {	$return = $return[$KEY];	}
                    else
                    {	$return = "no_such_key";	}
                }
                break;
            case 'GlobalMonthArr':
                $return = array('1'=>'January','2'=>'February','3'=>'March','4'=>'April','5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December');
                if( $KEY !== NULL ) {
                    if( isset($return[$KEY]) )
                    {	$return = $return[$KEY];	}
                    else
                    {	$return = "no_such_key";	}
                }
                break;
            case 'GlobalYearArr':
                $return = array('2018'=>'2018','2019'=>'2019','2020'=>'2020','2021'=>'2021');
                if( $KEY !== NULL ) {
                    if( isset($return[$KEY]) )
                    {	$return = $return[$KEY];	}
                    else
                    {	$return = "no_such_key";	}
                }
                break;
            case 'OrderStatusArr':
                $return = array('0'=>'Pending', '1'=>'Accepted', '2'=>'Rejected');
                if( $KEY !== NULL ) {
                    if( isset($return[$KEY]) )
                    {	$return = $return[$KEY];	}
                    else
                    {	$return = "no_such_key";	}
                }
                break;
            case 'OrderTypeArr':
                $return = array('1'=>'Collection', '2'=>'Delivery', '3'=>'Reservation');
                if( $KEY !== NULL ) {
                    if( isset($return[$KEY]) )
                    {	$return = $return[$KEY];	}
                    else
                    {	$return = "no_such_key";	}
                }
                break;
            case 'PaymentTypeArr':
                $return = array('1'=>'COD', '2'=>'Paypal', '3'=>'Stripe');
                if( $KEY !== NULL ) {
                    if( isset($return[$KEY]) )
                    {	$return = $return[$KEY];	}
                    else
                    {	$return = "no_such_key";	}
                }
                break;
            case 'DiscountTypeArr':
                $return = array('1'=>'Fixed', '2'=>'Percentage');
                if( $KEY !== NULL ) {
                    if( isset($return[$KEY]) )
                    {	$return = $return[$KEY];	}
                    else
                    {	$return = "no_such_key";	}
                }
                break;
            case 'BooleanArr':
                $return = array('1'=>'TRUE', '0'=>'FALSE');
                if( $KEY !== NULL ) {
                    if( isset($return[$KEY]) )
                    {	$return = $return[$KEY];	}
                    else
                    {	$return = "no_such_key";	}
                }
                break;
            case 'RestaurantType':
                $return = array('1'=>'Gold', '2'=>'Silver', '3'=>'Bronze');
                if( $KEY !== NULL ) {
                    if( isset($return[$KEY]) )
                    {	$return = $return[$KEY];	}
                    else
                    {	$return = "no_such_key";	}
                }
                break;
            case 'StarRatingArr':
                $return = array('1'=>'1 STAR', '2'=>'2 STAR', '3'=>'3 STAR', '4'=>'4 STAR', '5'=>'5 STAR');
                if( $KEY !== NULL ) {
                    if( isset($return[$KEY]) )
                    {	$return = $return[$KEY];	}
                    else
                    {	$return = "no_such_key";	}
                }
                break;
            case 'HygenicReportArr':
                $return = array('1'=>'1 Smiley', '2'=>'2 Smiley', '3'=>'3 Smiley', '4'=>'4 Smiley', '5'=>'5 Smiley');
                if( $KEY !== NULL ) {
                    if( isset($return[$KEY]) )
                    {	$return = $return[$KEY];	}
                    else
                    {	$return = "no_such_key";	}
                }
                break;
            case 'DatabaseSettings':
                $return = "I AM HERE";


                break;
            case 'OtherSettings':
                $ci=& get_instance();
                $ci->load->database();

                $query = $ci->db->get("SiteSettings");

                if( $query->num_rows() > 0 ) {
                    $returnArr = (array) $query->result()[0];

                    if( $KEY !== NULL ) {
                        if( isset($returnArr[$KEY]) )
                        {	$return = $returnArr[$KEY];	}
                        else
                        {	$return = "no_such_key";	}
                    }
                    break;
                }
                else
                {	$return = FALSE;	}

                break;
        }
        return $return;
    }
}
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////