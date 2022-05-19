<?php
//printArr($_SESSION);

//  Order Type Validation [ START ]
if( !isset($_SESSION['selectedOrderType']) || !in_array($_SESSION['selectedOrderType'], array(1,2)) ) {
    session_destroy();
    header("Location: ".base_url()."menu");
    die();
}
//  Order Type Validation [ END ]


//echo "<br />".date('Y-m-d')." -> ".date('D');
//echo "<br />".date('d-m-y h:i:s N');
?>

<div class="inner_global_container">
    
    <div class="innergrid4">
    <form method="POST" action="submit" onsubmit="return orderSubmitValidation()">

        <!--        Timing and Special Instructions [ START ]       -->
        <div class="full_width_container" id="orderTimeSegment" class="orderTimeSegment" >
            <img src="../assets/dist/images/loaders/loader9.gif" alt="" style="padding: 60px 48.5%">
        </div>
        <!--        Timing and Special Instructions [ END ]         -->

        <!--        Address Details [ START ]       -->
        <div class="full_width_container full_width_container_gap">
            <?php
            if( isset($_SESSION['selectedOrderType']) ) {
                if( $_SESSION['selectedOrderType'] == 1 ) {
                    //  Collection
                    ?>
                    <div class="text_headings">
                        Collection Address:
                    </div>  
                    <table border="0" cellspacing="0" cellpadding="0" class="payment-table">
                        <tbody>
                            <tr class="odd">
                                <td width="40%" class="bdr-right bdr-bottom table-detail-font1">Restaurant Name:</td>
                                <td width="60%" class="bdr-bottom table-detail-font1"><b><?= $restaurantInfo->RestName ?></b></td>
                            </tr>
                            <tr class="even">
                                <td width="40%" class="bdr-right bdr-bottom table-detail-font1">Address 1:</td>
                                <td width="60%" class="bdr-bottom table-detail-font1"><?= $restaurantInfo->RestAddress1 ?></td>
                            </tr>
                            <tr class="odd">
                                <td width="40%" class="bdr-right bdr-bottom table-detail-font1">Address 2:</td>
                                <td width="60%" class="bdr-bottom table-detail-font1"><?= $restaurantInfo->RestAddress2 ?></td>
                            </tr>
                            <tr class="even">
                                <td width="40%" class="bdr-right bdr-bottom table-detail-font1">Town:</td>
                                <td width="60%" class="bdr-bottom table-detail-font1"><?= $restaurantInfo->RestTown ?></td>
                            </tr>
                            <tr class="odd">
                                <td width="40%" class="bdr-right bdr-bottom table-detail-font1">City:</td>
                                <td width="60%" class="bdr-bottom table-detail-font1"><?= $restaurantInfo->RestCity ?></td>       
                            </tr>
                            <tr class="even">
                                <td width="40%" class="bdr-right bdr-bottom table-detail-font1">Postcode:</td>
                                <td width="60%" class="bdr-bottom table-detail-font1"><?= $restaurantInfo->RestPostCode ?></td>   
                            </tr>
                            <tr class="odd">
                                <td width="40%" class="bdr-right bdr-bottom table-detail-font1">Phone:</td>
                                <td width="60%" class="bdr-bottom table-detail-font1"><?= $restaurantInfo->RestPhone ?></td>     
                            </tr>
                            <tr class="even">
                                <td width="40%" class="bdr-right bdr-bottom table-detail-font1">E-Mail:</td>
                                <td width="60%" class="bdr-bottom table-detail-font1"><?= $restaurantInfo->RestEMail ?></td>     
                            </tr>                                                      
                        </tbody>
                    </table>

                    <?php
                }
                else if( $_SESSION['selectedOrderType'] == 2 ) {
                    //      Delivery
                    ?>
                    <div class="text_headings">
                        Where To Deliver [ PENDING ]:
                    </div>

                    <!--        Address Label with Drop Down [ START ]      -->
                    <table border="0" cellspacing="0" cellpadding="0" class="payment-table" style="border-collapse: collapse; margin-bottom: 5px;">
                        <tr class="even" style="border: 1px solid green;">
                            <td width="40%" class="bdr-right table-detail-font1" style="color: #358f4b; font-weight: bold">Delivery Address Label:</td>
                            <td width="60%" class="table-detail-font1">
                                <select class="dropdown" name="DeliveryAreaTitle" id="DeliveryAreaTitle" onchange="getAddressDetails()">
                                    <?php
                                    foreach ($arrDeliveryAddress as $deliveryKey => $deliveryValue ) {
                                        ?>
                                        <option value="<?= $deliveryValue->CustAddLabel; ?>" <?php
                                        if( isset($_SESSION['deliveryAddressDetails']->CustAddLabel) && $deliveryValue->CustAddLabel == $_SESSION['deliveryAddressDetails']->CustAddLabel ) {
                                            echo 'selected="selected"';
                                        }
                                        else if( $deliveryValue->CustAddLabel == "PRIMARY ADDRESS" ) {
                                            echo 'selected="selected"';
                                        }
                                        ?> ><?= $deliveryValue->CustAddLabel; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>

                                <a style="display: block; color: red; float: right; padding-top: 5px;" onclick="newAddressForm()" >New Address</a>
                            </td>
                        </tr>
                        <tr class="even" style="border: 1px solid green;" id="trAddressStatusLable">
                            <td width="100%" colspan="2" id="tdAddressStatusLable" class="table-detail-font1" style="font-weight: bold">LOADING....</td>
                        </tr>
                    </table>
                    <!--        Address Label with Drop Down [ END ]        -->


                    <table border="0" cellspacing="0" cellpadding="0" class="payment-table" id="deliveryAddressDetails"  >
                        <tr class="even" style="border: 1px solid green;">
                            <td width="100%" class="table-detail-font1">
                                <img src="../assets/dist/images/loaders/loader9.gif" alt="" style="padding: 80px 48.5%">
                            </td>
                        </tr>
                    </table>
                    <?php
                }
            }
            ?>
        </div>
        <!--        Address Details [ END ]         -->

        <!--        Order Comments [ START ]        -->
        <div class="full_width_container full_width_container_gap">
            <div class="text_headings">Comment:</div>

            <table class="payment-table" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                <tr class="odd">
                    <td class="bdr-right bdr-bottom table-detail-font1" width="100%">
                        <textarea name="CustComments" id="CustComments" style="width: 98%; margin: 1%; box-sizing: border-box;" rows="10" placeholder="Order Comments"></textarea>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <!--        Order Comments [ END ]          -->

        <div class="full_width_container full_width_container_gap">
            <!--    Payment Method [ START ]    -->
            <div class="text_headings">Payment Method :</div>   
            <table border="0" cellspacing="0" cellpadding="0" class="payment-table">
                <tbody>
                    <?php
                    if( isset($activePaymentType) && count($activePaymentType) > 0 ) {
                        foreach( $activePaymentType as $paymentTypeKey => $paymentTypeObj ) {
                            if( $paymentTypeKey % 2 ) {
                                ?>
                                <tr class="odd">
                                <?php
                            }
                            else {
                                ?>
                                <tr class="even">
                                <?php
                            }
                            
                            if( $paymentTypeObj->Name === "COD" ) {
                                ?>
                                <td colspan="2" class="bdr-bottom table-detail-font1">
                                    <input type="radio" name="pay_mathod" checked="checked" value="<?= $paymentTypeObj->PaymentTypeId ?>" style="margin:6px 0 0 0;">
                                    &nbsp; Cash on Delivery/Collection	
                                </td> 
                                <?php
                            }
                            else {
                                ?>
                                <td colspan="2" class="bdr-bottom table-detail-font1">
                                    <input type="radio" name="pay_mathod" value="<?= $paymentTypeObj->PaymentTypeId ?>" style="margin:6px 0 0 0;">
                                    &nbsp; Pay by Debit/Credit Card <span style="color: forestgreen; text-transform: uppercase;">[ <?= $paymentTypeObj->Name ?> ]</span>	
                                    &nbsp; <img width="134" height="20" title="" alt="" src="images/payment-pic-small.jpg" style="margin:0 0 0 5px; vertical-align:middle;">
                                </td>  
                                <?php
                            }
                            ?>

                            </tr>
                            <?php
                        }
                    }
                    else {
                        ?>
                        <tr class="odd">
                            <td colspan="2" class="bdr-bottom table-detail-font1">
                                No Payment Type Available
                            </td>                   
                        </tr>
                        <?php
                    }
                    ?>                                                              
                </tbody>
            </table>
            <!--    Payment Method [ EN ]       -->

            <div class="full_width_container_gap">
                <input type="submit" name="submitBtn" id="submitBtn" value="Submit Order" class="button-submit">
            </div>   
        </div>
    </form>    
    </div>


    <!--    CART SECTION [ START ]      -->
    <div class="innergrid3">
        <div id="cartLoad" class="mycart" style="padding-top: 0px; padding-bottom: 1px; position: static; top: 0px;">
            <img src="../assets/dist/images/loaders/loader9.gif" alt="" style="padding: 40px 48.5%">
        </div>
    </div>
    <!--    CART SECTION [ END ]      -->
</div>

<script type="text/javascript" src="<?php echo asset_url(); ?>js/Order/order.js"></script>

<script type="text/javascript">
    $(window).on('load', function() {
        <?php
        if( $_SESSION['selectedOrderType'] == 1 ) {
            //  Collection
            ?>
            loadOrderPlacingPageContentFrCollection();
            <?php
        }
        else if( $_SESSION['selectedOrderType'] == 2 ) {
            //  Delivery
            ?>
            loadOrderPlacingPageContentFrDelivery();
            <?php
        }
        ?>
    });
</script>


