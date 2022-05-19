<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="custom_search_input_placement formRow widget" style="border:1px solid #cdcdcd;">

    <!--    Error Message View Segment [ Start ]    -->
    <div id="selection_error_msg_div" name="selection_error_msg_div" class="formRow" style="display: none">
        <div class="nNote nFailure hideit" style="margin: 0;">
            <p style="margin-top: 10px;">
                <strong>FAILURE: </strong>
                <span id="selection_error_msg" name="selection_error_msg" ></span>
            </p>
        </div>
    </div>
    <!--    Error Message View Segment [ End ]    -->

    <div class="custom_search_input_placement_25">
        <div class="custom_search_input_heding">Category</div>
        <div>
            <select name="dropCategory" id="dropCategory" class="selectClass" onchange="loadSubCategoryOfCategory(this.value, 'divSubCategory', 'dropSubCategory', false, '', '#ajaxSpinner')" >
                <option value="" >Select Category</option>
            </select>
        </div>
    </div>

    <div class="custom_search_input_placement_25" name="divSubCategory" id="divSubCategory" style="display: none">
        <div class="custom_search_input_heding">Sub Category</div>
        <div>
            <select name="dropSubCategory" id="dropSubCategory" class="selectClass" >
                <option value="" >Select Sub Category</option>
            </select>
        </div>
    </div>

    <div class="custom_search_input_placement_25">
        <div class="custom_search_input_heding">&nbsp;</div>
        <div>
            <a href="javascript:void(0);" title="" class="button blueB" style="vertical-align: top" onclick="loadViewItemDiv(false, false)" >
                <img src="<?php echo asset_url() ?>/dist/images/icons/light/home.png" alt="" class="icon"><span>View Item</span>
            </a>
            <a href="javascript:void(0);" title="" class="button greenB" style="vertical-align: top" onclick="loadAddItemDiv()" >
                <img src="<?php echo asset_url() ?>/dist/images/icons/light/home.png" alt="" class="icon"><span>Add Item</span>
            </a>
        </div>
    </div>

    <div class="custom_search_input_placement_25">
        <div class="custom_search_input_heding">&nbsp;</div>
        <div class="custom_search_input_placement_25" name="ajaxSpinner" id="ajaxSpinner" style="padding: 0px;" ></div>
    </div>


</div>



<!--    Ajax Load for Add Item  -->
<div id="divAjaxAddItmLoad" name="divAjaxAddItmLoad" class="form widget" style="border:1px solid #cdcdcd; min-height: 100px; display: none; margin-top: 10px" ></div>

<!--    Ajax Load for View Item  -->
<div id="divAjaxViewItmLoad" name="divAjaxViewItmLoad" class="form widget" style="border:1px solid #cdcdcd; min-height: 100px; display: none; margin-top: 10px" ></div>


<script type="text/javascript" src="<?php echo asset_url();?>js/AdminMenu/category.js"></script>
<script type="text/javascript" src="<?php echo asset_url();?>js/AdminMenu/item.js"></script>

<script type="text/javascript">
$(window).on('load', function() {
    loadCategoryDropDown();
});
</script>