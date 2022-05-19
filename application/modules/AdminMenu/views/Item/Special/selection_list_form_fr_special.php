<tr id="SelectionOfItem_<?= $PK_BaseId; ?>">
    <td>
        <div class="widget" style="margin-top: 10px; display: block;">
            <?php
            //printArr($ItemSelectionList);

            $currentSelecCatId = "";
            $currentIdx = 1;

            foreach ($ItemSelectionList as $selecObj) {
                if( ($currentSelecCatId != "" && $currentSelecCatId != $selecObj->PK_SelecCatId) ) {
                        ?>
                        </tbody>
                        </table>
                    </div>
                    <?php
                }

                if( $currentSelecCatId == "" || $currentSelecCatId != $selecObj->PK_SelecCatId ) {
                    $currentSelecCatId = $selecObj->PK_SelecCatId;
                    ?>
                    <div class="pInfo" style="margin: 10px;">
                        <a href="javascript:void(0)" title=""><strong><?php echo $selecObj->SelecCatName;   ?></strong></a>
                    </div>
                    <div class="clear"></div>
                    <div class="widget" style="margin: 10px;">
                        <table class="sTable taskWidget" width="100%" cellspacing="0" cellpadding="0">
                            <thead>
                            <tr>
                                <td width="10%"><b>Is Available</b></td>
                                <td width="60%"><b>Name</b></td>
                                <td width="10%"><b>Price</b></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                        }
                    ?>

                <tr>
                    <td>
                        <input type="checkbox" id="flagAddToSpacial_Itm_Selection[<?= $PK_BaseId; ?>][<?= $selecObj->PK_SelecCatId ?>][]" name="flagAddToSpacial_Itm_Selection[<?= $PK_BaseId; ?>][<?= $selecObj->PK_SelecCatId ?>][]"
                               value="<?= $selecObj->PK_SelecId; ?>">
                    </td>
                    <td class="taskPr" style="vertical-align: top; padding-top: 14.5px;">
                        <?php echo $selecObj->SelecName;	?>
                    </td>
                    <td>
                        <input type="text" id="addToSpacial_Itm_Selection_Price[<?= $PK_BaseId; ?>][<?= $selecObj->PK_SelecCatId ?>][<?= $selecObj->PK_SelecId; ?>]" name="addToSpacial_Itm_Selection_Price[<?= $PK_BaseId; ?>][<?= $selecObj->PK_SelecCatId ?>][<?= $selecObj->PK_SelecId; ?>]"
                               value="<?= $selecObj->J_SelecPrice;	?>" class="onlyNumberClass">
                    </td>
                </tr>
                <?php
                $currentIdx++;


                if( $currentIdx > count($ItemSelectionList) ) {
                    ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </td>
</tr>
