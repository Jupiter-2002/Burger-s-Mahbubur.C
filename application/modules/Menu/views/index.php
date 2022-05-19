<?php
//printArr($_SESSION);
?>

<div class="inner_global_container" style="transform: none; min-height: 300px;">
    <!--    Category and Item Section [ START ]     -->
    <div class="innergrid4" style="transform: none;">
        <div class="full_width_container" style="transform: none;">
            <!--    Category Section [ START ]  -->
            <div class="innergrid1" style="position: relative; min-height: 0px;">
                <div id="categoryList" class="theiaStickySidebar" style="padding-top: 0px; padding-bottom: 1px; position: static; top: 0px;">

                </div>
            </div>
            <!--    Category Section [ END ]  -->

            <!--    Item Section [ START ]  -->
            <div class="innergrid2">
                <div id="content">
                    <div id="itemList" class="showmenu">

                    </div>
                </div>
            </div>
            <!--    Item Section [ END ]  -->
        </div>
    </div>
    <!--    Category and Item Section [ END ]     -->

    <!--    Cart Section [ START ]  -->
    <div class="innergrid3" style="position: relative; min-height: 0px;">
        <div id="cartLoad" class="mycart theiaStickySidebar" style="padding-top: 0px; padding-bottom: 1px; position: static; top: 0px;">
        </div>
    </div>
    <!--    Cart Section [ END ]  -->
</div>

<!--    Added For Menu Page     -->
<!--Sticky Sidebar-->
<script type="text/javascript" src="<?php echo asset_url();?>front_dist/sticky-sidebar/theia-sticky-sidebar.js"></script>
<script type="text/javascript">
    //mycart in rightbar
    $(document).ready(function() {
        $('.innergrid3')
            .theiaStickySidebar({
                additionalMarginTop: 0
            });
    });

    //showcuisine in leftbar
    $(document).ready(function() {
        $('.innergrid1')
            .theiaStickySidebar({
                additionalMarginTop: 0
            });
    });
</script>
<!--Sticky Sidebar-->


<!------------------------------------>
<!--    POP UP SEGMENT [ START ]    -->
<?php
//  For Common Pop Up
$this->load->view('front/common/pop_up_static');

//  For Common Pop Up
$this->load->view('front/common/pop_up', $dataHeader);

//  Checking if 'OrderType' is selected or not, if not selected OPEN ORDER TYPE SELECTION POP-UP
if( !isset($_SESSION['selectedOrderType']) || $_SESSION['selectedOrderType'] == "" || $_SESSION['selectedOrderType'] == 0 ) {
    ?>
    <script type="text/javascript">
        $(window).on('load', function() {
            loadOrderTypePopUp()
        });
    </script>
    <?php
}
?>

<!--    Order Type POP UP [ START ]     -->
<div style="display:none">
    <div id="OrderTypePopUpContain" class="popupouter">
        <div class="popupshow">
            <div class="seperate_div">
                <div class="popup_heading">Order Type</span></div>

                <div id="DivMessageSelectOrderType" name="DivMessageSelectOrderType" style="display: block;" >
                    <div class="global_gap10"></div>
                    <div class="popup_heading_2" id="MessageSelectOrderType" name="MessageSelectOrderType" ></div>
                    <div class="global_gap10"></div>
                </div>

                <div class="popup_heading_2">Description :</div>

                <div class="popup_commontext">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                </div>

                <div class="global_gap10"></div>

                <div class="popupspan_100">
                    <div class="popupspan_100">
                        <div class="popupmenu">
                            <div class="popupmenu_span25">
                                <input type="text" style="text-transform: uppercase" id="popUpDeliveryPostCode" name="popUpDeliveryPostCode" class="popup_input">
                            </div>

                            <div class="popupmenu_span25">
                                <input type="button" class="common-sml-btn" onclick="selectOrderType(2)" value="Delivery" />
                                <input type="button" class="common-sml-btn" onclick="selectOrderType(1)" value="Collection" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="global_gap10"></div>
            </div>
        </div>
    </div>
</div>
<!--    Order Type POP UP [ END ]       -->

<!--      POP UP SEGMENT [ END ]    -->
<!------------------------------------>


<!--    Main Page JS [ START ]      -->
<script type="text/javascript" src="<?php echo asset_url();?>js/Menu/menu.js"></script>

<script type="text/javascript">
   $(window).on('load', function() {
        loadPagecontent();
    });
</script>
<!--    Main Page JS [ END ]      -->