<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="widget">
    <div class="title">
        <img src="<?php echo asset_url();?>dist/images/icons/dark/frames.png" alt="" class="titleIcon" />
        <h6>Category List</h6>
    </div>

    <table cellpadding="0" cellspacing="0" width="100%" class="sTable">
        <thead>
        <tr>
            <td class="sortCol"><div>Name</div></td>
            <td class="sortCol"><div>Discount</div></td>
            <td class="sortCol"><div>Status</div></td>
            <td class="sortCol"><div>Action</div></td>
        </tr>
        </thead>
        <tbody>
        <?php
        if( isset($categoryList) && is_array($categoryList) ) {
            foreach ($categoryList as $categoryObj) {
                ?>
                <tr>
                    <td><?php echo $categoryObj->CatName;	?></td>
                    <td><?php echo $categoryObj->CatDiscount;	?></td>
                    <td><?php echo ($categoryObj->CatStatus)? "TRUE":"FALSE";	?></td>
                    <td>
                        <a href="javascript:void(0);" title="" class="button blueB" style="margin: 5px;" onclick="openEditCategoryDiv(<?php echo $categoryObj->PK_CatId;	?>)">
                            <img src="<?php echo asset_url() ?>/dist/images/icons/light/home.png" alt="" class="icon"><span>EDIT</span>
                        </a>

                        <br>
                        <div class="widget">
                            <div class="title">
                                <h6 style="margin: 0 auto;width: 100%;">Sub-Category</h6>
                            </div>
                            <a href="javascript:void(0);" title="" class="button blueB" style="margin: 5px;" onclick="openAddSubCategoryDiv(<?php echo $categoryObj->PK_CatId;	?>)">
                                <img src="<?php echo asset_url() ?>/dist/images/icons/light/home.png" alt="" class="icon"><span>Add</span>
                            </a>
                            <?php
                            if( $categoryObj->HasSubCat ) {
                                ?>
                                <a href="javascript:void(0);" title="" class="button blueB" style="margin: 5px;" onclick="loadSubCategoryList(<?php echo $categoryObj->PK_CatId;	?>, true)">
                                    <img src="<?php echo asset_url() ?>/dist/images/icons/light/home.png" alt="" class="icon"><span>View</span>
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="5">
                    No Category Found Please <a href="javascript:void(0);" onclick="openAddCategoryDiv()">ADD CATEGORY</a>.
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
