<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!--    Header [ Start ]    -->
<div id="header_wrap">
    <div id="logo_wrap">
        <div id="logo_block">
            <a href="<?= base_url(); ?>"><img src="<?php echo $logoUrl; ?>" alt="" title="" /></a>
            <div class="headlanguage">
                <ul>
                    <li><span class="fontsmall">Need Help? Call Us Now</span></li>
                    <li><span class="fontlarge"><?php echo $contactNumber; ?></span></li>
                </ul>
            </div>
        </div>
    </div>

    <?php   $this->load->view('front/common/navigation', $dataNavigation);     ?>
</div>
<!--    Header [ End ]    -->