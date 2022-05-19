<div class="inner_global_container">
    <?php
    $this->load->view("common/leftPanel", $dataLeftPanel);
    $this->load->view("common/dashboardContent");
    ?>
</div>

<div class="global_gap10"></div>

<div class="inner_global_container">
    <div class="full_width_container overflow_auto">      	
        <form id="orderlist" name="orderlist" method="post" action="customer-order-list-page">
            <table cellspacing="0" cellpadding="0" class="payment-table">
                <tbody>
                    <tr class="odd">
                        <td class="bdr-right bdr-bottom">Ordre fra:</td>
                        <td class="bdr-right bdr-bottom">
                            <div class="input-parent input-container"><input data-beatpicker="true" value="24-08-2014" id="sdate" class="beatpicker-input beatpicker-inputnode" name="sdate" readonly="readonly"><button class="beatpicker-clear beatpicker-clearButton button">Clear</button></div>
                        </td>
                        
                        <td align="center" rowspan="2">
                            <input type="submit" value="Search" class="common-btn" style="width:100px;" name="Submit">
                        </td>
                    </tr>
                        
                    <tr class="even">   
                        <td class="bdr-right bdr-bottom">Ordre til:</td>
                        <td class="bdr-right bdr-bottom">
                            <div class="input-parent input-container"><input data-beatpicker="true" class="beatpicker-input beatpicker-inputnode" value="24-09-2014" id="edate" name="edate" readonly="readonly" data-beatpicker-id="beatpicker-1"><button class="beatpicker-clear beatpicker-clearButton button">Clear</button></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>

<div class="global_gap10"></div>

<div class="inner_global_container">
    <div class="full_width_container overflow_auto">

        <table cellspacing="0" cellpadding="0" border="0" class="payment-table">
            <tbody>
                <tr>
                    <td bgcolor="#dddddd" class="bdr-right bdr-bottom ">SL Nr.</td>
                    <td bgcolor="#dddddd" class="bdr-right bdr-bottom "><b>Status</b></td>
                    <td bgcolor="#dddddd" class="bdr-right bdr-bottom "><b>Order Type</b></td>
                    <td bgcolor="#dddddd" class="bdr-right bdr-bottom "><b>Payment Type</b></td>
                    <td bgcolor="#dddddd" class="bdr-right bdr-bottom "><b>Order Date</b></td>
                    <td bgcolor="#dddddd" class="bdr-right bdr-bottom "><b>Delivery Date</b></td>
                    <td bgcolor="#dddddd" class="bdr-right bdr-bottom "><b>Order Total</b></td>
                </tr>

                <?php
                if( $orderList != false) {
                    foreach ( $orderList as $ordKey => $ordObj ) {
                        ?>
                        <tr class="<?= ($ordKey%2 == 0) ? 'odd':'even'; ?>">
                            <td class="bdr-right bdr-bottom">
                                <a href="<?=    base_url()."customer/orderDetails/".encodeURLVal($ordObj->OrderSummaryId);   ?>" style="text-decoration:underline;">#<?= orderIdEncode($ordObj->OrderSummaryId);   ?></a>
                            </td>
                            <td class="bdr-right bdr-bottom"><?= get_global_values("OrderStatusArr", $ordObj->Status) ?></td>
                            <td class="bdr-right bdr-bottom"><?= get_global_values("OrderTypeArr", $ordObj->OrderType) ?></td>
                            <td class="bdr-right bdr-bottom"><?= get_global_values("PaymentTypeArr", $ordObj->PaymentType) ?></td>
                            <td class="bdr-right bdr-bottom"><?= dateTimeForDisplay( strtotime($ordObj->OrderDateTime) ) ?></td>
                            <td class="bdr-right bdr-bottom">
                                <?= dateTimeForDisplay( strtotime($ordObj->DeliveryDate." ".$ordObj->DeliveryTime) ) ?>
                            </td>
                            <td class="bdr-right bdr-bottom"><?= orderToatlCalculation($ordObj);   ?></td>
                        </tr>
                        <?php
                    }

                } else {
                    ?>
                    <tr class="odd">
                        <td class="bdr-right bdr-bottom" colspan="7" style="text-align:center; color: #9C0900;">
                            <b>No Orders Yet.</b>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>