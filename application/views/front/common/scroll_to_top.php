<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!--Scroll To Top-->
<script type="text/javascript">
    $(document).ready(function(){

        $(window).scroll(function(){
            if ($(this).scrollTop() > 100) {
                $('.typtipstotop').fadeIn();
            } else {
                $('.typtipstotop').fadeOut();
            }
        });

        $('.typtipstotop').click(function(){
            $("html, body").animate({ scrollTop: 0 }, 1000);
            return false;
        });

    });
</script>

<a href="#" class="typtipstotop"></a>
<!--Scroll To Top-->