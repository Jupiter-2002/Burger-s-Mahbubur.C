<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//printArr($PaymentTypeArr);
?>
<div class="form widget" style="border:1px solid #cdcdcd; min-height: 100px; margin-top: 10px" >
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
    $triggerFunc = "ajaxSavePaymentType()";
    ?>

    <!--    Selection Category Form [ Start ]  -->
    <fieldset>
        <div class="oneTwo" id="divAjaxLoad" name="divAjaxLoad">
            <div class="formRow">
                <label>Payment Types:</label>
                <div class="formRight">
                    <?php
                    if( isset($PaymentTypeArr) && count($PaymentTypeArr) > 0 ) {
                        ?>
                        <select name="PaymentTypeId" id="PaymentTypeId" class="selectClass" >
                            <option value="" >Select Payment Type</option>
                            <?php
                            foreach ( $PaymentTypeArr as $objPaymentTypeId => $objPaymentTypeValue ) {
                                ?>
                                <option value="<?php echo $objPaymentTypeId; ?>" ><?php echo $objPaymentTypeValue; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <?php
                    }
                    ?>
                    &nbsp&nbsp
                    <a href="javascript:void(0);" title="" class="wButtonSmall greenwB" onclick="<?php echo $triggerFunc;    ?>" ><span>Save</span></a>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </fieldset>
    <!--    Selection Category Form [ End ]  -->

</div>

<div class="custom_search_input_placement formRow widget" style="border:1px solid #cdcdcd;">
    <div class="custom_search_input_placement_50" name="paymentTypeList" id="paymentTypeList"></div>
</div>





<script type="text/javascript" src="<?php echo asset_url();?>js/AdminModules/payment_type.js"></script>

<script type="text/javascript">
$(window).on('load', function() {
    loadPaymentTypeList();
});
</script>