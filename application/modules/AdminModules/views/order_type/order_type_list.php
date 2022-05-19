<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="widget">
    <div class="title">
        <img src="<?php echo asset_url();?>dist/images/icons/dark/frames.png" alt="" class="titleIcon" />
        <h6>Order Type List</h6>
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
                    <td><?php echo $recordObj->Name;	?></td>
                    <td>
                        <a href="javascript:void(0);" title="" class="button redB" style="margin: 5px;" onclick="ajaxDeleteOrderType(<?php echo $recordObj->OrderTypeId;	?>)">
                            <img src="<?php echo asset_url() ?>/dist/images/icons/light/home.png" alt="" class="icon"><span>DELETE</span>
                        </a>
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="5">
                    No Order Type Yet.
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
