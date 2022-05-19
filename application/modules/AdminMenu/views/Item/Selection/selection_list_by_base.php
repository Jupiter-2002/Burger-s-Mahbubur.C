<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="widget">

    <div class="title">
        <img src="<?php echo asset_url();?>dist/images/icons/dark/frames.png" alt="" class="titleIcon" />
        <h6 style="padding: 11px;">Selection List</h6>


        <div style="float: right; padding: 11px;">
            <a href="javascript:void(0);" class="tipS" original-title="Update" title="EDIT ITEM" onclick="loadBaseSelectionForm(<?= $BaseItemDetails[0]->PK_BaseId ?>)">
                <img src="<?php echo asset_url() ?>dist/images/icons/dark/settings.png" alt="">
            </a>
            <a href="javascript:void(0);" class="tipS" original-title="Update" title="SELECTION LIST" onclick="hideListSegment(<?= $BaseItemDetails[0]->PK_BaseId ?>)">
                <img src="<?php echo asset_url() ?>dist/images/icons/dark/close.png" alt="">
            </a>
        </div>

    </div>


    <?php
    $currentSelecCatId = "";
    $currentIdx = 1;

    if( isset($arrSelecList) && is_array($arrSelecList) ) {
        echo "<ul class=\"partners\">";

        foreach ($arrSelecList as $selecObj) {
            if( ($currentSelecCatId != "" && $currentSelecCatId != $selecObj->PK_SelecCatId) ) {
                ?>
                    </tbody>
                </table>
                </div>
                </li>
                <?php
            }

            if( $currentSelecCatId == "" || $currentSelecCatId != $selecObj->PK_SelecCatId ) {
                $currentSelecCatId = $selecObj->PK_SelecCatId;
                ?>
                <li>
                <div class="pInfo">
                    <a href="javascript:void(0)" title=""><strong><?php echo $selecObj->SelecCatName;   ?></strong></a>

                    <?php
                    if( isset($selecObj->J_SelecShowOnMenuFlag) && $selecObj->J_SelecShowOnMenuFlag == 1 ) {
                        ?>
                        <a href="#" title="" style="color: #00CC00"><strong>[ SHOW ON MENU ]</strong></a>
                        <?php
                    } else {
                        ?>
                        <a href="#" title="" style="color: #2e6b9b"><strong>[ SHOW ON POP UP ]</strong></a>
                        <?php
                    }
                    ?>

                </div>
                <div class="clear"></div>
                <div class="widget" style="margin-top: 10px;">
                <table cellpadding="0" cellspacing="0" width="100%" class="sTable">
                    <thead>
                    <tr>
                        <td class="sortCol"><div><b>Name</b></div></td>
                        <td class="sortCol"><div><b>Price</b></div></td>
                        <td class="sortCol"><div><b>Action</b></div></td>
                    </tr>
                    </thead>
                    <tbody>
                <?php
            }
            ?>

            <tr>
                <td><?php echo $selecObj->SelecName;	?></td>
                <td><?php echo $selecObj->J_SelecPrice;	?></td>
                <td>
                    <a href="javascript:void(0);" class="tipS" original-title="Update" title="TOPPING LIST"
                       onclick="loadBaseSelectionToppingList(<?= $selecObj->FK_ItemId; ?>, <?= $selecObj->PK_SelecId; ?>, true)"  >
                        <img src="<?php echo asset_url() ?>dist/images/icons/dark/files.png" alt="">
                    </a>
                    <a href="javascript:void(0);" class="tipS" original-title="Update" title="TOPPING ADD/EDIT"
                       onclick="loadSelectionToppingBaseForm(<?= $selecObj->FK_ItemId; ?>, <?= $selecObj->PK_SelecId; ?>)"  >
                        <img src="<?php echo asset_url() ?>dist/images/icons/dark/settings.png" alt="">
                    </a>
                </td>
            </tr>

            <tr id="TrSelecToppingCustomize_<?= $selecObj->FK_ItemId."_".$selecObj->PK_SelecId; ?>" name="TrSelecToppingCustomize_<?= $selecObj->FK_ItemId."_".$selecObj->PK_SelecId; ?>" style="display: none">
                <td colspan="3">
                    <div id="divSelecToppingAddEdit_<?= $selecObj->FK_ItemId."_".$selecObj->PK_SelecId; ?>" name="divSelecToppingAddEdit_<?= $selecObj->FK_ItemId."_".$selecObj->PK_SelecId; ?>" class="form widget" style="border:1px solid #cdcdcd; min-height: 100px; display: none; margin-top: 10px" ></div>

                    <div id="divSelecToppingList_<?= $selecObj->FK_ItemId."_".$selecObj->PK_SelecId; ?>" name="divSelecToppingList_<?= $selecObj->FK_ItemId."_".$selecObj->PK_SelecId; ?>" class="form widget" style="border:1px solid #cdcdcd; min-height: 100px; display: none; margin-top: 10px" ></div>
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
                No Selection Found.
                <a href="javascript:void(0);" onclick="loadBaseSelectionForm(<?= $BaseItemDetails[0]->PK_BaseId ?>)" >CLICK HERE</a> To Add New Selection.
            </b>
        </div>
        <?php
    }
    ?>

</div>