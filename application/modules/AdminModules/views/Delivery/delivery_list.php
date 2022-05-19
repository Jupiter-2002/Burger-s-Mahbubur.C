<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//printArr($recordList);
?>
<div class="widget">
    <div class="title">
        <img src="<?php echo asset_url();?>dist/images/icons/dark/frames.png" alt="" class="titleIcon" />
        <h6>Delivery Area List</h6>
    </div>

    <table cellpadding="0" cellspacing="0" width="100%" class="sTable">
        <thead>
        <tr>
            <td class="sortCol"><div>&nbsp;</div></td>
            <td class="sortCol" colspan="2"><div>POST CODE</div></td>
            <td class="sortCol" colspan="3"><div>DELIVERY</div></td>
            <td class="sortCol"><div>&nbsp;</div></td>
        </tr>
        <tr>
            <td class="sortCol"><div>TITLE</div></td>
            <td class="sortCol"><div>Half Post Code</div></td>
            <td class="sortCol"><div>Post Code List</div></td>
            <td class="sortCol"><div>Charge</div></td>
            <td class="sortCol"><div>Min. Amount</div></td>
            <td class="sortCol"><div>Time</div></td>
            <td class="sortCol"><div>ACTION</div></td>
        </tr>
        </thead>
        <tbody>
        <?php
        if( isset($recordList) && is_array($recordList) ) {
            foreach ($recordList as $recordObj) {
                ?>
                <tr>
                    <td><?php
                        echo $recordObj->DeliveryAreaTitle;
                        echo ($recordObj->FreeDeliveryFlag==1) ? "<br /><span class='red'><b>FREE DELIVERY</b></span>":"";
                        ?></td>
                    <td><?php echo $recordObj->HalfPostCode;	?></td>
                    <td><?php echo $recordObj->PostCodeList;	?></td>
                    <td><?php echo $recordObj->DeliveryCharge;	?></td>
                    <td><?php echo $recordObj->MinDeliveryAmount;	?></td>
                    <td><?php echo $recordObj->DeliveryTime;	?></td>

                    <td>
                        <a href="javascript:void(0);" class="button greenB" style="margin: 5px;" onclick="openEditDeliveryDiv(<?php echo $recordObj->PK_DeliveryAreaID;	?>)">
                            <img src="<?php echo asset_url() ?>/dist/images/icons/light/home.png" alt="" class="icon"><span>EDIT</span>
                        </a>

                        <a href="javascript:void(0);" class="button redB" style="margin: 5px;" onclick="ajaxDeleteDiscount(<?php echo $recordObj->PK_DeliveryAreaID;	?>)">
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
