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
$SubCatName = "";
$SubCatDiscount = "0";
$SubCatDesc = "";
$SubCatFKCatId = "";

if( isset($SubCategoryDetails) && is_array($SubCategoryDetails) ) {
    //  For Sub Category Update
    $SubCatName = $SubCategoryDetails[0]->SubCatName;
    $SubCatDiscount = $SubCategoryDetails[0]->SubCatDiscount;
    $SubCatDesc = $SubCategoryDetails[0]->SubCatDesc;
    $SubCatFKCatId = $SubCategoryDetails[0]->FK_CatId;

    $triggerFunc = "editSubCategory(".$SubCategoryDetails[0]->PK_SubCatId.")";
} else {
    //  For Sub Category Insert
    $triggerFunc = "addSubCategory(".$arrCategoryDetails[0]->PK_CatId.")";
}
?>


<!--    Sub Category Form [ Start ]  -->
<fieldset>
<div class="widget">
    <?php
    if( isset($CategoryList) && is_array($CategoryList) ) {
        ?>
        <div class="formRow">
            <label>Category:</label>
            <div class="formRight">
                <?php
                if( isset($CategoryList) && count($CategoryList) > 0 ) {
                    ?>
                    <select name="FK_CatId" id="FK_CatId" class="selectClass" >
                        <?php
                        foreach ( $CategoryList as $objCategory ) {
                            ?>
                            <option value="<?php echo $objCategory->PK_CatId; ?>" <?php if($objCategory->PK_CatId==$SubCatFKCatId) { ?> selected="selected"<?php } ?> ><?php echo $objCategory->CatName; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <?php
                }
                ?>
            </div>
            <div class="clear"></div>
        </div>
        <?php
    } else {
        ?>
        <div class="formRow">
            <label>Category Name:</label>
            <div class="formRight"><h6 style="padding-top: 4px;"><?php echo $arrCategoryDetails[0]->CatName; ?></h6></div>
            <div class="clear"></div>
        </div>
        <?php
    }
    ?>

    <div class="formRow">
        <label>Name:</label>
        <div class="formRight"><input name="SubCatName" id="SubCatName" type="text" value="<?php echo $SubCatName;   ?>"></div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <label>Discount:</label>
        <div class="formRight"><input name="SubCatDiscount" id="SubCatDiscount" type="text" value="<?php echo $SubCatDiscount;   ?>"></div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <label>Description:</label>
        <div class="formRight"><textarea name="SubCatDesc" id="SubCatDesc" rows="8" cols="" name="textarea"><?php echo $SubCatDesc;   ?></textarea></div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="custom_search_input_heding">&nbsp;</div>
        <a href="javascript:void(0);" title="" class="wButton greenwB" onclick="<?php echo $triggerFunc;    ?>" ><span>Submit</span></a>
        <a href="javascript:void(0);"  title="" class="wButton redwB" onclick="hideDivById('divAjaxLoad')" ><span>CLOSE</span></a>
    </div>
</div>
</fieldset>
<!--    Sub Category Form [ End ]  -->