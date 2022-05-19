<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="widget">
    <table cellpadding="0" cellspacing="0" width="100%" class="sTable">
        <thead>
        <tr>
            <td class="sortCol"><div>&nbsp;</div></td>
            <td class="sortCol"><div>Name</div></td>
            <td class="sortCol"><div>Price</div></td>
        </tr>
        </thead>
        <tbody>
        <?php
        if( isset($arrSelecList) && is_array($arrSelecList) ) {
            foreach ($arrSelecList as $selecObj) {
                ?>
                <tr>
                    <td>
                        <input type="checkbox" id="flagAddSelecToItm[<?php echo $selecObj->PK_SelecId;	?>]" name="flagAddSelecToItm[<?php echo $selecObj->PK_SelecId;	?>]"
                            <?= ($selecObj->PK_J_SelecToElement != "") ? "checked":""; ?> value="1">
                    </td>
                    <td><?php echo $selecObj->SelecName;	?></td>
                    <td>
                        <input type="text" id="priceSelec[<?php echo $selecObj->PK_SelecId;	?>]" name="priceSelec[<?php echo $selecObj->PK_SelecId;	?>]"
                               value="<?php
                               if( $selecObj->J_SelecPrice != "" ) { echo $selecObj->J_SelecPrice; }
                               else if( $selecObj->SelecDefaultPrice != "" ) { echo $selecObj->SelecDefaultPrice; }
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
                    <span style="color: red">No Selection Found</span>
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
            <a href="javascript:void(0);" title="" class="wButton greenwB" onclick="saveSelectionToBase(<?= $BaseDetails[0]->PK_BaseId;  ?>)"  style="color: white; height: 27px; line-height: 27px; float: left;" ><span>SAVE</span></a>
        </div>
    </div>
    <div class="oneThree">
        <div class="formRow">
            &nbsp;
        </div>
    </div>
    <div class="oneThree">
        <div class="formRow">
            &nbsp;
        </div>
    </div>
</div>

<script type="text/javascript">
//  This is to add different Validations based on HTML Class [assets/js/utility.js]
addCustomeClassValidator();
</script>
