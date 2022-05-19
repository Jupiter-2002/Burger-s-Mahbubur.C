<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="widget">
    <div class="title">
        <img src="<?php echo asset_url();?>dist/images/icons/dark/frames.png" alt="" class="titleIcon" />
        <h6>Order Type List</h6>
    </div>

    <table cellpadding="0" cellspacing="0" width="100%" class="sTable">
        <thead>
        <tr>
            <td class="sortCol"><div>Order Type</div></td>
            <!--    <td class="sortCol"><div>Discount Type</div></td>   -->
            <td class="sortCol"><div>Amount</div></td>
            <td class="sortCol"><div>Minimum</div></td>
            <td class="sortCol"><div>Maximum</div></td>
            <td class="sortCol"><div>Start Date</div></td>
            <td class="sortCol"><div>End Date</div></td>

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
                    <td><?php echo get_global_values('OrderTypeArr', $recordObj->OrderTypeId);	?></td>
                    <!--    <td><?php echo get_global_values('DiscountTypeArr', $recordObj->DiscountType);	?></td> -->
                    <td>
                        <?php
                        echo $recordObj->DiscountAmount." [ ".get_global_values('DiscountTypeArr', $recordObj->DiscountType)." ]";
                        ?>
                    </td>
                    <td><?php echo $recordObj->StartAmount;	?></td>
                    <td><?php echo $recordObj->EndAmount;	?></td>
                    <td><?php echo dateForDisplay(strtotime($recordObj->StartDate));	?></td>
                    <td><?php echo dateForDisplay(strtotime($recordObj->EndDate));	?></td>

                    <td>
                        <a href="javascript:void(0);" class="button greenB" style="margin: 5px;" onclick="openEditDiscountDiv(<?php echo $recordObj->PK_DiscountId;	?>)">
                            <img src="<?php echo asset_url() ?>/dist/images/icons/light/home.png" alt="" class="icon"><span>EDIT</span>
                        </a>

                        <a href="javascript:void(0);" class="button redB" style="margin: 5px;" onclick="ajaxDeleteDiscount(<?php echo $recordObj->PK_DiscountId;	?>)">
                            <img src="<?php echo asset_url() ?>/dist/images/icons/light/home.png" alt="" class="icon"><span>DELETE</span>
                        </a>
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="8">
                    No Discount Yet.
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
