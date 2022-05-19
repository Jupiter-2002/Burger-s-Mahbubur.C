<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$DeliveryAreaTitle = "";
$DeliveryCharge = "";
$MinDeliveryAmount = "";
$HalfPostCode = "";
$PostCodeList = "";
$DeliveryTime = "";
$FreeDeliveryFlag = "";
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
                <div class="formRow">
                    <label>Address/Title:</label>
                    <div class="formRight">
                        <input name="DeliveryAreaTitle" id="DeliveryAreaTitle" type="text" value="<?php echo $DeliveryAreaTitle;   ?>" >
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneThree">
                <div class="formRow">
                    <label>Delivery Charge:</label>
                    <div class="formRight">
                        <input name="DeliveryCharge" id="DeliveryCharge" type="text" value="<?php echo $DeliveryCharge;   ?>" class="onlyNumberClass">
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneThree">
                <div class="formRow">
                    <label>Min. Amount:</label>
                    <div class="formRight">
                        <input name="MinDeliveryAmount" id="MinDeliveryAmount" type="text" value="<?php echo $MinDeliveryAmount;   ?>" class="onlyNumberClass">
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>

        <div class="widget">
            <div class="oneTwo">
                <div class="formRow">
                    <label>Half Post Code:</label>
                    <div class="formRight">
                        <input name="HalfPostCode" id="HalfPostCode" type="text" value="<?php echo $HalfPostCode;   ?>" style="text-transform: uppercase" >
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneTwo">
                <div class="formRow">
                    <label>OR Post Code List:</label>
                    <div class="formRight"><textarea name="PostCodeList" id="PostCodeList" rows="8" cols="" name="textarea" style="text-transform: uppercase"><?php echo $PostCodeList;   ?></textarea></div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>

        <div class="widget">
            <div class="oneTwo">
                <div class="formRow">
                    <label>Time [In Min.]:</label>
                    <div class="formRight"><input name="DeliveryTime" id="DeliveryTime" type="text" value="<?php echo $DeliveryTime;   ?>" class="onlyNumberClass"></div>
                    <div class="clear"></div>
                </div>
            </div>


            <div class="oneFour">
                <div class="formRow">
                    <label>Free Delivery:</label>
                    <div class="formRight" style="width: 55%">
                        <input type="checkbox" name="FreeDeliveryFlag" id="FreeDeliveryFlag" style="opacity: 0;">
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneFour">
                <div class="formRow">
                    <a href="javascript:void(0);" title="" class="wButton greenwB" name="submitBtn" id="submitBtn" onclick="addDelivery()" ><span>Submit</span></a>
                    <a href="javascript:void(0);"  title="" class="wButton redwB" onclick="clear_delievery_elements('divAjaxLoad')" ><span>CLOSE</span></a>
                </div>
            </div>
        </div>
    </fieldset>
    <!--    Sub Category Form [ End ]  -->
</div>



































<div class="custom_search_input_placement formRow widget" style="border:1px solid #cdcdcd;">
    <div class="custom_search_input_placement_100" name="divDeliveryList" id="divDeliveryList"></div>
</div>

<script type="text/javascript" src="<?php echo asset_url();?>js/AdminModules/delivery.js"></script>
<script type="text/javascript">
    $(window).on('load', function() {
        addCustomeClassValidator()
        loadDeliveryList();
    });
</script>