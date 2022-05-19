<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="widget">
    <div class="title">
        <img src="<?php echo asset_url();?>dist/images/icons/dark/frames.png" alt="" class="titleIcon" />
        <h6>Sub Category List Of <b class="red"><?php echo $CategoryDetails[0]->CatName;  ?></b></h6>
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
        if( isset($subCategoryList) && is_array($subCategoryList) ) {
            foreach ($subCategoryList as $subCategoryObj) {
                ?>
                <tr>
                    <td><?php echo $subCategoryObj->SubCatName;	?></td>
                    <td><?php echo $subCategoryObj->SubCatDiscount;	?></td>
                    <td><?php echo ($subCategoryObj->SubCatStatus)? "TRUE":"FALSE";	?></td>
                    <td>
                        <a href="javascript:void(0);" title="" class="button blueB" style="margin: 5px;" onclick="openEditSubCategoryDiv(<?php echo $subCategoryObj->FK_CatId.", ".$subCategoryObj->PK_SubCatId;	?>)">
                            <img src="<?php echo asset_url() ?>/dist/images/icons/light/home.png" alt="" class="icon"><span>EDIT</span>
                        </a>
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="5">
                    No Sub Category Found Please <a href="javascript:void(0);" onclick="openAddSubCategoryDiv(<?php echo $CategoryDetails[0]->PK_CatId;  ?>)">ADD SUB CATEGORY</a>.
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
