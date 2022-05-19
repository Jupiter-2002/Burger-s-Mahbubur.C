<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//printArr( $orderDetails['order_detail'] );
?>
<div class="custom_search_input_placement formRow widget" style="border:1px solid #cdcdcd;">

    <div class="custom_search_input_placement_50" name="divCategoryList" id="divCategoryList">
        <!--    Customer Details [ START ]   -->
        <div class="widget" style="margin-bottom: 10px;">
            <div class="title">
                <img src="http://localhost/new_rest_solo/assets/dist/images/icons/dark/frames.png" alt="" class="titleIcon">
                <h6>Customer Details</h6>
            </div>

            <div class="formRow">
                <label class="OrderDetails"><b>Name:</b></label>
                <div class="formRight" style="padding-top: 7px;" ><?= $orderDetails['customer_detail']->CustFirstName." ".$orderDetails['customer_detail']->CustLastName; ?></div>
                <div class="clear"></div>
            </div>

            <div class="formRow">
                <label class="OrderDetails"><b>E-Mail:</b></label>
                <div class="formRight" style="padding-top: 7px;" ><?= $orderDetails['customer_detail']->CustEmail; ?></div>
                <div class="clear"></div>
            </div>

            <div class="formRow">
                <label class="OrderDetails"><b>Registration Date:</b></label>
                <div class="formRight" style="padding-top: 7px;" ><?= $orderDetails['customer_detail']->CustRegistrationDate; ?></div>
                <div class="clear"></div>
            </div>

            <div class="formRow">
                <label class="OrderDetails"><b>Contact:</b></label>
                <div class="formRight" style="padding-top: 7px;" ><?= $orderDetails['customer_detail']->CustContact; ?></div>
                <div class="clear"></div>
            </div>

            <div class="formRow">
                <label class="OrderDetails"><b>Address:</b></label>
                <div class="formRight" style="padding-top: 7px;" >
                    <?php
                    echo $orderDetails['customer_detail']->CustAddress1."<br />".$orderDetails['customer_detail']->CustAddress2."<br />";
                    echo $orderDetails['customer_detail']->CityPostCode.", ";
                    if($orderDetails['customer_detail']->CustCity != "" ) { echo $orderDetails['customer_detail']->CustCity."<br />";   }
                    if($orderDetails['customer_detail']->CustTown != "" ) { echo $orderDetails['customer_detail']->CustTown."<br />";   }
                    ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <!--    Customer Details [ END ]     -->

        <!--    Order Update [ START ]   -->
        <div class="widget">
            <div class="title">
                <img src="http://localhost/new_rest_solo/assets/dist/images/icons/dark/frames.png" alt="" class="titleIcon">
                <h6><b>Update Status</b></h6>
            </div>

            <form action="<?= base_url()."adminmodules/adminorder/orderDetails/".encodeURLVal($orderDetails['order_summary']->OrderSummaryId); ?>" method="post">
                <div class="formRow">
                    <label class="OrderDetails"><b>Order Status</b>:</b></label>
                    <div class="formRight" style="padding-top: 3px;" >
                        <div class="selector">
                            <select name="Status" id="Status">
                                <?php
                                foreach ( $orderStatus as $statusKey => $statusValue ) {
                                    ?>
                                    <option <?= ( $orderDetails['order_summary']->Status==$statusKey ) ? 'selected="selected"':''; ?> value="<?=  $statusKey; ?>"><?=  $statusValue; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="formRow">
                    <label class="OrderDetails"><b>Payment Status:</b></label>
                    <div class="formRight" style="padding-top: 3px;" >
                        <div class="selector">
                            <select name="PaymentStatus" id="PaymentStatus">
                                <option <?= ( $orderDetails['order_summary']->PaymentStatus==0 ) ? 'selected="selected"':''; ?> value="0">NOT PAID</option>
                                <option <?= ( $orderDetails['order_summary']->PaymentStatus==1 ) ? 'selected="selected"':''; ?> value="1">PAID</option>
                            </select>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="formRow">
                    <label class="OrderDetails"><b>Restaurant Comment:</b></label>
                    <div class="formRight" style="padding-top: 3px;" >
                        <textarea name="RestaurantComments" id="RestaurantComments" style="width: 75%; height: 45px;"><?= $orderDetails['order_summary']->RestaurantComments;     ?></textarea>
                    </div>
                    <div class="clear"></div>
                </div>




                <div class="formRow">
                    <label class="OrderDetails">&nbsp;</label>
                    <div class="formRight" >
                        <button type="submit" name="StatusUpdate" id="StatusUpdate" value="Update" class="wButton greenwB" style="line-height: 15px">Update</button>
                    </div>
                    <div class="clear"></div>
                </div>
            </form>
        </div>
        <!--    Order Update [ END ]     -->
    </div>

    <div class="custom_search_input_placement_50" name="divSubCategoryList" id="divSubCategoryList">
        <!--    Order Summery [ START ]   -->
        <div class="widget" style="margin-bottom: 10px;">
            <div class="title">
                <img src="http://localhost/new_rest_solo/assets/dist/images/icons/dark/frames.png" alt="" class="titleIcon">
                <h6>Order Details</h6>
            </div>

            <div class="formRow">
                <label class="OrderDetails"><b>Order Type:</b></label>
                <div class="formRight" style="padding-top: 7px;"  style="padding-top: 7px;" ><?=  get_global_values('OrderTypeArr', $orderDetails['order_summary']->OrderType);    ?> Order</div>
                <div class="clear"></div>
            </div>

            <div class="formRow">
                <label class="OrderDetails"><b>Payment Type:</b></label>
                <div class="formRight" style="padding-top: 7px;"  style="padding-top: 7px;" >
                    <?=  get_global_values('PaymentTypeArr', $orderDetails['order_summary']->PaymentType);    ?>

                    [ <?= ( $orderDetails['order_summary']->PaymentStatus ) ? "PAID" : "NOT PAID";  ?> ]
                </div>
                <div class="clear"></div>
            </div>

            <div class="formRow">
                <label class="OrderDetails"><b>Order Status:</b></label>
                <div class="formRight" style="padding-top: 7px;"  style="padding-top: 7px;" >
                    <?=  get_global_values('OrderStatusArr', $orderDetails['order_summary']->Status);    ?>
                </div>
                <div class="clear"></div>
            </div>

            <div class="formRow">
                <label class="OrderDetails"><b>Order Time:</b></label>
                <div class="formRight" style="padding-top: 7px;"  style="padding-top: 7px;" >
                    <?=  dateTimeForDisplay( strtotime($orderDetails['order_summary']->OrderDateTime) );    ?>
                </div>
                <div class="clear"></div>
            </div>

            <div class="formRow">
                <label class="OrderDetails"><b>Delivery Time:</b></label>
                <div class="formRight" style="padding-top: 7px;"  style="padding-top: 7px;" >
                    <?=  dateForDisplay( strtotime($orderDetails['order_summary']->DeliveryDate) );    ?>,
                    <?=  timeForDisplay( strtotime($orderDetails['order_summary']->DeliveryTime) );    ?>
                    <?= ( $orderDetails['order_summary']->CheckBoxASAP ) ? "[ ASAP ]" : "";  ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <!--    Order Summery [ END ]     -->

        <!--    Address Details [ START ]   -->
        <div class="widget">
            <div class="title">
                <img src="http://localhost/new_rest_solo/assets/dist/images/icons/dark/frames.png" alt="" class="titleIcon">
                <h6>Address Details <b><?= ($orderDetails['order_summary']->OrderType == 1) ? "RESTAURANT":"CUSTOMER" ?> ADDRESS</b></h6>
            </div>

            <div class="formRow">
                <label class="OrderDetails"><b>Address 1:</b></label>
                <div class="formRight" style="padding-top: 7px;" ><?= $orderDetails['order_summary']->Address1; ?></div>
                <div class="clear"></div>
            </div>

            <div class="formRow">
                <label class="OrderDetails"><b>Address 2:</b></label>
                <div class="formRight" style="padding-top: 7px;" ><?= $orderDetails['order_summary']->Address2; ?></div>
                <div class="clear"></div>
            </div>

            <div class="formRow">
                <label class="OrderDetails"><b>City:</b></label>
                <div class="formRight" style="padding-top: 7px;" ><?= $orderDetails['order_summary']->City; ?></div>
                <div class="clear"></div>
            </div>

            <div class="formRow">
                <label class="OrderDetails"><b>Town:</b></label>
                <div class="formRight" style="padding-top: 7px;" ><?= $orderDetails['order_summary']->Town; ?></div>
                <div class="clear"></div>
            </div>

            <div class="formRow">
                <label class="OrderDetails"><b>POST CODE:</b></label>
                <div class="formRight" style="padding-top: 7px;" ><?= $orderDetails['order_summary']->PostCode; ?></div>
                <div class="clear"></div>
            </div>
        </div>
        <!--    Address Details [ END ]     -->
    </div>

    <!--    Order Item and Cart [ START ]   -->
    <div class="widget">
        <div class="title">
            <img src="<?php echo asset_url();?>dist/images/icons/dark/frames.png" alt="" class="titleIcon" />
            <h6>Order List</h6>
        </div>

        <table cellpadding="0" cellspacing="0" width="100%" class="sTable">
            <thead>
            <tr>
                <td class="sortCol"><div>Item</div></td>
                <td class="sortCol"><div>Unit Price</div></td>
                <td class="sortCol"><div>Qty</div></td>
                <td class="sortCol"><div>Price</div></td>
            </tr>
            </thead>

            <tbody>
            <?php
            if( $orderDetails['order_detail'] != false ) {
                foreach ($orderDetails['order_detail'] as $orderDetailKey => $orderDetailValue ) {
                    ?>
                    <tr class="<?=  ( $orderDetailKey%2 == 0 ) ? "even":"odd"; ?> global_text">
                        <td class="bdr-right bdr-bottom">
                            <?php
                            echo $orderDetailValue->CatName;
                            echo ($orderDetailValue->SubCatName != "" ) ? " - ".$orderDetailValue->SubCatName : "";
                            echo "<br />";

                            echo "<b>".$orderDetailValue->BaseName."</b>";
                            echo "<br />";

                            //  For Selection Segment [ START ]
                            if( $orderDetailValue->SelectionJSON != "" ) {
                                $arrTmpSelectionObj = json_decode($orderDetailValue->SelectionJSON);
                                //printArr($arrTmpSelectionObj);

                                foreach ( $arrTmpSelectionObj as $selectionObj ) {
                                    echo " [ ".$selectionObj->SelecCatName." - ".$selectionObj->SelecName." ]";
                                }
                                echo "<br />";
                            }
                            //  For Selection Segment [ END ]

                            //  For Toppings Segment [ START ]

                            if( $orderDetailValue->ToppingJSON != "" ) {
                                $arrTmpToppingObj = json_decode($orderDetailValue->ToppingJSON);
                                //printArr($arrTmpToppingObj);

                                foreach ( $arrTmpToppingObj as $toppingObj ) {
                                    echo " [ ".$toppingObj->ToppName." - ".$toppingObj->J_ToppPrice." ]";
                                }
                                echo "<br />";
                            }
                            //  For Toppings Segment [ END ]
                            ?>
                        </td>

                        <td class="bdr-right bdr-bottom text_center"><?= number_formate( $orderDetailValue->itmUnitPriceAfterDiscount );    ?></td>

                        <td class="bdr-right bdr-bottom text_center"><?= $orderDetailValue->itmQty;    ?></td>

                        <td class="bdr-right bdr-bottom text_center"><?= number_formate( $orderDetailValue->itmPrice );    ?></td>
                    </tr>
                    <?php
                }
            }
            ?>

            <tr class="odd global_text">
                <td class="" bgcolor="#f5f7fa"><b>&nbsp;</b></td>
                <td class="bdr-right" bgcolor="#f5f7fa"><b>&nbsp;</b></td>
                <td class="bdr-right bdr-bottom text_center" bgcolor="#a9dbab"><b>Item Total</b></td>
                <td class="bdr-right bdr-bottom text_center" bgcolor="#a9dbab"><b><?= number_formate($orderDetails['order_summary']->ItemTotal)  ?></b></td>
            </tr>

            <?php
            if( $orderDetails['order_summary']->DiscountDetailsJson != "" ) {
                $arrTmpDiscountObj = json_decode($orderDetails['order_summary']->DiscountDetailsJson);

                foreach ( $arrTmpDiscountObj as $discountObj ) {
                    ?>
                    <tr class="odd global_text">
                        <td class="" bgcolor="#f5f7fa"><b>&nbsp;</b></td>
                        <td class="bdr-right" bgcolor="#f5f7fa" ><b>&nbsp;</b></td>
                        <td class="bdr-right bdr-bottom text_center" bgcolor="#dcf7be"><b><?=   $discountObj->title  ?></b></td>
                        <td class="bdr-right bdr-bottom text_center" bgcolor="#dcf7be"><b><?= number_formate($discountObj->amount)  ?></b></td>
                    </tr>
                    <?php
                }
            }
            ?>

            <tr>
                <td class="" bgcolor="#f5f7fa"><b>&nbsp;</b></td>
                <td class="bdr-right" bgcolor="#f5f7fa"><b>&nbsp;</b></td>
                <td class="bdr-right bdr-bottom text_center" bgcolor="#a9dbab"><b>Total</b></td>
                <td class="bdr-right bdr-bottom text_center" bgcolor="#a9dbab"><b><?= number_formate($orderDetails['order_summary']->TotalWithoutCCFee)  ?></b></td>
            </tr>

            <?php
            if( $orderDetails['order_summary']->CustComments != "" ) {
                ?>
                <tr class="odd global_text">
                    <td class="" bgcolor="#bfddf5" colspan="4"><b>Comments: </b><?=   $orderDetails['order_summary']->CustComments  ?></td>
                </tr>
                <?php
            }
            ?>

            </tbody>
        </table>
    </div>
    <!--    Order Item and Cart [ END ]     -->
</div>
