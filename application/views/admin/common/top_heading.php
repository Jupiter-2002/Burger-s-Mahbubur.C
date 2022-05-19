<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="titleArea">
	<div class="wrapper">
		<div class="pageTitle">
			<h5 style="margin-bottom: 5px;" ><?php echo strtoupper($page_title);	?></h5>

			<?php
			if( $_SERVER['REDIRECT_QUERY_STRING'] == "/dashboards" || $_SERVER['REDIRECT_QUERY_STRING'] == "/dashboards/" ) {	
				//	
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
				</ul>

				<div class="clear"></div>
			</div>
		<?php } ?>

        <?php 
		if(isset($topjQueryHeadingButtonList) && count((array)$topjQueryHeadingButtonList) > 0 ) {
            ?>
            <div class="middleNav">
                <ul>
                    <?php
                    foreach( $topjQueryHeadingButtonList as $jsButtonList ) {
                        ?>
                        <li class="mFiles">
                            <a href="javascript:void(0);" title="<?php echo strtoupper($jsButtonList->label); ?>" class="tipN" <?php echo $jsButtonList->event ?>="<?php echo $jsButtonList->eventFunction ?>">
                                <span class="<?php echo $jsButtonList->class; ?>"></span>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
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
