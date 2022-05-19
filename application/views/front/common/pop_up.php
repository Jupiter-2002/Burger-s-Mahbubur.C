<!--    Common Pop Up Container [ Start ]   -->
<div style="display:none">
    <div class="popupouter" id="commonPopUpContainer"
    </div>
</div>
<!--    Common Pop Up Container [ End ]   -->

<link rel="stylesheet" href="<?php echo asset_url();?>front_dist/colorbox/colorbox.css" />
<script src="<?php echo asset_url();?>front_dist/colorbox/jquery.colorbox.js"></script>
<script>
    $.colorbox.settings.onLoad = function() {
        //$('#cboxClose').remove();
        colorboxResize(true);
    }

    //Customize colorbox dimensions
    var colorboxResize = function(resize) {
        var width = "90%";
        //var height = "90%";

        if($(window).width() < 1000) { width = "90%"; }
        else {  width = "50%"; }

        $.colorbox.settings.width = width;

        //if window is resized while lightbox open
        if(resize) {
            $.colorbox.resize({
                //'height': height,
                'width': width
            });
        }
    }

    //In case of window being resized
    $(window).resize(function() {
        colorboxResize(true);
    });

    function colorBoxClose() {
        $.colorbox.close()
    }

    if( $("#cboxClose").length ) {
        $('#cboxClose').onclick(function () {
            colorBoxClose();
        })
    }
</script>
<!--Color Box-->