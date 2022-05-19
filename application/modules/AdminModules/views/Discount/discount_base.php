<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$FK_CatId = "";
$FK_SubCatId = "0";

$OrderTypeId = "";
$DiscountType = "";
$DiscountAmount = "";
$StartAmount = "";
$EndAmount = "";
$StartDate = "";
$EndDate = "";
$Description = "";
$Status = "";
?>

<div name="divAjaxLoaderIcon" id="divAjaxLoaderIcon" class="form widget" style="border:1px solid #cdcdcd; min-height: 50px; display: block; margin-top: 10px; display: none;" >
</div>

<div name="divAjaxLoad" id="divAjaxLoad" class="form widget" style="border:1px solid #cdcdcd; min-height: 100px; display: block; margin-top: 10px" >
    <div class="title">
        <img src="<?php echo asset_url() ?>dist/images/icons/dark/list.png" alt="" class="titleIcon">
        <h6 name="SegmentTitle" id="SegmentTitle"><?php echo $SegmentTitle;   ?></h6>
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


    <!--    Sub Category Form [ Start ]  -->
    <fieldset>
        <div class="widget">
            <div class="oneThree">
                <?php
                if( isset($OrderTypeArr) && is_array($OrderTypeArr) ) {
                    ?>
                    <div class="formRow">
                        <label>Order Type:</label>
                        <div class="formRight">
                            <?php
                            if( isset($OrderTypeArr) && count($OrderTypeArr) > 0 ) {
                                ?>
                                <select name="OrderTypeId" id="OrderTypeId" class="selectClass" >
                                    <option value="" >Select Order Type</option>
                                    <?php
                                    foreach ( $OrderTypeArr as $objOrderTypId=>$objOrderTypValue ) {
                                        ?>
                                        <option value="<?php echo $objOrderTypId; ?>"
                                            <?php if(isset($InitCategorId) && $objCategory->PK_CatId==$InitCategorId) { ?> selected="selected"<?php } ?> >
                                            <?php echo $objOrderTypValue; ?>
                                        </option>
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

            <div class="oneThree">
                <?php
                if( isset($DiscountTypeArr) && is_array($DiscountTypeArr) ) {
                    ?>
                    <div class="formRow">
                        <label>Discount Type:</label>
                        <div class="formRight">
                            <?php
                            if( isset($DiscountTypeArr) && count($DiscountTypeArr) > 0 ) {
                                ?>
                                <select name="DiscountType" id="DiscountType" class="selectClass" >
                                    <option value="" >Select Discount Type</option>
                                    <?php
                                    foreach ( $DiscountTypeArr as $objDiscountTypId=>$objDiscountTypValue ) {
                                        ?>
                                        <option value="<?php echo $objDiscountTypId; ?>"
                                            <?php if(isset($InitCategorId) && $objCategory->PK_CatId==$InitCategorId) { ?> selected="selected"<?php } ?> >
                                            <?php echo $objDiscountTypValue; ?>
                                        </option>
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

            <div class="oneThree">
                <div class="formRow">
                    <label>Discount Amount:</label>
                    <div class="formRight"><input name="DiscountAmount" id="DiscountAmount" type="text" value="<?php echo $DiscountAmount;   ?>" class="onlyNumberClass"></div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>

        <div class="widget">
            <div class="oneFour">
                <div class="formRow">
                    <label>Minimum:</label>
                    <div class="formRight"><input name="StartAmount" id="StartAmount" type="text" value="<?php echo $StartAmount;   ?>" class="onlyNumberClass"></div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneFour">
                <div class="formRow">
                    <label>Maximum:</label>
                    <div class="formRight"><input name="EndAmount" id="EndAmount" type="text" value="<?php echo $EndAmount;   ?>" class="onlyNumberClass"></div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneFour">
                <div class="formRow">
                    <label>Start Date:</label>
                    <div class="formRight"><input name="StartDate" id="StartDate" type="text" class="datepicker" value="<?php echo $StartDate;   ?>"></div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneFour">
                <div class="formRow">
                    <label>End Date:</label>
                    <div class="formRight"><input name="EndDate" id="EndDate" type="text" class="datepicker" value="<?php echo $EndDate;   ?>"></div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>

        <div class="widget">
            <div class="oneTwo">
                <div class="formRow">
                    <label>Description:</label>
                    <div class="formRight"><textarea name="Description" id="Description" rows="8" cols="" name="textarea"><?php echo $Description;   ?></textarea></div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneTwo">
                <div class="formRow">
                    <a href="javascript:void(0);" title="" class="wButton greenwB" name="submitBtn" id="submitBtn" onclick="addDiscount()" ><span>Submit</span></a>
                    <a href="javascript:void(0);"  title="" class="wButton redwB" onclick="clear_discount_elements('divAjaxLoad')" ><span>CLOSE</span></a>
                </div>
            </div>
        </div>
    </fieldset>
    <!--    Sub Category Form [ End ]  -->
</div>

<div class="custom_search_input_placement formRow widget" style="border:1px solid #cdcdcd;">
    <div class="custom_search_input_placement_100" name="divDiscountList" id="divDiscountList"></div>
</div>

<script type="text/javascript" src="<?php echo asset_url();?>js/AdminModules/discount.js"></script>
<script type="text/javascript">
    $(window).on('load', function() {
        addCustomeClassValidator()
        loadDiscountList();
    });
</script>