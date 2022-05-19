<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!--    Footer [ Start ]    -->
<div id="footer-wrap">
    <div id="footer-block">
        <div class="span1">
            <ul>
                <li><span class="heading"><?= $footerTitle; ?></span><li>
                <li>
                    <span class="normal"><?= $footerMessage; ?></span>
                </li>
            </ul>
        </div>

        <div class="span1">
            <ul>
                <li><span class="heading"><?= $addressTitle; ?></span><li>
                <li>
                    <span class="normal"><?= $addressText; ?></span>
                </li>
            </ul>
        </div>

        <div class="span1 gap">
            <ul>
                <li><span class="heading"><?= $socialTitle_1; ?></span><li>
                <li>
                    <span class="paymentimg"><img src="<?= $socialUrl_1; ?>" alt="" title="" /></span>
                </li>
            </ul>
        </div>

        <div class="span1 gap">
            <ul>
                <li><span class="heading"><?= $socialTitle_2; ?></span><li>
                <li>
                    <span class="paymentimg"><img src="<?= $socialUrl_2; ?>" alt="" title="" /></span>
                </li>
            </ul>
        </div>

        <div id="copyright-block">
            <p class="left"><?= $copyRightTxtLeft;  ?></p>
            <p class="right"><?= $copyRightTxtRight;  ?></p>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        // Add smooth scrolling to all links
        $("a").on('click', function(event) {

            // Make sure this.hash has a value before overriding default behavior
            if (this.hash !== "") {
                // Prevent default anchor click behavior
                event.preventDefault();

                // Store hash
                var hash = this.hash;

                // Using jQuery's animate() method to add smooth page scroll
                // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 800, function(){
                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                });
            } // End if
        });
    });
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script type="text/javascript">
    var jQuery360 = jQuery.noConflict(true);
</script>
<!--    Footer [ End ]    -->