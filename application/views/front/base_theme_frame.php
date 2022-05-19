<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <?php
    if( isset($dataHead) && is_array($dataHead) ) {
        $this->load->view('front/common/head', $dataHead);
    }
    ?>

    <body>
        <div id="main_container">

            <?php
            if( isset($dataHeader) && is_array($dataHeader) ) {
                if( isset($dataNavigation) && is_array($dataNavigation) ) {
                    $dataHeader['dataNavigation'] = $dataNavigation;
                }

                $this->load->view('front/common/header', $dataHeader);
            }

            if( isset($currentView) && $currentView != "" ) {
                if( $currentView == "front/includes/home") {
                    $this->load->view($currentView, $dataCurrentView);
                }
                else {
                    ?>
                    <div id="content_wrap">
                        <div id="content_block">
                            <?php   $this->load->view($currentView, $dataCurrentView);  ?>
                        </div>
                    </div>
                    <?php
                }

            }

            $this->load->view('front/common/scroll_to_top');
            $this->load->view('front/common/footer', $dataFooter);
            ?>

        </div>
    </body>







</html>