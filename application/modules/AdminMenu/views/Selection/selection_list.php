<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//printArr($SelecCatDetails);
?>
<div class="widget">
    <div class="title">
        <img src="<?php echo asset_url();?>dist/images/icons/dark/frames.png" alt="" class="titleIcon" />
        <h6>Sub Category List Of <b class="red"><?php echo $selecCatDetails[0]->SelecCatName;  ?></b></h6>
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
        if( isset($selecList) && is_array($selecList) ) {
            foreach ($selecList as $selecObj) {
                ?>
                <tr>
                    <td><?php echo $selecObj->SelecName;	?></td>
                    <td><?php echo $selecObj->SelecDefaultPrice;	?></td>
                    <td>
                        <a href="javascript:void(0);" title="" class="button blueB" style="margin: 5px;" onclick="openEditSelectionDiv(<?php echo $selecObj->FK_SelecCatId.", ".$selecObj->PK_SelecId;	?>)">
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
                    No Selection Found Please <a href="javascript:void(0);" onclick="openAddSelectionDiv(<?php echo $selecCatDetails[0]->PK_SelecCatId;  ?>)">ADD SELECTION</a>.
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
