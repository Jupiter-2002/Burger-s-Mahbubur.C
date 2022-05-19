<div class="title">
    <img src="<?php echo asset_url() ?>dist/images/icons/dark/list.png" alt="" class="titleIcon"><h6><?php echo $SegmentTitle;   ?></h6>
</div>

<!--    Error Message View Segment [ Start ]    -->
<div id="topp_form_error_msg_div" name="topp_form_error_msg_div" class="formRow" style="display: none">
    <div class="nNote nFailure hideit" style="margin: 0;">
        <p style="margin-top: 10px;">
            <strong>FAILURE: </strong>
            <span id="topp_form_error_msg" name="topp_form_error_msg" ></span>
        </p>
    </div>
</div>
<!--    Error Message View Segment [ End ]    -->

<!--    Success Message View Segment [ Start ]    -->
<div id="topp_form_success_msg_div" name="topp_form_success_msg_div" class="formRow" style="display: none">
    <div class="nNote nSuccess hideit" style="margin: 0;">
        <p style="margin-top: 10px;">
            <strong>SUCCESS: </strong>
            <span id="topp_form_success_msg" name="topp_form_success_msg" ></span>
        </p>
    </div>
</div>
<!--    Success Message View Segment [ End ]    -->

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
                            <select name="PK_ToppCatId" id="PK_ToppCatId" class="selectClass" >
                                <option value="" >Select Category</option>
                                <?php
                                foreach ( $arrCategoryList as $objCategory ) {
                                    ?>
                                    <option value="<?php echo $objCategory->PK_ToppCatId; ?>" ><?php echo $objCategory->ToppCatName; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <?php
                        }
                        ?>

                        <a href="javascript:void(0);"  title="" class="wButton greenwB" style="color: white; height: 24px; line-height: 24px; float: left; margin-left: 15px;" onclick="loadSelectionToppingByCategoryForm(<?= $BaseItemDetails[0]->PK_BaseId;  ?>, <?= $SelecId;  ?>)" ><span>LOAD</span></a>

                        <a href="javascript:void(0);"  title="" class="wButton redwB" style="color: white; height: 24px; line-height: 24px; float: left; margin-left: 15px;" onclick="hideAddEditSelectionSegment(<?= $BaseItemDetails[0]->PK_BaseId;  ?>, <?= $SelecId;  ?>)" ><span>CLOSE</span></a>
                    </div>
                    <div class="clear"></div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <span id="spanToppingList" name="spanToppingList" style="width: 100%"></span>
</fieldset>
<!--    Sub Category Form [ End ]  -->