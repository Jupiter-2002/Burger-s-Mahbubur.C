<div class="title">
    <img src="<?php echo asset_url() ?>dist/images/icons/dark/list.png" alt="" class="titleIcon"><h6><?php echo $SegmentTitle;   ?></h6>
</div>

<!--    Error Message View Segment [ Start ]    -->
<div id="error_msg_div" name="error_msg_div" class="formRow" style="display: none">
    <div class="nNote nFailure hideit" style="margin: 0;">
        <p style="margin-top: 10px;">
            <strong>FAILURE: </strong>
            <span id="error_msg" name="error_msg" ></span>
        </p>
    </div>
</div>
<!--    Error Message View Segment [ End ]    -->

<!--    Success Message View Segment [ Start ]    -->
<div id="success_msg_div" name="success_msg_div" class="formRow" style="display: none">
    <div class="nNote nSuccess hideit" style="margin: 0;">
        <p style="margin-top: 10px;">
            <strong>SUCCESS: </strong>
            <span id="success_msg" name="success_msg" ></span>
        </p>
    </div>
</div>
<!--    Success Message View Segment [ End ]    -->


<?php
$ToppCatName = "";

$triggerFunc = "";

if( isset($ObjectDetails) && is_array($ObjectDetails) ) {
    $ToppCatName = $ObjectDetails[0]->ToppCatName;

    $triggerFunc = "ajaxUpdateToppingCategory(".$ObjectDetails[0]->PK_ToppCatId.")";
}
else {
    $triggerFunc = "ajaxAddToppingCategory()";
}
?>

<!--    Selection Category Form [ Start ]  -->
<fieldset>
    <div class="oneTwo">
        <div class="formRow">
            <label>Name:</label>
            <div class="formRight"><input name="ToppCatName" id="ToppCatName" type="text" value="<?php echo $ToppCatName;   ?>"></div>
            <div class="clear"></div>
        </div>
    </div>

    <div class="oneTwo">
        <div class="formRow">
            <a href="javascript:void(0);" title="" class="wButtonSmall greenwB" onclick="<?php echo $triggerFunc;    ?>" ><span>Submit</span></a>
            <a href="javascript:void(0);" title="" class="wButtonSmall redwB" onclick="hideDivById('divAjaxLoad')" ><span>CLOSE</span></a>
        </div>
    </div>
</fieldset>
<!--    Selection Category Form [ End ]  -->