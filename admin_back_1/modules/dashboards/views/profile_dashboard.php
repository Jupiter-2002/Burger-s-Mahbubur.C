<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="widgets">
	<div class="oneTwo">
		<div class="widget">
			<div class="controlB">
				<ul>
					<li><a href="<?php echo base_url()."profile/edit_profile"; ?>" title=""><img src="<?php echo asset_url();?>dist/images/dashboard/edit.png" alt="" /><span>Edit Profile</span></a></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="oneTwo">
		<div class="widget">
			<div class="title">
				<img src="<?php echo asset_url();?>dist/images/icons/dark/frames.png" alt="" class="titleIcon" />
				<h6>Details</h6>
			</div>
			<table cellpadding="0" cellspacing="0" width="100%" class="sTable" id="res">
				<tbody>
				<tr>
					<td>Name :</td>
					<td><?php echo $admin_user->Name; ?></td>
				</tr>
				<tr>
					<td>Email :</td>
					<td><?php echo $admin_user->Email; ?></td>
				</tr>
				<tr>
					<td>UserType :</td>
					<td><?php if($admin_user->UserType == 1) { echo "ADMIN"; } else { echo "BAR OWNER"; } ?></td>
				</tr>
				<tr>
					<td>RegistrationDate :</td>
					<td><?php echo process_datetime_format(strtotime($admin_user->RegistrationDate)); ?></td>
				</tr>
				<tr>
					<td>UpdateTime :</td>
					<td><?php echo process_datetime_format(strtotime($admin_user->UpdateTime)); ?></td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="clear"></div>
<?php
if( $admin_user->UserType == 2 ) { ?>
	<div class="widget">
		<div class="title"><img src="<?php echo asset_url();?>dist/images/icons/dark/frames.png" alt="" class="titleIcon">
			<h6>Personal Information</h6>
		</div>
		<table class="sTable CRZ" id="res" width="100%" cellspacing="0" cellpadding="0">
			<tbody>
			<tr>
				<td>Address :</td>
				<td><?php echo $admin_user->PostCode.", ".$admin_user->Address;	?></td>
			</tr>
			<tr>
				<td>City :</td>
				<td><?php echo $admin_user->City;	?></td>
			</tr>
			<tr>
				<td>Phone Number :</td>
				<td><a href="tel:<?php echo $admin_user->PhoneNo;	?>"><?php echo $admin_user->PhoneNo;	?></a></td>
			</tr>
			<tr>
				<td>Mobile Number :</td>
				<td><a href="tel:<?php echo $admin_user->MobileNo;	?>"><?php echo $admin_user->MobileNo;	?></a></td>
			</tr>
			</tbody>
		</table>
	</div>
	<?php
}
?>
