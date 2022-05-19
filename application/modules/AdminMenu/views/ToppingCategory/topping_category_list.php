<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="widget">
    <div class="title">
        <img src="<?php echo asset_url();?>dist/images/icons/dark/frames.png" alt="" class="titleIcon" />
        <h6>Topping Category List</h6>
    </div>

    <table cellpadding="0" cellspacing="0" width="100%" class="sTable">
        <thead>
        <tr>
            <td class="sortCol"><div>Name</div></td>

            <td class="sortCol"><div>Action</div></td>
        </tr>
        </thead>
        <tbody>
        <?php
        if( isset($recordList) && is_array($recordList) ) {
            foreach ($recordList as $recordObj) {
                ?>
                <tr>
                    <td><?php echo $recordObj->ToppCatName;	?></td>
                    <td>
                        <a href="javascript:void(0);" title="" class="button blueB" style="margin: 5px;" onclick="openEditToppingCategoryDiv(<?php echo $recordObj->PK_ToppCatId;	?>)">
                            <img src="<?php echo asset_url() ?>/dist/images/icons/light/home.png" alt="" class="icon"><span>EDIT</span>
                        </a>
                        <br>

                        <div class="widget">
                            <div class="title">
                                <h6 style="margin: 0 auto;width: 100%;">Topping</h6>
                            </div>
                            <a href="javascript:void(0);" title="" class="button greenB" style="margin: 5px;" onclick="openAddToppingDiv(<?php echo $recordObj->PK_ToppCatId;	?>)">
                                <img src="<?php echo asset_url() ?>/dist/images/icons/light/home.png" alt="" class="icon"><span>Add</span>
                            </a>
                            <?php
                            if( $recordObj->HasTopp ) {
                                ?>
                                <a href="javascript:void(0);" title="" class="button greenB" style="margin: 5px;" onclick="loadToppingList(<?php echo $recordObj->PK_ToppCatId;	?>, true)">
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
                    No Topping Found Please <a href="javascript:void(0);" onclick="openToppingCategoryDiv()">ADD TOPPING CATEGORY</a>.
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
