<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="widget">
    <div class="title">
        <img src="<?php echo asset_url();?>dist/images/icons/dark/frames.png" alt="" class="titleIcon" />
        <h6>Admin User List</h6>
    </div>

    <table cellpadding="0" cellspacing="0" width="100%" class="sTable">
        <thead>
        <tr>
            <td class="sortCol"><div>Name</div></td>
            <td class="sortCol"><div>E-Mail</div></td>
            <td class="sortCol"><div>Registration Date</div></td>
            <td class="sortCol"><div>Status</div></td>

            <td class="sortCol"><div>Action</div></td>
        </tr>
        </thead>
        <tbody>
        <?php
        //printArr($recordList);
        //die();

        if( isset($recordList) && is_array($recordList) ) {
            foreach ($recordList as $recordObj) {
                ?>
                <tr>
                    <td><?php echo $recordObj->Name;	?></td>
                    <td><?php echo $recordObj->Email;	?></td>
                    <td><?php echo dateForDisplay(strtotime($recordObj->RegistrationDate));	?></td>
                    <td><?php echo ($recordObj->Status) ? "Active" : "Inactive";	?></td>

                    <td>
                        <a href="javascript:void(0);" class="button redB" style="margin: 5px;" onclick="ajaxDeleteUser(<?php echo $recordObj->PK_AdminUserId;	?>)">
                            <img src="<?php echo asset_url() ?>/dist/images/icons/light/home.png" alt="" class="icon"><span>DELETE</span>
                        </a>
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="8">
                    No Record Yet.
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
