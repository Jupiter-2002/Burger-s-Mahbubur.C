<div class="inner_global_container" >
    <div class="inner_global_container">
        <div class="full_width_container text_justify overflow_auto" style="text-align: center">
            <br />Thank you for your order at <?= $_SESSION['RestaurantBasic']->RestName;  ?>.<br /><br />
            Please <a href="<?=    base_url()."customer/orderDetails/".$encodeOrderId;   ?>">CLICK HERE</a> to see the order details.
            <br /><br />
        </div>
    </div>
</div>