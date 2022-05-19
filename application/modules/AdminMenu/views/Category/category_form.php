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
$CatName = "";
$CatDiscount = "0";
$CatDesc = "";

$triggerFunc = "addCategory()";

if( isset($CategoryDetails) && is_array($CategoryDetails) ) {
    $CatName = $CategoryDetails[0]->CatName;
    $CatDiscount = $CategoryDetails[0]->CatDiscount;
    $CatDesc = $CategoryDetails[0]->CatDesc;

    $triggerFunc = "editCategory(".$CategoryDetails[0]->PK_CatId.")";
}
?>

<!--    Category Form [ Start ]  -->
<div class="formRow">
    <label>Name:</label>
    <div class="formRight"><input name="CatName" id="CatName" type="text" value="<?php echo $CatName;   ?>"></div>
    <div class="clear"></div>
</div>

<div class="formRow">
    <label>Discount:</label>
    <div class="formRight"><input name="CatDiscount" id="CatDiscount" type="text" value="<?php echo $CatDiscount;   ?>"></div>
    <div class="clear"></div>
</div>

<div class="formRow">
    <label>Description:</label>
    <div class="formRight"><textarea name="CatDesc" id="CatDesc" rows="8" cols="" name="textarea"><?php echo $CatDesc;   ?></textarea></div>
    <div class="clear"></div>
</div>

<div class="formRow">
    <div class="custom_search_input_heding">&nbsp;</div>
    <a href="javascript:void(0);" title="" class="wButton greenwB" onclick="<?php echo $triggerFunc;    ?>" ><span>Submit</span></a>
    <a href="javascript:void(0);"  title="" class="wButton redwB" onclick="hideDivById('divAjaxLoad')" ><span>CLOSE</span></a>
</div>
<!--    Category Form [ End ]  -->