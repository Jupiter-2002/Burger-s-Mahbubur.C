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
                    <label>Name:</label>
                    <div class="formRight">
                        <input name="RestName" id="RestName" type="text" value="<?= ($dataArr[0]->RestName) ? $dataArr[0]->RestName: "";   ?>" >
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneFour">
                <div class="formRow">
                    <label>Type:</label>
                    <div class="formRight">
                        <select name="RestTypev" id="RestType" class="selectClass" >
                            <?php
                            foreach ( get_global_values('RestaurantType') as $key=>$value ) {
                                ?>
                                <option value="<?php echo $key; ?>"
                                    <?php if( isset($dataArr[0]->RestType) && $dataArr[0]->RestType == $key ) { ?> selected="selected"<?php } ?> >
                                    <?php echo $value; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneFour">
                <div class="formRow">
                    <label>URL:</label>
                    <div class="formRight">
                        <input name="RestWebUrl" id="RestWebUrl" type="text" value="<?= ($dataArr[0]->RestWebUrl) ? $dataArr[0]->RestWebUrl: "";   ?>" >
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneFour">
                <div class="formRow">
                    <label>Key:</label>
                    <div class="formRight">
                        <input name="RestUniqueKey" id="RestUniqueKey" type="text" value="<?= ($dataArr[0]->RestUniqueKey) ? $dataArr[0]->RestUniqueKey: "";   ?>" >
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>

        <div class="widget">
            <div class="oneFour">
                <div class="formRow">
                    <label>Address:</label>
                    <div class="formRight">
                        <input name="RestAddress1" id="RestAddress1" type="text" value="<?= ($dataArr[0]->RestAddress1) ? $dataArr[0]->RestAddress1: "";   ?>" >
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneFour">
                <div class="formRow">
                    <label>Town:</label>
                    <div class="formRight">
                        <input name="RestTown" id="RestTown" type="text" value="<?= ($dataArr[0]->RestTown) ? $dataArr[0]->RestTown: "";   ?>" >
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneFour">
                <div class="formRow">
                    <label>City:</label>
                    <div class="formRight">
                        <input name="RestCity" id="RestCity" type="text" value="<?= ($dataArr[0]->RestCity) ? $dataArr[0]->RestCity: "";   ?>" >
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneFour">
                <div class="formRow">
                    <label>Post Code:</label>
                    <div class="formRight">
                        <input name="RestPostCode" id="RestPostCode" type="text" value="<?= ($dataArr[0]->RestPostCode) ? $dataArr[0]->RestPostCode: "";   ?>" maxlength="10" >
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
                        <input name="RestEMail" id="RestEMail" type="text" value="<?= ($dataArr[0]->RestEMail) ? $dataArr[0]->RestEMail: "";   ?>" >
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneFour">
                <div class="formRow">
                    <label>Phone:</label>
                    <div class="formRight">
                        <input name="RestPhone" id="RestPhone" type="text" value="<?= ($dataArr[0]->RestPhone) ? $dataArr[0]->RestPhone: "";   ?>" >
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneFour">
                <div class="formRow">
                    <label>Mobile:</label>
                    <div class="formRight">
                        <input name="RestMobile" id="RestMobile" type="text" value="<?= ($dataArr[0]->RestMobile) ? $dataArr[0]->RestMobile: "";   ?>" >
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneFour">
                <div class="formRow">
                    <label>Logo:</label>
                    <div class="formRight">
                        <input type="file" id="file" name="file" />
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>

        <div class="widget">
            <div class="oneFour">
                <div class="formRow">
                    <label>Halal:</label>
                    <div class="formRight">
                        <select name="IsHalal" id="IsHalal" class="selectClass" >
                            <?php
                            foreach ( get_global_values('BooleanArr') as $key=>$value ) {
                                ?>
                                <option value="<?php echo $key; ?>"
                                    <?php if( isset($dataArr[0]->IsHalal) && $dataArr[0]->IsHalal == $key ) { ?> selected="selected"<?php } ?> >
                                    <?php echo $value; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneFour">
                <div class="formRow">
                    <label>Star:</label>
                    <div class="formRight">
                        <select name="RestStarRating" id="RestStarRating" class="selectClass" >
                            <?php
                            foreach ( get_global_values('StarRatingArr') as $key=>$value ) {
                                ?>
                                <option value="<?php echo $key; ?>"
                                    <?php if( isset($dataArr[0]->RestStarRating) && $dataArr[0]->RestStarRating == $key ) { ?> selected="selected"<?php } ?> >
                                    <?php echo $value; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneFour">
                <div class="formRow">
                    <label>Hygenic:</label>
                    <div class="formRight">
                        <select name="RestHygenicRating" id="RestHygenicRating" class="selectClass" >
                            <?php
                            foreach ( get_global_values('HygenicReportArr') as $key=>$value ) {
                                ?>
                                <option value="<?php echo $key; ?>"
                                    <?php if( isset($dataArr[0]->RestHygenicRating) && $dataArr[0]->RestHygenicRating == $key ) { ?> selected="selected"<?php } ?> >
                                    <?php echo $value; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneFour">
                <div class="formRow">
                    <label>&nbsp;</label>
                    <div class="formRight">
                        &nbsp;
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>

        <div class="widget">
            <div class="oneThree">
                <div class="formRow">
                    <label>Description:</label>
                    <div class="formRight"><textarea name="RestDescription" id="RestDescription" rows="8" cols="" name="textarea"><?= ($dataArr[0]->RestDescription) ? $dataArr[0]->RestDescription: "";   ?></textarea></div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneThree">
                <div class="formRow">
                    <label>Meta Data:</label>
                    <div class="formRight"><textarea name="RestMetaData" id="RestMetaData" rows="8" cols="" name="textarea"><?= ($dataArr[0]->RestMetaData) ? $dataArr[0]->RestMetaData: "";   ?></textarea></div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="oneThree">
                <div class="formRow">
                    <a href="javascript:void(0);" title="" class="wButton greenwB" name="submitBtn" id="submitBtn" onclick="updateRestaurantDetails()" ><span>Update</span></a>
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