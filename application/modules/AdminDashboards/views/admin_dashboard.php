<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script>
    setTimeout(function(){
        window.location.reload(1);
    }, 100000);
</script>

<div class="statsRow">
	<div class="wrapper">
		<div class="controlB">
			<ul>
				<!-- <li><a href="<?php echo base_url()."admin/site_settings" ?>" title=""><img src="<?php echo asset_url();?>dist/images/dashboard/icon-settings2.png" alt="" /><span>Settings</span></a></li>
				<li><a href="<?php echo base_url()."admin/admin_list" ?>" title=""><img src="<?php echo asset_url();?>dist/images/dashboard/admin-list.png" alt="" /><span>Admin List</span></a></li>
				<li><a href="<?php echo base_url(); ?>" title=""><img src="<?php echo asset_url();?>dist/images/dashboard/admin-list.png" alt="" /><span>Admin Zone</span></a></li>
				<li><a href="<?php echo base_url()."adminmenu"; ?>" title=""><img src="<?php echo asset_url();?>dist/images/dashboard/bar-list.png" alt="" /><span>Category Manager</span></a></li>
				<li><a href="<?php echo base_url(); ?>" title=""><img src="<?php echo asset_url();?>dist/images/dashboard/add-bar.png" alt="" /><span>Add Bar</span></a></li>
				<li><a href="<?php echo base_url(); ?>" title=""><img src="<?php echo asset_url();?>dist/images/dashboard/bar-list.png" alt="" /><span>Brewery List</span></a></li>
				<li><a href="<?php echo base_url(); ?>" title=""><img src="<?php echo asset_url();?>dist/images/dashboard/bar-submission.png" alt="" /><span>Bar Submission</span></a></li>
				<li><a href="<?php echo base_url(); ?>" title=""><img src="<?php echo asset_url();?>dist/images/dashboard/icon-Customer.png" alt="" /><span>Customer List</span></a></li>
				<li><a href="<?php echo base_url(); ?>" title=""><img src="<?php echo asset_url();?>dist/images/dashboard/points.png" alt="" /><span>Points</span></a></li>
                <li><a href="<?php echo base_url(); ?>" title=""><img src="<?php echo asset_url();?>dist/images/dashboard/payment-list.png" alt="" /><span>Deposits</span></a></li>
				<li><a href="<?php echo base_url(); ?>" title=""><img src="<?php echo asset_url();?>dist/images/dashboard/bar-payment.png" alt="" /><span>Bar Payment</span></a></li>
                <li><a href="<?php echo base_url(); ?>" title=""><img src="<?php echo asset_url();?>dist/images/dashboard/visit-history.png" alt="" /><span>Visit History</span></a></li>
				<li><a href="<?php echo base_url(); ?>" title=""><img src="<?php echo asset_url();?>dist/images/dashboard/visit-summary.png" alt="" /><span>Visit Summary</span></a></li>
				<li><a href="<?php echo base_url(); ?>" title=""><img src="<?php echo asset_url();?>dist/images/dashboard/triggers.png" alt="" /><span>Triggers</span></a></li> -->

				<li><a href="<?php echo base_url()."adminmenu/admincategory" ?>" title=""><span>Category</span></a></li>
				<li><a href="<?php echo base_url()."adminmenu/adminitem" ?>" title=""><span>Item</span></a></li>
				<li><a href="<?php echo base_url()."adminmenu/adminmenu" ?>" title=""><span>Menu</span></a></li>
				<li><a href="<?php echo base_url()."adminmenu/adminselection" ?>" title=""><span>Selection</span></a></li>
				<li><a href="<?php echo base_url()."adminmenu/admintopping" ?>" title=""><span>Topping</span></a></li>
				<li><a href="<?php echo base_url()."adminmodules/admindelivery" ?>" title=""><span>Delivery</span></a></li>
				<li><a href="<?php echo base_url()."adminmodules/admindiscount" ?>" title=""><span>Discount</span></a></li>

				<li><a href="<?php echo base_url()."adminmodules/adminorder" ?>" title=""><span>Order</span></a></li>
				<li><a href="<?php echo base_url()."adminmodules/adminordertype" ?>" title=""><span>Order Type</span></a></li>
				<li><a href="<?php echo base_url()."adminmodules/adminpaymenttype" ?>" title=""><span>Payment Type</span></a></li>
				<li><a href="<?php echo base_url()."adminmodules/adminrestaurant" ?>" title=""><span>Restaurant</span></a></li>
				<li><a href="<?php echo base_url()."adminmodules/admintime" ?>" title=""><span>Time</span></a></li>
				<li><a href="<?php echo base_url()."adminmodules/adminuser" ?>" title=""><span>User</span></a></li>

			</ul>
			<div class="clear"></div>
		</div>
	</div>
</div>

<div class="line"></div>
