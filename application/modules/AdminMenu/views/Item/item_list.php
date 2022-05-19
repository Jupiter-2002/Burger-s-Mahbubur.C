<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//printArr($arrItemList);
?>
<div class="widget">

    <div class="title">
        <img src="<?php echo asset_url();?>dist/images/icons/dark/frames.png" alt="" class="titleIcon" />
        <h6>Item List of <b class="blue"><?= strtoupper($arrCategoryDetails[0]->CatName);   ?></b></h6>
    </div>

    <?php
    if( isset($arrItemList) && is_array($arrItemList) ) { ?>
        <ul class="partners">
        <?php
        $tmpSubCategor = "";

        $currentItmCounter = 0;

        for( $currentItmCounter = 0; $currentItmCounter < count($arrItemList);  ) {


            if( $tmpSubCategor != $arrItemList[$currentItmCounter]->SubCatName || ( $currentItmCounter == 0 && $arrItemList[$currentItmCounter]->SubCatName == "" ) ) {
                $tmpSubCategor = $arrItemList[$currentItmCounter]->SubCatName;
                ?>
                <li>
                    <?php
                    if( isset($arrItemList[$currentItmCounter]->SubCatName) && $arrItemList[$currentItmCounter]->SubCatName != "" ) {
                        ?>
                        <div class="pInfo">
                            <a href="#" title=""><strong><?php echo $arrItemList[$currentItmCounter]->SubCatName;   ?></strong></a>
                            <i><?php echo $arrItemList[$currentItmCounter]->SubCatDesc;   ?></i>
                        </div>

                        <div class="clear"></div>
                        <?php
                    }
                    ?>

                    <div class="widget" style="margin-top: 10px;">
                        <table class="sTable taskWidget" width="100%" cellspacing="0" cellpadding="0">
                            <thead>
                            <tr>
                                <td width="60%">Name</td>
                                <td width="10%">Type</td>
                                <td width="10%">Price</td>
                                <td width="20%">Actions</td>
                            </tr>
                            </thead>
                            <tbody>
                <?php
            }
            ?>

            <tr>
                <td class="taskPr" style="vertical-align: top; padding-top: 14.5px;">
                    <?php
                    if( isset($arrItemList[$currentItmCounter]->BaseNo) && $arrItemList[$currentItmCounter]->BaseNo != "" ) {
                        echo "<b>".$arrItemList[$currentItmCounter]->BaseNo.". </b>";
                    }
                    ?>
                    <b><?php   echo $arrItemList[$currentItmCounter]->BaseName;    ?></b>

                    <a href="javascript:void(0);" class="tipS" original-title="Update" title="EDIT ITEM" style="color: red" onclick="loadEditItemDiv(<?=$arrItemList[$currentItmCounter]->PK_BaseId;    ?>)"  >
                        <b>[ EDIT ]</b>
                    </a>

                    <?php   echo ($arrItemList[$currentItmCounter]->BaseDesc!="") ? "</br>".$arrItemList[$currentItmCounter]->BaseDesc : "";    ?>
                </td>
                <td><?php   echo $BaseTypeArr[$arrItemList[$currentItmCounter]->BaseType];    ?></td>
                <td><span class="green f11"><?php   echo number_format($arrItemList[$currentItmCounter]->BasePrice,2);    ?></span></td>
                <td class="body textC">
                    <?php
                    if( isset($arrItemList[$currentItmCounter]->BaseType) && $arrItemList[$currentItmCounter]->BaseType == 6 ) {
                        //  For Special Items
                        ?>
                        <a href="javascript:void(0);" class="tipS" original-title="Update" title="SELECTION LIST" onclick="loadBaseSpecialItmDetailsList(<?=$arrItemList[$currentItmCounter]->PK_BaseId;    ?>, true)"  >
                            <img src="<?php echo asset_url() ?>dist/images/icons/dark/files.png" alt="">
                        </a>
                        <a href="javascript:void(0);" class="tipS" original-title="Update" title="SELECTION ADD/EDIT" onclick="loadBaseSpecialForm(<?=$arrItemList[$currentItmCounter]->PK_BaseId;    ?>, true)"  >
                            <img src="<?php echo asset_url() ?>dist/images/icons/dark/settings.png" alt="">
                        </a>
                        <?php
                    }
                    else {
                        //  For Other Items
                        ?>
                        <a href="javascript:void(0);" class="tipS" original-title="Update" title="TOPPING LIST" onclick="loadBaseToppingList(<?=$arrItemList[$currentItmCounter]->PK_BaseId;    ?>, true)"  >
                            <img src="<?php echo asset_url() ?>dist/images/icons/dark/files.png" alt="">
                        </a>
                        <a href="javascript:void(0);" class="tipS" original-title="Update" title="TOPPING ADD/EDIT" onclick="loadToppingBaseForm(<?=$arrItemList[$currentItmCounter]->PK_BaseId;    ?>)"  >
                            <img src="<?php echo asset_url() ?>dist/images/icons/dark/settings.png" alt="">
                        </a>
                        <br>

                        <a href="javascript:void(0);" class="tipS" original-title="Update" title="SELECTION LIST" onclick="loadBaseSelectionList(<?=$arrItemList[$currentItmCounter]->PK_BaseId;    ?>, true)"  >
                            <img src="<?php echo asset_url() ?>dist/images/icons/dark/files.png" alt="">
                        </a>
                        <a href="javascript:void(0);" class="tipS" original-title="Update" title="SELECTION ADD/EDIT" onclick="loadBaseSelectionForm(<?=$arrItemList[$currentItmCounter]->PK_BaseId;    ?>)"  >
                            <img src="<?php echo asset_url() ?>dist/images/icons/dark/settings.png" alt="">
                        </a>
                        <?php
                    }
                    ?>
                </td>
            </tr>



            <?php
            if( isset($arrItemList[$currentItmCounter]->BaseType) && $arrItemList[$currentItmCounter]->BaseType == 6 ) {
                //  For Special Items
                ?>
                <tr id="TrSpacialItmCustomize_<?= $arrItemList[$currentItmCounter]->PK_BaseId; ?>" name="TrItmCustomize_<?= $arrItemList[$currentItmCounter]->PK_BaseId; ?>" style="display: none">
                    <td colspan="4">
                        <div id="SpacialItmAddEdit_<?= $arrItemList[$currentItmCounter]->PK_BaseId; ?>" name="SpacialItmAddEdit_<?= $arrItemList[$currentItmCounter]->PK_BaseId; ?>" class="form widget" style="border:1px solid #cdcdcd; min-height: 100px; display: none; margin-top: 10px" ></div>

                        <div id="SpacialItmList_<?= $arrItemList[$currentItmCounter]->PK_BaseId; ?>" name="SpacialItmList_<?= $arrItemList[$currentItmCounter]->PK_BaseId; ?>" class="form widget" style="border:1px solid #cdcdcd; min-height: 100px; display: none; margin-top: 10px" ></div>
                    </td>
                </tr>
                <?php
            }
            else {
                //  For Other Items
                ?>
                <tr id="TrItmCustomize_<?= $arrItemList[$currentItmCounter]->PK_BaseId; ?>" name="TrItmCustomize_<?= $arrItemList[$currentItmCounter]->PK_BaseId; ?>" style="display: none">
                    <td colspan="4">
                        <div id="divAddEdit_<?= $arrItemList[$currentItmCounter]->PK_BaseId; ?>" name="divAddEdit_<?= $arrItemList[$currentItmCounter]->PK_BaseId; ?>" class="form widget" style="border:1px solid #cdcdcd; min-height: 100px; display: none; margin-top: 10px" ></div>

                        <div id="divList_<?= $arrItemList[$currentItmCounter]->PK_BaseId; ?>" name="divList_<?= $arrItemList[$currentItmCounter]->PK_BaseId; ?>" class="form widget" style="border:1px solid #cdcdcd; min-height: 100px; display: none; margin-top: 10px" ></div>
                    </td>
                </tr>
                <?php
            }

            /*
             * OLD VERSION
            if( $currentItmCounter+1 == count($arrItemList) ) {
                ?>
                        </tbody>
                        </table>
                    </div>
                </li>
                <?php
            }
            else if( isset($arrItemList[$currentItmCounter+1]) && $tmpSubCategor != $arrItemList[$currentItmCounter+1]->SubCatName){
                ?>
                        </tbody>
                        </table>
                    </div>
                </li>
                <?php
            }
            */

            //  NEW VERSION
            if( $currentItmCounter+1 == count($arrItemList) || ( isset($arrItemList[$currentItmCounter+1]) && $tmpSubCategor != $arrItemList[$currentItmCounter+1]->SubCatName )  ) {
                ?>
                        </tbody>
                        </table>
                    </div>
                </li>
                <?php
            }

            $currentItmCounter++;
        }
        ?>
        </ul>
        <?php
    }
    else { ?>
        <div class="body">No Item Found</div>
        <?php
    }
    ?>
</div>
