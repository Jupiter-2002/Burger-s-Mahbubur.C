<div class="inner_global_container">
    <?php
    $this->load->view("common/leftPanel", $dataLeftPanel);
    $this->load->view("common/dashboardContent");

    //printArr($orderDetails);
    ?>
</div>

<div class="global_gap10"></div>

<div class="inner_global_container">
    <div class="form-area">

        <!--    Order Summary [ START ]     -->
        <div class="form-left">
            <div class="element1">
                <div class="heading">Order No. <?=  orderIdEncode($orderDetails['order_summary']->OrderSummaryId);    ?>:</div>

                <div class="content-area">
                    <div class="left">
                        <div class="left-text">Order Type:</div>
                    </div>
                    <div class="right-text">
                        <?=  get_global_values('OrderTypeArr', $orderDetails['order_summary']->OrderType);    ?> Order
                    </div>
                </div>
                <div class="content-area">
                    <div class="left">
                        <div class="left-text">Payment Type[Payment Status]:</div>
                    </div>
                    <div class="right-text">
                        <?=  get_global_values('PaymentTypeArr', $orderDetails['order_summary']->PaymentType);    ?>

                        [ <?= ( $orderDetails['order_summary']->PaymentStatus ) ? "PAID" : "NOT PAID";  ?> ]
                    </div>
                </div>
                <div class="content-area">
                    <div class="left">
                        <div class="left-text">Order Status:</div>
                    </div>
                    <div class="right-text">
                        <?=  get_global_values('OrderStatusArr', $orderDetails['order_summary']->Status);    ?>
                    </div>
                </div>
                <div class="content-area">
                    <div class="left">
                        <div class="left-text">Order Time:</div>
                    </div>
                    <div class="right-text">
                        <div class=""><?=  dateTimeForDisplay( strtotime($orderDetails['order_summary']->OrderDateTime) );    ?></div>
                    </div>
                </div>
                <div class="content-area">
                    <div class="left">
                        <div class="left-text">Delivery Time:</div>
                    </div>
                    <div class="right-text">
                        <?=  dateForDisplay( strtotime($orderDetails['order_summary']->DeliveryDate) );    ?>,
                        <?=  timeForDisplay( strtotime($orderDetails['order_summary']->DeliveryTime) );    ?>
                        <?= ( $orderDetails['order_summary']->CheckBoxASAP ) ? "[ ASAP ]" : "";  ?>
                    </div>
                </div>
                <div class="content-area">
                    <div class="left">
                        <div class="text_color_green left-text">Customer Contact:</div>
                    </div>
                    <div class="right-text">
                        <?=  $orderDetails['order_summary']->CustContact;  ?>
                    </div>
                </div>
            </div>
        </div>
        <!--    Order Summary [ END ]       -->

        <!--    Order Address Details [ START ]     -->
        <div class="form-right">
            <div class="element1">
                <div class="heading">Address Details :</div>

                <div class="content-area">
                    <div class="text_center text_color_green"><b><?= ($orderDetails['order_summary']->OrderType == 1) ? "RESTAURANT":"CUSTOMER" ?> ADDRESS</b></div>
                </div>

                <div class="content-area">
                    <div class="left">
                        <div class="left-text">Address 1:</div>
                    </div>
                    <div class="right-text">
                        <?=  $orderDetails['order_summary']->Address1;    ?>
                    </div>
                </div>
                <div class="content-area">
                    <div class="left">
                        <div class="left-text">Address 2:</div>
                    </div>
                    <div class="right-text">
                        <?=  $orderDetails['order_summary']->Address2;    ?>
                    </div>
                </div>
                <div class="content-area">
                    <div class="left">
                        <div class="left-text">City:</div>
                    </div>
                    <div class="right-text">
                        <?=  $orderDetails['order_summary']->City;    ?>
                    </div>
                </div>
                <div class="content-area">
                    <div class="left">
                        <div class="left-text">Town:</div>
                    </div>
                    <div class="right-text">
                        <?=  $orderDetails['order_summary']->Town;    ?>
                    </div>
                </div>
                <div class="content-area">
                    <div class="left">
                        <div class="left-text">Post Code:</div>
                    </div>
                    <div class="right-text">
                        <?=  $orderDetails['order_summary']->PostCode;    ?>
                    </div>
                </div>

            </div>
        </div>
        <!--    Order Address Details [ END ]       -->

        <!--    Order Item Details [ START ]    -->
        <div class="element1">
            <div class="content-area overflow_auto">

                <table class="payment-table" cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                    <tr>
                        <td class="bdr-right bdr-bottom" bgcolor="#dddddd"><b>Item</b></td>
                        <td class="bdr-right bdr-bottom text_center" bgcolor="#dddddd"><b>Unit Price</b></td>
                        <td class="bdr-right bdr-bottom text_center" bgcolor="#dddddd"><b>Qty</b></td>
                        <td class="bdr-right bdr-bottom text_center" bgcolor="#dddddd"><b>Price</b></td>
                    </tr>

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

                                    //  For Item Comments Segment [ START ]
                                    if( $orderDetailValue->itmComment != "" ) {
                                        ?>
                                        <b style="color: #00CC00">Comments: </b> <?= $orderDetailValue->itmComment;    ?><br />
                                        <?php
                                    }
                                    //  For Item Comments Segment [ END ]
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
                    //      For Delivery Fee [ START ]
                    if( $orderDetails['order_summary']->OrderType == 2 && $orderDetails['order_summary']->DeliveryFee != "" ) {
                        ?>
                        <tr class="odd global_text">
                            <td class="" bgcolor="#f5f7fa"><b>&nbsp;</b></td>
                            <td class="bdr-right" bgcolor="#f5f7fa" ><b>&nbsp;</b></td>
                            <td class="bdr-right bdr-bottom text_center" bgcolor="#ff8b8c"><b>Delivery Fee</b></td>
                            <td class="bdr-right bdr-bottom text_center" bgcolor="#ff8b8c"><b><?= number_formate($orderDetails['order_summary']->DeliveryFee)  ?></b></td>
                        </tr>
                        <?php
                    }
                    //      For Delivery Fee [ END ]

                    //  For Discounts [ START ]
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
                    //  For Discounts [ END ]
                    ?>



                    <tr class="odd global_text">
                        <td class="" bgcolor="#f5f7fa"><b>&nbsp;</b></td>
                        <td class="bdr-right" bgcolor="#f5f7fa"><b>&nbsp;</b></td>
                        <td class="bdr-right bdr-bottom text_center" bgcolor="#a9dbab"><b>Total</b></td>
                        <td class="bdr-right bdr-bottom text_center" bgcolor="#a9dbab"><b><?= number_formate($orderDetails['order_summary']->TotalWithoutCCFee)  ?></b></td>
                    </tr>

                    <?php
                    if( isset($orderDetails['order_summary']->CustComments) && $orderDetails['order_summary']->CustComments != "" ) {
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
        </div>
        <!--    Order Item Details [ END ]    -->

    </div>
</div>
