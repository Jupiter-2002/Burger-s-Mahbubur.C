<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//printArr($SelecCatDetails);
?>
<div class="widget">
    <div class="title">
        <img src="<?php echo asset_url();?>dist/images/icons/dark/frames.png" alt="" class="titleIcon" />
        <h6>Sub Category List Of <b class="red"><?php echo $catObjDetails[0]->ToppCatName;  ?></b></h6>
    </div>

    <table cellpadding="0" cellspacing="0" width="100%" class="sTable">
        <thead>
        <tr>
            <td class="sortCol"><div>Name</div></td>
            <td class="sortCol"><div>Price</div></td>
            <td class="sortCol"><div>Action</div></td>
        </tr>
        </thead>
        <tbody>
        <?php
        if( isset($objList) && is_array($objList) ) {
            foreach ($objList as $objDetails) {
                ?>
                <tr>
                    <td><?php echo $objDetails->ToppName;	?></td>
                    <td><?php echo $objDetails->ToppDefaultPrice;	?></td>
                    <td>
                        <a href="javascript:void(0);" title="" class="button blueB" style="margin: 5px;" onclick="openEditToppingDiv(<?php echo $objDetails->FK_ToppCatId.", ".$objDetails->PK_ToppId;	?>)">
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
                    No Topping Found Please <a href="javascript:void(0);" onclick="openAddToppingDiv(<?php echo $catObjDetails[0]->PK_ToppCatId;  ?>)">ADD TOPPING</a>.
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
