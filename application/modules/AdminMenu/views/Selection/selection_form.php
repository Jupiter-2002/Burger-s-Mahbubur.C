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
$SelecName = "";
$SelecDefaultPrice = "";

$PK_SelecId = 0;
$FK_SelecCatId = 0;

$triggerFunc = "";

if( isset($ObjectDetails) && is_array($ObjectDetails) ) {
    $SelecName = $ObjectDetails[0]->SelecName;
    $SelecDefaultPrice = $ObjectDetails[0]->SelecDefaultPrice;

    $PK_SelecId = $ObjectDetails[0]->PK_SelecId;
    $FK_SelecCatId = $ObjectDetails[0]->FK_SelecCatId;

    $triggerFunc = "updateSelection(".$PK_SelecId.")";
}
else {
    $triggerFunc = "ajaxAddSelection(".$arrSelecCatDetails[0]->PK_SelecCatId.")";
}
?>

<!--    Selection Form [ Start ]  -->
<fieldset>
    <?php
    if( isset($CategoryList) && is_array($CategoryList) ) {
        ?>
        <div class="formRow">
            <label>Category:</label>
            <div class="formRight">
                <?php
                if( isset($CategoryList) && count($CategoryList) > 0 ) {
                    ?>
                    <select name="FK_SelecCatId" id="FK_SelecCatId" class="selectClass" >
                        <?php
                        foreach ( $CategoryList as $objCategory ) {
                            ?>
                            <option value="<?php echo $objCategory->PK_SelecCatId; ?>" <?php if($objCategory->PK_SelecCatId==$FK_SelecCatId) { ?> selected="selected"<?php } ?> ><?php echo $objCategory->SelecCatName; ?></option>
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
            <label>Category:</label>
            <div class="formRight"><h6 style="padding-top: 4px;"><?php echo $arrSelecCatDetails[0]->SelecCatName; ?></h6></div>
            <div class="clear"></div>
        </div>
        <?php
    }
    ?>

    <div class="widget">
        <div class="oneThree">
            <div class="formRow">
                <label>Name:</label>
                <div class="formRight"><input name="SelecName" id="SelecName" type="text" value="<?php echo $SelecName;   ?>"></div>
                <div class="clear"></div>
            </div>
        </div>

        <div class="oneThree">
            <div class="formRow">
                <label>Price:</label>
                <div class="formRight"><input name="SelecDefaultPrice" id="SelecDefaultPrice" type="text" value="<?php echo $SelecDefaultPrice;   ?>" class="onlyNumberClass"></div>
                <div class="clear"></div>
            </div>
        </div>

        <div class="oneThree">
            <div class="formRow">
                <a href="javascript:void(0);" title="" class="wButtonSmall greenwB" onclick="<?php echo $triggerFunc;    ?>" ><span>Submit</span></a>
                <a href="javascript:void(0);" title="" class="wButtonSmall redwB" onclick="hideDivById('divAjaxLoad')" ><span>CLOSE</span></a>
            </div>
        </div>
    </div>
</fieldset>
<!--    Selection Form [ End ]  -->


<script type="text/javascript">
    //  This is to add different Validations based on HTML Class [assets/js/utility.js]
    addCustomeClassValidator();
</script>