<div class="title">
    <img src="<?php echo asset_url() ?>dist/images/icons/dark/list.png" alt="" class="titleIcon"><h6><?php echo $SegmentTitle;   ?></h6>
</div>

<!--    Error Message View Segment [ Start ]    -->
<div id="special_item_form_error_msg_div" name="special_item_form_error_msg_div" class="formRow" style="display: none">
    <div class="nNote nFailure hideit" style="margin: 0;">
        <p style="margin-top: 10px;">
            <strong>FAILURE: </strong>
            <span id="special_item_form_error_msg" name="special_item_form_error_msg" ></span>
        </p>
    </div>
</div>
<!--    Error Message View Segment [ End ]    -->

<!--    Success Message View Segment [ Start ]    -->
<div id="special_item_form_success_msg_div" name="special_item_form_success_msg_div" class="formRow" style="display: none">
    <div class="nNote nSuccess hideit" style="margin: 0;">
        <p style="margin-top: 10px;">
            <strong>SUCCESS: </strong>
            <span id="special_item_form_success_msg" name="special_item_form_success_msg" ></span>
        </p>
    </div>
</div>
<!--    Success Message View Segment [ End ]    -->


<?php
//printArr($BaseItemDetails);

$triggerFunc = "";

if( isset($arrItemDetails) && is_array($arrItemDetails) ) {
    //  For Item Update
    $triggerFunc = "updateBaseItem(".$arrItemDetails[0]->PK_BaseId.")";
} else {
    //  For Item Insert
    $triggerFunc = "addBaseItem()";
}
//printArr($BaseItemDetails[0]);
?>


<!--    Sub Category Form [ Start ]  -->
<fieldset>

    <div class="widget">
        <div class="custom_search_input_placement_25">
            <div class="custom_search_input_heding">&nbsp;</div>
            <div>
                <?php
                $ajaxSpinnerId = "#TrSpacialItmCustomize_".$BaseItemDetails[0]->PK_BaseId." #SpacialItmAddEdit_".$BaseItemDetails[0]->PK_BaseId."";
                ?>
                <select name="dropCategoryFrSpecialItm" id="dropCategoryFrSpecialItm" class="selectClass"
                        onchange="loadSubCategoryOfCategory(this.value, 'divSubCategoryFrSpecialItm', 'dropSubCategoryFrSpecialItm', false, '<?= $ajaxSpinnerId; ?>', '#ajaxSpinnerFrSpecialItm')" >
                    <option value="" >Select Category</option>
                </select>
            </div>
        </div>

        <div class="custom_search_input_placement_25" name="divSubCategoryFrSpecialItm" id="divSubCategoryFrSpecialItm" style="display: none">
            <div class="custom_search_input_heding">&nbsp;</div>
            <div>
                <select name="dropSubCategoryFrSpecialItm" id="dropSubCategoryFrSpecialItm" class="selectClass" >
                    <option value="" >Select Sub Category</option>
                </select>
            </div>
        </div>

        <div class="custom_search_input_placement_25">
            <div class="custom_search_input_heding">&nbsp;</div>
            <div class="custom_search_input_placement_25" name="ajaxSpinnerFrSpecialItm" id="ajaxSpinnerFrSpecialItm" style="padding: 0px;" ></div>
        </div>

        <div class="custom_search_input_placement_25">
            <div class="custom_search_input_heding">&nbsp;</div>
            <a href="javascript:void(0);" title="" class="wButton greenwB" style="color: white; height: 24px; line-height: 24px; float: left; margin-left: 15px;" onclick="loadViewItemFrSpacialItemDiv(false, false, <?= $BaseItemDetails[0]->PK_BaseId; ?>)" >
                <span>View Item</span>
            </a>
            <!--
            <a href="javascript:void(0);" title="" class="wButton greenwB" style="color: white; height: 24px; line-height: 24px; float: left; margin-left: 15px;" onclick="loadAddItemDiv()" >
                <span>Add Item</span>
            </a>
            -->
        </div>

    </div>


    <span id="spanAddEditSpacialItemDetail" name="spanAddEditSpacialItemDetail" style="border:1px solid #cdcdcd; min-height: 100px; display: none; margin-top: 10px"></span>

    <span id="spanListSpacialItemDetail" name="spanListSpacialItemDetail" style="border:1px solid #cdcdcd; min-height: 100px; display: none; margin-top: 10px"></span>
</fieldset>
<!--    Sub Category Form [ End ]  -->