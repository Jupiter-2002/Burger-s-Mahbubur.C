<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$Name = "";
$Email = "";
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
                <div class="formRow">
                    <label>Name:</label>
                    <div class="formRight"><input name="Name" id="Name" type="text" value="<?php echo $Name;   ?>" ></div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneThree">
                <div class="formRow">
                    <label>Email:</label>
                    <div class="formRight"><input name="Email" id="Email" type="text" value="<?php echo $Email;   ?>" ></div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneThree">
                <div class="formRow">
                    <label>Admin Type</label>
                    <div class="formRight">
                        <select name="UserType" id="UserType" class="selectClass" >
                            <option value="1" >Admin</option>
                        </select>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>

        <div class="widget">
            <div class="oneThree">
                <div class="formRow">
                    <label>Password:</label>
                    <div class="formRight"><input name="Password" id="Password" type="password" value="" ></div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneThree">
                <div class="formRow">
                    <label>Re-Password:</label>
                    <div class="formRight"><input name="Re_Password" id="Re_Password" type="password" value="" ></div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneThree">
                <div class="formRow">
                    <a href="javascript:void(0);" title="" class="wButton greenwB" name="submitBtn" id="submitBtn" onclick="addUser()" ><span>Submit</span></a>
                </div>
            </div>
        </div>
    </fieldset>
    <!--    Sub Category Form [ End ]  -->
</div>

<div class="custom_search_input_placement formRow widget" style="border:1px solid #cdcdcd;">
    <div class="custom_search_input_placement_100" name="divList" id="divList"></div>
</div>

<script type="text/javascript" src="<?php echo asset_url();?>js/AdminModules/user.js"></script>
<script type="text/javascript">
    $(window).on('load', function() {
        addCustomeClassValidator()
        loadUserList();
    });
</script>