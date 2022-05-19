<div class="full_width_container">
    <div class="text_headings"><?= $leftPanelHeading;  ?></div>
</div>

<div class="innergrid3">
    <div class="full_width_container full_border padding10">
        <p>
            <b>Name :</b> <?= $custUserDetails->CustLastName.", ".$custUserDetails->CustFirstName ?> <br />
            <b>Email :</b> <?= $custUserDetails->CustEmail ?> <br />
            <b>Phone :</b> <?= $custUserDetails->CustContact ?> <br />
            <b>Registration Date :</b> <?= dateForDisplay( strtotime($custUserDetails->CustRegistrationDate) ) ?> <br />
            <b>Address :</b><br />
            <?php
            echo ($custUserDetails->CustAddress1) ? $custUserDetails->CustAddress1.",<br />" : "";
            echo ($custUserDetails->CustAddress2) ? $custUserDetails->CustAddress2.",<br />" : "";

            echo ($custUserDetails->CityPostCode) ? $custUserDetails->CityPostCode : "";
            echo ($custUserDetails->CustCity) ? ", ".$custUserDetails->CustCity : "";
            echo ($custUserDetails->CustTown) ? ", ". $custUserDetails->CustTown : "";
            ?>
        </p>
    </div>

    <div class="global_gap"></div>
</div>