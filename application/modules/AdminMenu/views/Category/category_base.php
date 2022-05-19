<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!--    Ajax Load   -->
<div id="divAjaxLoad" name="divAjaxLoad" class="form widget" style="border:1px solid #cdcdcd; min-height: 100px; display: none; margin-top: 10px" ></div>

<div class="custom_search_input_placement formRow widget" style="border:1px solid #cdcdcd;">

    <div class="custom_search_input_placement_50" name="divCategoryList" id="divCategoryList"></div>

    <div class="custom_search_input_placement_50" name="divSubCategoryList" id="divSubCategoryList"></div>
</div>





<script type="text/javascript" src="<?php echo asset_url();?>js/AdminMenu/category.js"></script>

<script type="text/javascript">
$(window).on('load', function() {
    loadCategoryList();
});
</script>