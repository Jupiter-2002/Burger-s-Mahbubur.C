<div class="title">
    <img src="<?php echo asset_url() ?>dist/images/icons/dark/list.png" alt="" class="titleIcon"><h6><?php echo $SegmentTitle;   ?></h6>
</div>

<!--    Error Message View Segment [ Start ]    -->
<div id="itm_form_error_msg_div" name="itm_form_error_msg_div" class="formRow" style="display: none">
    <div class="nNote nFailure hideit" style="margin: 0;">
        <p style="margin-top: 10px;">
            <strong>FAILURE: </strong>
            <span id="itm_form_error_msg" name="itm_form_error_msg" ></span>
        </p>
    </div>
</div>
<!--    Error Message View Segment [ End ]    -->

<!--    Success Message View Segment [ Start ]    -->
<div id="itm_form_success_msg_div" name="itm_form_success_msg_div" class="formRow" style="display: none">
    <div class="nNote nSuccess hideit" style="margin: 0;">
        <p style="margin-top: 10px;">
            <strong>SUCCESS: </strong>
            <span id="itm_form_success_msg" name="itm_form_success_msg" ></span>
        </p>
    </div>
</div>
<!--    Success Message View Segment [ End ]    -->


<?php
$FK_CatId = "";
$FK_SubCatId = "0";
$BaseName = "";
$BaseType = "";
$BaseNo = "";
$BasePrice = "";
$BaseDesc = "";
$BaseImage = "";
$BaseHotLevel = "";
$BaseDiscount = "";

$triggerFunc = "";

if( isset($arrItemDetails) && is_array($arrItemDetails) ) {
    //  For Item Update
    $BaseName = $arrItemDetails[0]->BaseName;
    $BaseType = $arrItemDetails[0]->BaseType;
    $BaseNo = $arrItemDetails[0]->BaseNo;
    $BasePrice = number_format($arrItemDetails[0]->BasePrice, 2);
    $BaseDesc = $arrItemDetails[0]->BaseDesc;
    $BaseImage = $arrItemDetails[0]->BaseImage;
    $BaseHotLevel = $arrItemDetails[0]->BaseHotLevel;
    $BaseDiscount = $arrItemDetails[0]->BaseDiscount;

    $triggerFunc = "updateBaseItem(".$arrItemDetails[0]->PK_BaseId.")";
} else {
    //  For Item Insert
    $triggerFunc = "addBaseItem()";
}
//printArr($arrItemDetails);
?>


<!--    Sub Category Form [ Start ]  -->
<fieldset>
    <div class="widget">
        <div class="oneTwo">
            <?php
            if( isset($arrCategoryList) && is_array($arrCategoryList) ) {
                ?>
                <div class="formRow">
                    <label>Category:</label>
                    <div class="formRight">
                        <?php
                        if( isset($arrCategoryList) && count($arrCategoryList) > 0 ) {
                            ?>
                            <select name="FK_CatId" id="FK_CatId" class="selectClass" onchange="loadSubCategoryOfCategory(this.value, 'div_FK_SubCatId', 'FK_SubCatId', false)"  >
                                <option value="" >Select Category</option>
                                <?php
                                foreach ( $arrCategoryList as $objCategory ) {
                                    ?>
                                    <option value="<?php echo $objCategory->PK_CatId; ?>" <?php if(isset($InitCategorId) && $objCategory->PK_CatId==$InitCategorId) { ?> selected="selected"<?php } ?> ><?php echo $objCategory->CatName; ?></option>
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
            }
            ?>
        </div>

        <div class="oneTwo">
            <div class="formRow" name="div_FK_SubCatId" id="div_FK_SubCatId" style="display: none">
                <label>Sub Category:</label>
                <div class="formRight">
                    <select name="FK_SubCatId" id="FK_SubCatId" class="selectClass" >
                        <option value="" >Select Sub Category</option>
                    </select>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>

    <div class="widget">
        <div class="oneThree">
            <div class="formRow">
                <label>Name:</label>
                <div class="formRight"><input name="BaseName" id="BaseName" type="text" value="<?php echo $BaseName;   ?>"></div>
                <div class="clear"></div>
            </div>
        </div>

        <div class="oneThree">
            <div class="formRow">
                <label>Price:</label>
                <div class="formRight"><input name="BasePrice" id="BasePrice" type="text" value="<?php echo $BasePrice;   ?>" class="onlyNumberClass"></div>
                <div class="clear"></div>
            </div>
        </div>

        <div class="oneThree">
            <div class="formRow">
                <label>Discount:</label>
                <div class="formRight"><input name="BaseDiscount" id="BaseDiscount" type="text" value="<?php echo $BaseDiscount;   ?>" class="onlyNumberClass"></div>
                <div class="clear"></div>
            </div>
        </div>
    </div>

    <div class="widget">
        <div class="oneThree">
            <div class="formRow">
                <label>Item No.:</label>
                <div class="formRight"><input name="BaseNo" id="BaseNo" type="text" value="<?php echo $BaseNo;   ?>"></div>
                <div class="clear"></div>
            </div>
        </div>

        <div class="oneThree">
            <div class="formRow">
                <label>Type:</label>
                <div class="formRight">
                    <select name="BaseType" id="BaseType" class="selectClass" >
                        <option value="" >Select Base Type</option>
                        <?php
                        foreach ( $BaseTypeArr as $objBaseTypeKey => $objBaseTypeVal ) {
                            ?>
                            <option value="<?php echo $objBaseTypeKey; ?>" <?php if( $objBaseTypeKey == $BaseType ) { ?> selected="selected"<?php } ?> ><?php echo $objBaseTypeVal; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="clear"></div>
            </div>
        </div>

        <div class="oneThree">
            <div class="formRow">
                <label>Hot Level:</label>
                <div class="formRight">
                    <select name="BaseHotLevel" id="BaseHotLevel" class="selectClass" >
                        <option value="0" >Select Hot Level</option>
                        <?php
                        foreach ( $BaseHotLevelArr as $objBaseHotLevelKey => $objBaseHotLevelVal ) {
                            ?>
                            <option value="<?php echo $objBaseHotLevelKey; ?>" <?php if( $objBaseHotLevelKey == $BaseHotLevel ) { ?> selected="selected"<?php } ?> ><?php echo $objBaseHotLevelVal; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>

    <div class="widget">
        <div class="oneTwo">
            <div class="formRow">
                <label>Description:</label>
                <div class="formRight"><textarea name="BaseDesc" id="BaseDesc" rows="8" cols="" name="textarea"><?php echo $BaseDesc;   ?></textarea></div>
                <div class="clear"></div>
            </div>
        </div>

        <div class="oneTwo">
            <div class="formRow">
                <a href="javascript:void(0);" title="" class="wButton greenwB" onclick="<?php echo $triggerFunc;    ?>" ><span>Submit</span></a>
                <a href="javascript:void(0);"  title="" class="wButton redwB" onclick="hideDivById('divAjaxAddItmLoad')" ><span>CLOSE</span></a>
            </div>
        </div>
    </div>
</fieldset>
<!--    Sub Category Form [ End ]  -->



<script type="text/javascript">
    <?php
    if( isset($InitCategorId) && $InitCategorId != "" ) {
        if( isset($InitSubCategorId) && $InitSubCategorId != "" ) { ?>
            loadSubCategoryOfCategory(<?php echo $InitCategorId; ?>, 'div_FK_SubCatId', 'FK_SubCatId', <?php echo $InitSubCategorId;    ?>);
            <?php
        }
        else { ?>
            loadSubCategoryOfCategory(<?php echo $InitCategorId; ?>, 'div_FK_SubCatId', 'FK_SubCatId', false);
            <?php
        }
    }
    ?>

    //  This is to add different Validations based on HTML Class [assets/js/utility.js]
    addCustomeClassValidator();
</script>