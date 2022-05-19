<!--    Royal Slider Banner [ Start ]   -->
<link rel="stylesheet" type="text/css" href="<?php echo asset_url();?>front_dist/css/banner.css">
<script type='text/javascript' src='<?php echo asset_url();?>front_dist/js/jquery.royalslider.min.js'></script>
<script type="text/javascript">

    //<![CDATA[

    function slideshowHeight() {

        var window_height = jQuery(window).height(),
            toolbar_shop_height = jQuery('.toolbar-shop').height(),
            header_height = jQuery('.header').height(),
            navigation_height = jQuery('.navigation').height(),
            slideshow_height = window_height - toolbar_shop_height - header_height - navigation_height,
            slideshow_height_device = '500';

        jQuery('.slideshow').css('height', slideshow_height);

    }

    function calloutMargin() {

        if ((jQuery(window).width() > 480)) {
            jQuery('.grid-isoftware-home .isoft').each(
                function () {
                    var isoft_header_height = jQuery(this).find('.isoft-header').height();
                    jQuery(this).css('margin-top', - isoft_header_height);
                }
            );
        } else {
            jQuery('.grid-isoftware-home .isoft').each(
                function () {
                    jQuery(this).css('margin-top', '2em');
                }
            );
        }

    }

    jQuery(document).ready(slideshowHeight);
    jQuery(window).resize(slideshowHeight);

    jQuery(document).ready(calloutMargin);
    jQuery(window).resize(calloutMargin);


    jQuery(document).ready(function () {
        "use strict";

        // Slideshow
        jQuery('.slideshow-container').royalSlider({
            loop: true,
            keyboardNavEnabled: true,
            controlsInside: false,
            imageScaleMode: 'fill',
            arrowsNav: true,
            arrowsNavAutoHide: false,
            arrowsNavHideOnTouch: false,
            sliderDrag: false,
            sliderTouch: false,
            autoScaleSlider: false,
            controlNavigation: 'none',
            navigateByClick: true,
            transitionType: 'move',
            slidesOrientation: 'horizontal',
            transitionSpeed: 1000,
            slidesSpacing: 0,
            numImagesToPreload: 3,
            globalCaption: false,
            allowCSS3: false,
            block: {
                fadeEffect: false,
                moveEffect: 'bottom'
            },
            autoPlay: {
                enabled: true,
                pauseOnHover: false,
                delay: 5000
            }
        });

        var slider = jQuery('.slideshow-container').data('royalSlider'),
            window_width = jQuery(window).width(),
            window_height = jQuery(window).height();

        slider.ev.on('rsVideoPlay', function() {
            jQuery('.grid-isoftware-home .isoft').css('margin-top', '0');
            jQuery('.grid-isoftware-home .isoft-header').hide();
        });

        slider.ev.on('rsVideoStop', function() {
            calloutMargin();
            jQuery('.grid-isoftware-home .isoft-header').show();
        });

    });

    //]]>

</script>

<div id="banner_wrap">
    <div id="banner_block">
        <div class="slideshow">
            <div class="slideshow-container royalSlider gp-theme">
                <div class="slide-1 rsContent">
                    <div class="bannerwelcometext"></div>
                    <img class="rsImg" src="<?php echo asset_url();?>front_dist/images/bannerimg1.jpg" alt="" title="" />
                </div>

                <div class="slide-2 rsContent">
                    <div class="bannerwelcometext"></div>
                    <img class="rsImg" src="<?php echo asset_url();?>front_dist/images/bannerimg2.jpg" alt="" title="" />
                </div>

                <div class="slide-3 rsContent">
                    <div class="bannerwelcometext"></div>
                    <img class="rsImg" src="<?php echo asset_url();?>front_dist/images/bannerimg3.jpg" alt="" title="" />
                </div>

                <div class="slide-4 rsContent">
                    <div class="bannerwelcometext"></div>
                    <img class="rsImg" src="<?php echo asset_url();?>front_dist/images/bannerimg4.jpg" alt="" title="" />
                </div>
            </div>
        </div>
    </div>
</div>
<!--    Royal Slider Banner [ End ]   -->


<!--    Branches [ Start ]      -->
<style type="text/css" >
    .branch_select_txt
    {
        cursor:pointer;
        float:left;
        margin:0px 0 20px 0;
        padding:0;
        width:1018px;
        height:120px;

        background:url(<?php echo asset_url();?>front_dist/images/branch-indicator.png) no-repeat;
    }

    .expose
    {
        position:relative;
    }

    .disable_all
    {
        background:rgba(0,0,0,0.80);
        display:none;
        width:100%;
        height:2800px !important;
        position:absolute;
        top:0;
        left:0;
        z-index:90000;
    }
</style>

<script type="text/javascript">
    $(document).ready(function(){
        $('#focus_branch').click(function(e){
            $('.branch_select_txt').show("slow");
            $('.branch_segment').css('z-index','99999');
            $('.disable_all').fadeIn(300);
        });

        $('.disable_all').click(function(e){
            $('.disable_all').fadeOut(300, function(){
                $('.branch_select_txt').hide("slow");
                $('.branch_segment').css('z-index','1');
            });
        });
    });
</script>

<div class="disable_all"></div>

<div id="branches_wrap">
    <div id="branches_block">
        <div class="branch_segment expose" >
            <div class="branch_select_txt" style="display:none"></div>

            <div class="branch_heading">Our Branches</div>

            <div class="branch_area" >
                <a href="javascript:void(0)">
                    <div class="restaurant_branch">
                        <div class="restaurant_branch_heading">Branch Aalborg</div>
                        <div class="branch_img">
                            <img src="<?php echo asset_url();?>front_dist/images/restaurant-branch-img1.jpg" alt="" title="" />
                        </div>
                        <div class="restaurant_branch_address">
                            Sjællandsgade 36,<br /> 9000, Aalborg Denmark
                        </div>
                    </div>
                </a>

                <a href="javascript:void(0)">
                    <div class="restaurant_branch">
                        <div class="restaurant_branch_heading">Branch Ryomgård</div>
                        <div class="branch_img">
                            <img src="<?php echo asset_url();?>front_dist/images/restaurant-branch-img2.jpg" alt="" title="" />
                        </div>
                        <div class="restaurant_branch_address">
                            Slotsgade 10, <br />8550, Ryomgård Denmark
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<!--    Branches [ End ]      -->


<div id="black_wrap">
    <div id="black_block">
        <div class="order_online_block">
            <div class="order_online_block_heading">Order Online</div>
            <ul>
                <li>
                    <span class="orderonlineimg"><img src="<?php echo asset_url();?>front_dist/images/orderonline-basket.png" alt="" title="" /></span>
                    <span class="orderonlinetext">Simply add items to the cart and pay online using cash or credit card.</span>
                </li>

                <li>
                    <span class="orderonlineimg"><img src="<?php echo asset_url();?>front_dist/images/orderonline-basket.png" alt="" title="" /></span>
                    <span class="orderonlinetext">You will receive an SMS confirming our restaurant has accepted your order.</span>
                </li>
            </ul>
            <div class="order_online_block_savetime">Save time. Easy online ordering for restaurants.</div>
        </div>

        <div class="secure_payment_block">
            <div class="secure_payment_block_heading">SAFE, SECURE & RELIABLE</div>
            <div class="secure_payment_block_btn_orderonline">
                <a id="focus_branch" name="focus_branch" href="#branches_wrap">Order Online</a>
            </div>
            <div class="secure_payment_block_card"><img src="<?php echo asset_url();?>front_dist/images/secure-payment-card.png" alt="" title="" /></div>
        </div>
    </div>
</div>


<!--    Welcome Message Slider [ Start ]   -->
<script src="<?php echo asset_url();?>front_dist/message-slider/jquery.bxslider.min.js" type="text/javascript"></script>
<link href="<?php echo asset_url();?>front_dist/message-slider/jquery.bxslider.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    $(document).ready(function () {
        $('.bxslider').bxSlider({
            mode: 'horizontal',
            slideMargin: 3,
            auto:true
        });
    });
</script>

<div id="message_wrap">
    <div id="message_block">
        <div class="featured_wrap_message_heading">Welcome to <span>American</span></div>
        <div class="featured_wrap_message">
            <ul class="bxslider">
                <li>
                    <div class="featured_wrap_message_textshow">
                        " Donec elementum mollis magna id aliquet. Etiam eleifend urna eget sem sagittis feugiat. Pellentesque<br />
                        mattis, sapien ut malesuada sodales, ante orci pharetra urna, eleifend urna eget sem <br />
                        tempus lorem erat a sapien. Morbi imperdiet eleifend urna eget sem "<br />
                    </div>
                </li>

                <li>
                    <div class="featured_wrap_message_textshow">
                        " Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent quam nunc, laoreet in eros a, sagittis <br />
                        suscipit tortor. Morbi vel ante sit amet ante faucibus posuere et ut tellus. Duis <br />
                        dapibus mauris varius arcu ornare tincidunt. Etiam quis enim urna "<br />
                    </div>
                </li>

                <li>
                    <div class="featured_wrap_message_textshow">
                        " Donec elementum mollis magna id aliquet. Etiam eleifend urna eget sem sagittis feugiat. Pellentesque<br />
                        mattis, sapien ut malesuada sodales, ante orci pharetra urna, eleifend urna eget sem <br />
                        tempus lorem erat a sapien. Morbi imperdiet eleifend urna eget sem "<br />
                    </div>
                </li>

                <li>
                    <div class="featured_wrap_message_textshow">
                        " Donec elementum mollis magna id aliquet. Etiam eleifend urna eget sem sagittis feugiat. Pellentesque<br />
                        mattis, sapien ut malesuada sodales, ante orci pharetra urna, eleifend urna eget sem <br />
                        tempus lorem erat a sapien. Morbi imperdiet eleifend urna eget sem "<br />
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!--Welcome Message Slider [ End ]    -->

<!--    Address Map [ Start ]   -->
<div id="home_contact_wrap">
    <div id="home_contact_block">
        <div id="home_contact_block_heading">We Are Here</div>
        <div id="home_contact_block_address">10, King St. Aalborg, Denmark 6AC 45D</div>
        <div id="home_contact_block_map">
            <iframe width="100%" height="100%" frameborder="0" style="border:0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d69486.19786718422!2d9.907760149999989!3d57.02682954999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x464933b25fdf3d0d%3A0x4eb1b46a2eec26c3!2sAalborg%2C+Denmark!5e0!3m2!1sbn!2sbd!4v1414567013412"></iframe>
        </div>
    </div>
</div>
<!--    Address Map [ End ]   -->

<!--    Restaurant Time Schedule [ Start ]   -->
<div id="home_pickup_delivery_wrap">
    <div id="home_pickup_delivery_block">
        <div id="home_pickup_section">
            <div class="home_pickup_delivery_heading">Pick Up / Dine In</div>
            <table class="home_pickup_delivery_show" cellpadding="0" cellspacing="0" border="0">
                <tr bgcolor="#eeeeee">
                    <td align="left">Saturday</td>
                    <td align="right">Closed</td>
                </tr>

                <tr bgcolor="#ffffff">
                    <td align="left">Sunday</td>
                    <td align="right">11:30 am - 9.00 pm</td>
                </tr>

                <tr bgcolor="#eeeeee">
                    <td align="left">Monday</td>
                    <td align="right">Closed</td>
                </tr>

                <tr bgcolor="#ffffff">
                    <td align="left">Tuesday</td>
                    <td align="right">11:30 am - 9.00 pm</td>
                </tr>

                <tr bgcolor="#eeeeee">
                    <td align="left">Wednesday</td>
                    <td align="right">Closed</td>
                </tr>

                <tr bgcolor="#ffffff">
                    <td align="left">Thursday</td>
                    <td align="right">11:30 am - 9.00 pm</td>
                </tr>

                <tr bgcolor="#eeeeee">
                    <td align="left">Friday</td>
                    <td align="right">Closed</td>
                </tr>
            </table>
        </div>
        <div id="home_delivery_section">
            <div class="home_pickup_delivery_heading">Delivery</div>
            <table class="home_pickup_delivery_show" cellpadding="0" cellspacing="0" border="0">
                <tr bgcolor="#eeeeee">
                    <td align="left">Saturday</td>
                    <td align="right">Closed</td>
                </tr>

                <tr bgcolor="#ffffff">
                    <td align="left">Sunday</td>
                    <td align="right">11:30 am - 9.00 pm</td>
                </tr>

                <tr bgcolor="#eeeeee">
                    <td align="left">Monday</td>
                    <td align="right">Closed</td>
                </tr>

                <tr bgcolor="#ffffff">
                    <td align="left">Tuesday</td>
                    <td align="right">11:30 am - 9.00 pm</td>
                </tr>

                <tr bgcolor="#eeeeee">
                    <td align="left">Wednesday</td>
                    <td align="right">Closed</td>
                </tr>

                <tr bgcolor="#ffffff">
                    <td align="left">Thursday</td>
                    <td align="right">11:30 am - 9.00 pm</td>
                </tr>

                <tr bgcolor="#eeeeee">
                    <td align="left">Friday</td>
                    <td align="right">Closed</td>
                </tr>
            </table>
        </div>
    </div>
</div>
<!--    Restaurant Time Schedule [ End ]   -->