<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo "</br>< ===  Start  === > SESSION [base_theme_frame] < ===  Start  === ></br><pre>";   print_r($_SESSION);     echo "</pre></br>< ===  End  === > SESSION [base_theme_frame] < ===  End  === ></br>";
?>

<html>
	<?php
	if( isset($page_title) && $page_title != "" ) {
		$dataHead['page_title'] = $page_title;
	} else {
		$dataHead['page_title'] = "Admin Panel";
	}
	$this->load->view('common/head_segment',$dataHead);
	?>
	<body>
		<?php
		//		Left Panel No Longer Used on the System
		/*
		if( isset($leftPanelView) && $leftPanelView != "" ) {
			$this->load->view($leftPanelView);
		} else {
			$this->load->view('common/left_panel_basic');
		}
		*/
		?>

		<div id="rightSide">
			<?php
			//	Right Side Top NAV
			$this->load->view('common/top_nav_Menu');

			if( isset($respnsHeader) && $respnsHeader != "" ) {
				$this->load->view($respnsHeader);
			} else {
				$this->load->view('common/respns_header_basic');
			}

			//	For 'headerIconSlider' Segment [ Start ]
			if( isset($headerIconSliderPage) && $headerIconSliderPage != "" ) {
				$this->load->view($headerIconSliderPage);
			} else {
				$this->load->view('common/headerIconSliderBasic');
			}
			//	For 'headerIconSlider' Segment [ End ]

			//	For Different inner Page Heading And Page Icon Segment [ Start ]
			if( isset($heading_page_title) && $heading_page_title != "" ) {
				$page_title = $heading_page_title;
			}
			if( isset($page_title) && $page_title != "" ) {
			} else {
				$page_title = "Admin Panel";
			}

			$arr_top_heading_data = array("page_title"=>$page_title);
			if( isset($topHeadingButtonList) && count($topHeadingButtonList) > 0 ) {
				$arr_top_heading_data["topHeadingButtonList"] = $topHeadingButtonList;
			}
			if( isset($backButtonLink) && $backButtonLink != "" ) {
				$arr_top_heading_data["backButtonLink"] = $backButtonLink;
			}
			$this->load->view('common/top_heading', $arr_top_heading_data);
			//	For Different inner Page Heading And Page Icon Segment [ End ]
			?>
			<div class="wrapper">
				<?php
				if( isset($currentView) && $currentView != "" ) {
					$this->load->view($currentView);
				}
				?>
			</div>
		</div>

		<!-- Footer line -->
		<div id="footer">
			<div class="wrapper">&copy; 2020 Solo Restaurant. Design and Developed by <a href="#" title="">iSoftware Limited</a></div>
		</div>

	</body>
</html>

