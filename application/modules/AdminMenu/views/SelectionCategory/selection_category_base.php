<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!--    Ajax Load   -->
<div id="divAjaxLoad" name="divAjaxLoad" class="form widget" style="border:1px solid #cdcdcd; min-height: 100px; display: none; margin-top: 10px" ></div>

<div class="custom_search_input_placement formRow widget" style="border:1px solid #cdcdcd;">
    <div class="custom_search_input_placement_50" name="divSelectionCategoryList" id="divSelectionCategoryList"></div>

    <div class="custom_search_input_placement_50" name="divSelectionList" id="divSelectionList"></div>
</div>





<script type="text/javascript" src="<?php echo asset_url();?>js/AdminMenu/selection.js"></script>

<script type="text/javascript">
$(window).on('load', function() {
    loadSelectionCategoryList();
});
</script>