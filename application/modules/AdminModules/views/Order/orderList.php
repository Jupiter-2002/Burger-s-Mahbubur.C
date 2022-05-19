<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//printArr( $recordList );
?>
<div class="custom_search_input_placement formRow widget" style="border:1px solid #cdcdcd;">
    <div class="form widget" style="margin-bottom: 10px;">
        <div class="title"><img src="<?php echo asset_url();?>dist/images/icons/dark/list.png" alt="" class="titleIcon" /><h6>Search Fields</h6></div>
        <fieldset>
            <form action="" method="post">
                <div class="widget">
                    <div class="oneFour">
                        <div class="formRow">
                            <label>Start Date:</label>
                            <div class="formRight">
                                <input name="startDate" id="startDate" type="text" class="datepicker"
                                       value="<?php
                                       if( isset($_POST['startDate']) && $_POST['startDate'] != "" ) { echo $_POST['startDate'];   }
                                       ?>" >
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>

                    <div class="oneFour">
                        <div class="formRow">
                            <label>End Date:</label>
                            <div class="formRight">
                                <input name="endDate" id="endDate" type="text" class="datepicker"
                                       value="<?php
                                       if( isset($_POST['endDate']) && $_POST['endDate'] != "" ) { echo $_POST['endDate'];   }
                                       ?>" >
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>

                    <div class="oneFour">
                        <div class="formRow">
                            <label>Type</label>:</label>
                            <div class="formRight">
                                <div class="selector">
                                    <select name="Status" id="Status">
                                        <option value="">Select Status</option>
                                        <?php
                                        foreach ( $orderStatus as $statusKey => $statusValue ) {
                                            ?>
                                            <option value="<?=  $statusKey; ?>"><?=  $statusValue; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>

                    <div class="oneFour">
                        <div class="formRow">
                            <button type="submit" name="SubmitBTN" id="SubmitBTN" value="Submit" class="wButton greenwB" style="line-height: 15px">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </fieldset>
    </div>


    <div class="widget">
        <div class="title">
            <img src="<?php echo asset_url();?>dist/images/icons/dark/frames.png" alt="" class="titleIcon" />
            <h6>Order List</h6>
        </div>

        <table cellpadding="0" cellspacing="0" width="100%" class="sTable">
            <thead>
            <tr>
                <td class="sortCol"><div>SL Nr.</div></td>
                <td class="sortCol"><div>Customer</div></td>
                <td class="sortCol"><div>Status</div></td>
                <td class="sortCol"><div>Order Type</div></td>
                <td class="sortCol"><div>Payment Type</div></td>
                <td class="sortCol"><div>Order Date</div></td>
                <td class="sortCol"><div>Delivery Date</div></td>
                <td class="sortCol"><div>Order Total</div></td>
                <td class="sortCol"><div>Action</div></td>
            </tr>
            </thead>
            <tbody>
            <?php
            //printArr($recordList);
            //die();

            if( isset($recordList) && is_array($recordList) ) {
                foreach ($recordList as $recordObj) {
                    ?>
                    <tr>
                        <td>
                            <a href="<?= base_url()."adminmodules/adminorder/orderDetails/".encodeURLVal($recordObj->OrderSummaryId); ?>" style="text-decoration:underline;">#<?= orderIdEncode($recordObj->OrderSummaryId);   ?></a>
                        </td>
                        <td>
                            <?php echo "<b>".$recordObj->CustFirstName." ".$recordObj->CustLastName."</b><br />".$recordObj->CustEmail;	?>
                        </td>
                        <td><?= get_global_values("OrderStatusArr", $recordObj->Status) ?></td>
                        <td><?= get_global_values("OrderTypeArr", $recordObj->OrderType) ?></td>
                        <td><?= get_global_values("PaymentTypeArr", $recordObj->PaymentType) ?></td>
                        <td><?= dateTimeForDisplay( strtotime($recordObj->OrderDateTime) ) ?></td>
                        <td>
                            <?= dateTimeForDisplay( strtotime($recordObj->DeliveryDate." ".$recordObj->DeliveryTime) ) ?>
                        </td>

                        <td><?= orderToatlCalculation($recordObj);   ?></td>

                        <td>
                            <a href="<?= base_url()."adminmodules/adminorder/orderDetails/".encodeURLVal($recordObj->OrderSummaryId); ?>" class="button greenB" style="margin: 5px;">
                                <img src="<?php echo asset_url() ?>/dist/images/icons/light/home.png" alt="" class="icon"><span>Details</span>
                            </a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="8">
                        No Orders.
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>