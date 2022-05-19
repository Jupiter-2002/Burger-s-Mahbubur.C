<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="topNav">
	<div class="wrapper">
		<div class="welcome">
			<a href="#" title="" ><img src="<?php echo asset_url();?>dist/images/userPic.png" alt="" /></a>
			<span><?php echo (isset($_SESSION['admin_user']->Name)) ? "Hello, ".$_SESSION['admin_user']->Name:""; ?></span>
		</div>
		<div class="userNav">
			<ul>
				<li class="redBackOnly" ><a href="<?php echo base_url().'admin';	?>" title=""><img src="<?php echo asset_url();?>dist/images/icons/topnav/tasks.png" alt="" /><span><b>HOME</b></span></a></li>

				<?php
				if( isset($_SESSION['AdminSelectedBarId']) && $_SESSION['AdminSelectedBarId'] > 0 ) {
					?>
					<li><a href="<?php echo base_url();	?>dashboards/bar_owner_dashboard" title=""><img src="<?php echo asset_url();?>dist/images/icons/topnav/settings.png" alt="" /><span class="green"><b>BAR PANEL</b></span></a></li>
					<?php
				} ?>

				<?php
				if( isset($_SESSION['admin_user']->UserType) && $_SESSION['admin_user']->UserType == 2 && isset($_SESSION['multi_bar_owner']) && $_SESSION['multi_bar_owner'] ) {
					?>
					<li><a href="<?php echo base_url();	?>dashboards/multi_bar_list" title=""><img src="<?php echo asset_url();?>dist/images/icons/topnav/settings.png" alt="" /><span class="green"><b>CHANGE INSTITUTIONS</b></span></a></li>
					<?php
				}
				?>

				<li><a href="<?php echo base_url()."dashboards/profile_dashboard"; ?>" title=""><img src="<?php echo asset_url();?>dist/images/icons/topnav/profile.png" alt="" /><span>Profile</span></a></li>
				<li><a href="<?php echo base_url()."admin/logout"; ?>" title=""><img src="<?php echo asset_url();?>dist/images/icons/topnav/logout.png" alt="" /><span>Logout</span></a></li>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
</div>
