<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="widget">
    <table cellpadding="0" cellspacing="0" width="100%" class="sTable">
        <thead>
        <tr>
            <td class="sortCol"><div>&nbsp;</div></td>
            <td class="sortCol"><div>Name</div></td>
            <td class="sortCol"><div>Free</div></td>
            <td class="sortCol"><div>Default</div></td>
            <td class="sortCol"><div>Price</div></td>
        </tr>
        </thead>
        <tbody>
        <?php
        if( isset($arrToppList) && is_array($arrToppList) ) {
            foreach ($arrToppList as $toppObj) {
                ?>
                <tr>
                    <td>
                        <input type="checkbox" id="flagAddToppToItm[<?php echo $toppObj->PK_ToppId;	?>]" name="flagAddToppToItm[<?php echo $toppObj->PK_ToppId;	?>]"
                            <?= ($toppObj->PK_J_ToppintToElement != "") ? "checked":""; ?> value="1">
                    </td>
                    <td><?php echo $toppObj->ToppName;	?></td>
                    <td>
                        <input type="checkbox" id="flagToppFree[<?php echo $toppObj->PK_ToppId;	?>]" name="flagToppFree[<?php echo $toppObj->PK_ToppId;	?>]"
                            <?= ($toppObj->J_ToppFreeFlag == 1) ? "checked":""; ?> value="1"">
                    </td>
                    <td>
                        <input type="checkbox" id="flagToppDefault[<?php echo $toppObj->PK_ToppId;	?>]" name="flagToppDefault[<?php echo $toppObj->PK_ToppId;	?>]"
                            <?= ($toppObj->J_ToppDefaultFlag == 1) ? "checked":""; ?> value="1"">
                    </td>
                    <td>
                        <input type="text" id="priceTopp[<?php echo $toppObj->PK_ToppId;	?>]" name="priceTopp[<?php echo $toppObj->PK_ToppId;	?>]"
                               value="<?php
                               if( $toppObj->J_ToppPrice != "" ) { echo $toppObj->J_ToppPrice; }
                               else if( $toppObj->ToppDefaultPrice != "" ) { echo $toppObj->ToppDefaultPrice; }
                                ?>"
                               class="onlyNumberClass">
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="5" style="text-align: center">
                    <span style="color: red">No Topping Found</span>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>

<div class="widget">
    <div class="oneThree">
        <div class="formRow">
            <label>MAX:</label>
            <div class="formRight"><input name="MaxTopp" id="MaxTopp" type="text" value="<?= (isset($joinToppToBaseSummary[0]->J_ToppMax) && $joinToppToBaseSummary[0]->J_ToppMax != "") ? $joinToppToBaseSummary[0]->J_ToppMax:""; ?>" class="onlyIntegerClass"></div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="oneThree">
        <div class="formRow">
            <label>FREE:</label>
            <div class="formRight"><input name="FreeTopp" id="FreeTopp" type="text" value="<?= (isset($joinToppToBaseSummary[0]->J_ToppFree) &&$joinToppToBaseSummary[0]->J_ToppFree != "") ? $joinToppToBaseSummary[0]->J_ToppFree:""; ?>" class="onlyIntegerClass"></div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="oneThree">
        <div class="formRow">
            <a href="javascript:void(0);" title="" class="wButton greenwB" onclick="saveToppingToBaseSelection(<?= $BaseDetails[0]->PK_BaseId;  ?>, <?= $SelecId; ?>)"  style="color: white; height: 27px; line-height: 27px; float: left;" ><span>SAVE</span></a>
        </div>
    </div>
</div>

<script type="text/javascript">
//  This is to add different Validations based on HTML Class [assets/js/utility.js]
addCustomeClassValidator();
</script>
