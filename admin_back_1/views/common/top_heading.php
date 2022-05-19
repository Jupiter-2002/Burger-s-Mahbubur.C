<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="titleArea">
	<div class="wrapper">
		<div class="pageTitle">
			<h5 style="margin-bottom: 5px;" ><?php echo strtoupper($page_title);	?></h5>

			<?php
			if( $_SERVER['REDIRECT_QUERY_STRING'] == "/dashboards" || $_SERVER['REDIRECT_QUERY_STRING'] == "/dashboards/" ) {

			}
			else if( isset($backButtonLink) && $backButtonLink != "" ) { ?>
				<span>
					<a href="<?php echo $backButtonLink;	?>" class="button blueB" ><span><< BACK</span></a>
				</span>
				<?php
			}
			else { ?>
				<span>
					<a href="javascript:goBack()" class="button blueB" ><span><< BACK</span></a>
				</span>
				<?php
			}
			?>
		</div>

		<?php if(isset($topHeadingButtonList) && count($topHeadingButtonList) > 0 ) { ?>
			<div class="middleNav">
				<ul>
					<?php
					foreach( $topHeadingButtonList as $buttonList ) {
						?>
						<li class="mFiles"><a href="<?php echo $buttonList->link; ?>" title="<?php echo strtoupper($buttonList->label); ?>" class="tipN"><span class="<?php echo $buttonList->class; ?>"></span></a></li>
						<?php
					}
					?>
					<!--
                    <li class="mUser"><a href="#" title=""><span class="users"></span></a>
                        <ul class="mSub1">
                            <li><a href="#" title="">Add user</a></li>
                            <li><a href="#" title="">Statistics</a></li>
                            <li><a href="#" title="">Orders</a></li>
                        </ul>
                    </li>
                    <li class="mMessages"><a href="#" title=""><span class="messages"></span></a>
                        <ul class="mSub2">
                            <li><a href="#" title="">New tickets<span class="numberRight">8</span></a></li>
                            <li><a href="#" title="">Pending tickets<span class="numberRight">12</span></a></li>
                            <li><a href="#" title="">Closed tickets</a></li>
                        </ul>
                    </li>
                    <li class="mFiles"><a href="#" title="Or you can use a tooltip" class="tipN"><span class="files"></span></a></li>
                    <li class="mOrders"><a href="#" title=""><span class="orders"></span><span class="numberMiddle">8</span></a>
                        <ul class="mSub4">
                            <li><a href="#" title="">Pending uploads</a></li>
                            <li><a href="#" title="">Statistics</a></li>
                            <li><a href="#" title="">Trash</a></li>
                        </ul>
                    </li>
                    -->
				</ul>

				<div class="clear"></div>
			</div>
		<?php } ?>

		<div class="clear"></div>
	</div>
</div>
<div class="line"></div>


<!--	Module Logo Slider [ Start ]	-->
<script type="text/javascript">
	$(window).load(function() {
		$("#flexiselDemo4").flexisel({
			infinite: false,
			itemsToScroll: 1,
			visibleItems: 11
		});

		if( $('#flexiselDemo4 li').length < 10 ) {
			setTimeout( function() {
				$(".nbs-flexisel-nav-left").addClass("disabled");
				$(".nbs-flexisel-nav-right").addClass("disabled");
				$(".nbs-flexisel-nav-left").unbind();
				$(".nbs-flexisel-nav-right").unbind();
			}, 100);
		}
	});
</script>
<!--	Module Logo Slider [ Start ]	-->

<script type="text/javascript">
    function goBack() {
        window.history.back();
    }
</script>
