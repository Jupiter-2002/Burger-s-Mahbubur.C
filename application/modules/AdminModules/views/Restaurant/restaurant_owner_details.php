<?php
defined('BASEPATH') OR exit('No direct script access allowed');
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
            <div class="oneFour">
                <div class="formRow">
                    <label>First Name:</label>
                    <div class="formRight">
                        <input name="OwnerFirstName" id="OwnerFirstName" type="text" value="<?= ($dataArr[0]->OwnerFirstName) ? $dataArr[0]->OwnerFirstName: "";   ?>" >
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneFour">
                <div class="formRow">
                    <label>Last Name:</label>
                    <div class="formRight">
                        <input name="OwnerLastName" id="OwnerLastName" type="text" value="<?= ($dataArr[0]->OwnerLastName) ? $dataArr[0]->OwnerLastName: "";   ?>" >
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneFour">
                <div class="formRow">
                    <label>&nbsp;</label>
                    <div class="formRight">&nbsp;</div>
                    <!--
                    <label>User Name:</label>
                    <div class="formRight">
                        <input name="OwnerUserName" id="OwnerUserName" type="text" value="<?= ($dataArr[0]->OwnerUserName) ? $dataArr[0]->OwnerUserName: "";   ?>" >
                    </div>
                    -->
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneFour">
                <div class="formRow">
                    <label>&nbsp;</label>
                    <div class="formRight">&nbsp;</div>
                    <!--
                    <label>Password:</label>
                    <div class="formRight">
                        <input name="OwnerUserPass" id="OwnerUserPass" type="text" value="<?= ($dataArr[0]->OwnerUserPass) ? $dataArr[0]->OwnerUserPass: "";   ?>" >
                    </div>
                    -->
                    <div class="clear"></div>
                </div>
            </div>
        </div>

        <div class="widget">
            <div class="oneFour">
                <div class="formRow">
                    <label>Address:</label>
                    <div class="formRight">
                        <input name="OwnerAddress" id="OwnerAddress" type="text" value="<?= ($dataArr[0]->OwnerAddress) ? $dataArr[0]->OwnerAddress: "";   ?>" >
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneFour">
                <div class="formRow">
                    <label>Street:</label>
                    <div class="formRight">
                        <input name="OwnerStreet" id="OwnerStreet" type="text" value="<?= ($dataArr[0]->OwnerStreet) ? $dataArr[0]->OwnerStreet: "";   ?>" >
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneFour">
                <div class="formRow">
                    <label>City:</label>
                    <div class="formRight">
                        <input name="OwnerCity" id="OwnerCity" type="text" value="<?= ($dataArr[0]->OwnerCity) ? $dataArr[0]->OwnerCity: "";   ?>" >
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneFour">
                <div class="formRow">
                    <label>Post Code:</label>
                    <div class="formRight">
                        <input name="OwnerPostCode" id="OwnerPostCode" type="text" value="<?= ($dataArr[0]->OwnerPostCode) ? $dataArr[0]->OwnerPostCode : "";   ?>" maxlength="10" >
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>

        <div class="widget">
            <div class="oneFour">
                <div class="formRow">
                    <label>E-Mail:</label>
                    <div class="formRight">
                        <input name="OwnerEMail" id="OwnerEMail" type="text" value="<?= ($dataArr[0]->OwnerEMail) ? $dataArr[0]->OwnerEMail: "";   ?>" >
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneFour">
                <div class="formRow">
                    <label>Phone:</label>
                    <div class="formRight">
                        <input name="OwnerPhone" id="OwnerPhone" type="text" value="<?= ($dataArr[0]->OwnerPhone) ? $dataArr[0]->OwnerPhone: "";   ?>" >
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneFour">
                <div class="formRow">
                    <label>Mobile:</label>
                    <div class="formRight">
                        <input name="OwnerMobile" id="OwnerMobile" type="text" value="<?= ($dataArr[0]->OwnerMobile) ? $dataArr[0]->OwnerMobile: "";   ?>" >
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneFour">
                <div class="formRow">
                    <a href="javascript:void(0);" title="" class="wButton greenwB" name="submitBtn" id="submitBtn" onclick="updateRestaurantOwnerDetails()" ><span>Update</span></a>
                </div>
            </div>
        </div>
    </fieldset>
    <!--    Sub Category Form [ End ]  -->
</div>

<script type="text/javascript" src="<?php echo asset_url();?>js/AdminModules/restaurant.js"></script>
<script type="text/javascript">
    $(window).on('load', function() {
        addCustomeClassValidator();
    });
</script>