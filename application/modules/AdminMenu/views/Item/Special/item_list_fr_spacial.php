<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//printArr($arrItemList);
?>
<div class="widget" style="margin: 10px;">

    <div class="title">
        <img src="<?php echo asset_url();?>dist/images/icons/dark/frames.png" alt="" class="titleIcon" />
        <h6>Item List of <b class="blue">
                <?= strtoupper($arrCategoryDetails[0]->CatName);   ?>
                <?= (isset($arrSubCategoryDetails[0]->SubCatName) && $arrSubCategoryDetails[0]->SubCatName != "") ? " => ".strtoupper($arrSubCategoryDetails[0]->SubCatName) : "";  ?>
                [ Special Item ]</b></h6>
    </div>

    <?php
    if( isset($arrItemList) && is_array($arrItemList) ) {
        ?>
        <!--  Category and Sub Category Based Item Population with Selection if exists [ Start ]    -->
        <ul class="partners">
        <?php
        $tmpSubCategor = "";

        $currentItmCounter = 0;

        for( $currentItmCounter = 0; $currentItmCounter < count($arrItemList);  ) {

            if( $tmpSubCategor != $arrItemList[$currentItmCounter]->SubCatName || ( $currentItmCounter == 0 && $arrItemList[$currentItmCounter]->SubCatName == "" ) )
            {
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
                            <!--
                            <thead>
                            <tr>
                                <td width="60%">Name</td>
                            </tr>
                            </thead>
                            -->
                            <tbody>
                <?php
            }
            ?>

            <!--    Item Details [ Start ]  -->
            <tr>
                <td style="vertical-align: top; padding-top: 14.5px; text-align: left">
                    <div style="padding: 7px 6px; width: 70%; float: left;">
                        <input type="checkbox"
                               id="flagAddToSpacial_Itm[]"
                               name="flagAddToSpacial_Itm[]"
                               value="<?php echo $arrItemList[$currentItmCounter]->PK_BaseId;	?>"
                        <?= isset($arrItemList[$currentItmCounter]->ItemSelectionList) ? 'checked':'';?> >
                        &nbsp;Is Available

                        <span style="margin-left: 30px;">
                            <b>
                                <?php
                                echo "ID, ".$arrItemList[$currentItmCounter]->PK_BaseId."&nbsp";
                                if( isset($arrItemList[$currentItmCounter]->BaseNo) && $arrItemList[$currentItmCounter]->BaseNo != "" ) {
                                    echo "Base Name: ".$arrItemList[$currentItmCounter]->BaseNo;
                                }

                                echo $arrItemList[$currentItmCounter]->BaseName;    ?>
                            </b>
                        </span>
                    </div>

                    <div style="float: right; width: 25%; text-align: right;">
                        <b>Price : </b>
                        <input type="text" id="addToSpacial_Itm_Price[<?php echo $arrItemList[$currentItmCounter]->PK_BaseId;	?>]" name="addToSpacial_Itm_Price[<?php echo $arrItemList[$currentItmCounter]->PK_BaseId;	?>]"
                               value="<?php
                               if( $arrItemList[$currentItmCounter]->BasePrice > 0 ) { echo $arrItemList[$currentItmCounter]->BasePrice; }
                               else { echo 0; }
                               ?>"
                               class="onlyNumberClass" style="width: 150px;" >
                        </a>
                    </div>
                </td>
            </tr>
            <!--    Item Details [ End ]  -->

            <!--        If the ITEM has SELECTION [ START ]      -->
            <?php
            if( isset($arrItemList[$currentItmCounter]->ItemSelectionList) ) {
                $tmpData['PK_BaseId'] = $arrItemList[$currentItmCounter]->PK_BaseId;
                $tmpData['ItemSelectionList'] = $arrItemList[$currentItmCounter]->ItemSelectionList;

                echo $this->load->view('Item/Special/selection_list_form_fr_special', $tmpData, true);
            }
            ?>
            <!--        If the ITEM has SELECTION [ END ]      -->

            <?php
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
        <!--  Category and Sub Category Based Item Population with Selection if exists [ End ]  -->

        <div class="widget">
            <div class="custom_search_input_placement_25">
                <div class="custom_search_input_heding" style="margin: 9.5px;"><b>Selection Name</b></div>
                <div>
                    <input type="text" name="selectionName" id="selectionName" style="width: 250px" >
                </div>
            </div>

            <div class="custom_search_input_placement_25">
                <div class="custom_search_input_heding" style="margin: 9.5px;">&nbsp;</div>
                <a href="javascript:void(0);" title="" class="wButton greenwB" style="color: white; height: 24px; line-height: 24px; float: left; margin-left: 15px;"
                    onclick="saveBaseAndSelectionToSpecial(<?= $BaseItemDetails[0]->PK_BaseId ?>)" >
                    <span>Save</span>
                </a>
                <a href="javascript:void(0);" title="" class="wButton redwB" style="color: white; height: 24px; line-height: 24px; float: left; margin-left: 15px;" >
                    <span>Cancel</span>
                </a>
            </div>
        </div>
        <?php
    }
    else { ?>
        <div class="body">No Item Found</div>
        <?php
    }
    ?>

</div>



<script type="text/javascript">
    //  This is to add different Validations based on HTML Class [assets/js/utility.js]
    addCustomeClassValidator();
</script>
