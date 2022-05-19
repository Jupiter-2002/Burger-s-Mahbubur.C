<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="widget">

    <div class="title">
        <img src="<?php echo asset_url();?>dist/images/icons/dark/frames.png" alt="" class="titleIcon" />
        <h6 style="padding: 11px;">Topping List For Selection</h6>


        <div style="float: right; padding: 11px;">
            <a href="javascript:void(0);" class="tipS" original-title="Update" title="EDIT ITEM" onclick="loadSelectionToppingBaseForm(<?= $BaseItemDetails[0]->PK_BaseId ?>, <?= $SelecId; ?>)">
                <img src="<?php echo asset_url() ?>dist/images/icons/dark/settings.png" alt="">
            </a>
            <a href="javascript:void(0);" class="tipS" original-title="Update" title="TOPPING LIST" onclick="hideListSelectionSegment(<?= $BaseItemDetails[0]->PK_BaseId ?>, <?= $SelecId; ?>)">
                <img src="<?php echo asset_url() ?>dist/images/icons/dark/close.png" alt="">
            </a>
        </div>

    </div>

    <?php
    $currentToppCatId = "";
    $currentIdx = 1;
    if( isset($arrToppList) && is_array($arrToppList) ) {

        echo "<ul class=\"partners\">";

        foreach ($arrToppList as $toppObj) {
            if( ($currentToppCatId != "" && $currentToppCatId != $toppObj->PK_ToppCatId) ) {
                ?>
                    </tbody>
                </table>
                </div>
                </li>
                <?php
            }

            if( $currentToppCatId == "" || $currentToppCatId != $toppObj->PK_ToppCatId ) {
                $currentToppCatId = $toppObj->PK_ToppCatId;
                ?>
                <li>
                <div class="pInfo">
                    <a href="#" title=""><strong><?php echo $toppObj->ToppCatName;   ?></strong></a>
                </div>
                <div class="clear"></div>
                <div class="widget" style="margin-top: 10px;">
                <table cellpadding="0" cellspacing="0" width="100%" class="sTable">
                    <thead>
                    <tr>
                        <td class="sortCol"><div><b>Name</b></div></td>
                        <td class="sortCol"><div><b>Free</b></div></td>
                        <td class="sortCol"><div><b>Default</b></div></td>
                        <td class="sortCol"><div><b>Price</b></div></td>
                    </tr>
                    </thead>
                    <tbody>
                <?php
            }
            ?>

            <tr>
                <td><?php echo $toppObj->ToppName;	?></td>
                <td><?= ($toppObj->J_ToppFreeFlag == 1) ? "<b class='green'>YES":"<b class='red'>NO"; ?></td>
                <td><?= ($toppObj->J_ToppDefaultFlag == 1) ? "<b class='green'>YES":"<b class='red'>NO"; ?></td>
                <td>
                    <?php
                    if( $toppObj->J_ToppPrice != "" ) { echo $toppObj->J_ToppPrice; }
                    else if( $toppObj->ToppDefaultPrice != "" ) { echo $toppObj->ToppDefaultPrice; }
                    ?>
                </td>
            </tr>
            <?php
            $currentIdx++;
        }
        echo "</ul>";

    } else {
        ?>
        <div class="pInfo" style="margin-top: 25px; color: red; text-align: center; width: 100%;" >
            <b>
                No Topping Found.
                <a href="javascript:void(0);" onclick="loadSelectionToppingBaseForm(<?= $BaseItemDetails[0]->PK_BaseId ?>, <?= $SelecId; ?>)" >CLICK HERE</a> To Add New Topping.
            </b>
        </div>
        <?php
    }
    ?>

</div>