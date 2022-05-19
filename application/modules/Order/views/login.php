<div class="inner_global_container">
    <div class="innergrid4">
        <div class="text_headings">Log In :</div>

        <div class="full_width_container">
            <form action="<?php echo base_url() ?>customer/login#Login" class="form" method="post" >
                <div class="children-login">
                    <ul>
                        <?php
                        $failMsg = $this->session->flashdata('failMsg');
                        if( $failMsg ) { ?>
                            <li id="failMsg_Li" name="failMsg_Li" style="display: block">
                                <label> </label>
                                <span class="fields" id="failMsg" name="failMsg" style="color: red">
                                    <h3><?=   $failMsg;  ?></h3>
                                </span>
                            </li>
                            <?php
                        }

                        $field_validation_error = validation_errors();
                        if( isset($field_validation_error) && $field_validation_error!= "" ) {
                            ?>
                            <li>
                                <label>&nbsp;</label>
                                <span class="fields" style="color: red">
                                    <?php echo $field_validation_error;  ?>
                                </span>
                            </li>
                            <?php
                        }
                        ?>

                        <li>
                            <label for="CustEmailFrLogIn">Email :</label>
                            <span class="fields">
                                <input type="CustEmail" size="30" value="" class="email-input" id="CustEmailFrLogIn" name="CustEmailFrLogIn" required>
                            </span>
                        </li>
                        <li>
                            <label for="CustPassFrLogIn">Password :</label>
                            <span class="fields">
                                <input type="password" size="30" value="" class="email-input" id="CustPassFrLogIn" name="CustPassFrLogIn" required>
                            </span>
                        </li>
                        <li class="leftgapForOrder">
                            Forgot Password? <a href="#">Click here</a>
                        </li>
                        <li class="leftgapForOrder">
                            <input type="submit" name="BtnLogin" id="BtnLogin" value="Login" class="btn_login">
                        </li>
                    </ul>
                </div>
            </form>
        </div>

        <div class="full_width_container full_width_container_gap" name="Registration" id="Registration" >
            <div class="text_headings">Registration :</div>
            <div class="text_details"><b>Alternatively if you are not a member, please fill in the fields below.</b></div>

            <div class="form-area">
                <div class="inner_global_container" style="border: 3px solid #D7D7D7">
                    <form action="<?php echo base_url() ?>customer/registration#Registration" class="form" method="post" onsubmit="return validateRegistration()" >

                        <div class="children-login">
                            <ul style="padding-top: 0px">
                                <!--    Messaging Segment [ Start ]     -->
                                <?php
                                $successMsg = $this->session->flashdata('successMsg');
                                if( $successMsg ) { ?>
                                    <li id="successMsg_Li" name="successMsg_Li" style="display: none">
                                        <label> </label>
                                        <span class="fields" id="successMsg" name="successMsg" style="color: #00CC00">
                                            <h3><?=   $successMsg;  ?></h3>
                                        </span>
                                    </li>
                                    <?php
                                }
                                ?>
                                <li id="errorMsg_Li" name="errorMsg_Li" style="display: none">
                                    <label>&nbsp;</label>
                                    <span class="fields" id="errorMsg" name="errorMsg" style="color: #9C0900"></span>
                                </li>
                                <!--    Messaging Segment [ End ]     -->

                                <li>
                                    <label>&nbsp;</label>
                                    <span class="fields"><h3>Personal Information</h3></span>
                                </li>
                                <li>
                                    <label for="CustFirstName">First Name :</label>
                                    <span class="fields">
                                    <input type="text" size="30" value="<?= (isset($_POST['CustFirstName']) && $_POST['CustFirstName'] != '') ? $_POST['CustFirstName']:''; ?>" class="email-input onlyAlphabateWithSpace" id="CustFirstName" name="CustFirstName" required>

                                     <p id="Error_CustFirstName" name="Error_CustFirstName" style="color: red; display: none;"></p>
                                </span>
                                </li>
                                <li>
                                    <label for="CustLastName">Last Name :</label>
                                    <span class="fields">
                                    <input type="text" size="30" value="<?= (isset($_POST['CustLastName']) && $_POST['CustLastName'] != '') ? $_POST['CustLastName']:''; ?>" class="email-input onlyAlphabateWithSpace" id="CustLastName" name="CustLastName" required>

                                    <p id="Error_CustLastName" name="Error_CustLastName" style="color: red; display: none;"></p>
                                </span>
                                </li>
                                <li>
                                    <label for="CustEmail">E-Mail :</label>
                                    <span class="fields">
                                    <input type="email" size="30" value="<?= (isset($_POST['CustEmail']) && $_POST['CustEmail'] != '') ? $_POST['CustEmail']:''; ?>" class="email-input" id="CustEmail" name="CustEmail" required>

                                    <p id="Error_CustEmail" name="Error_CustEmail" style="color: red; display: none;"></p>
                                </span>
                                </li>
                                <li>
                                    <label for="CustPass">Password :</label>
                                    <span class="fields">
                                    <input type="password" size="30" value="<?= (isset($_POST['CustPass']) && $_POST['CustPass'] != '') ? $_POST['CustPass']:''; ?>" class="email-input noSpace" id="CustPass" name="CustPass" required>

                                    <p id="Error_CustPass" name="Error_CustPass" style="color: red; display: none;"></p>
                                </span>
                                </li>
                                <li>
                                    <label for="CustPassConfirm">Confirm Password :</label>
                                    <span class="fields">
                                    <input type="password" size="30" value="<?= (isset($_POST['CustPassConfirm']) && $_POST['CustPassConfirm'] != '') ? $_POST['CustPassConfirm']:''; ?>" class="email-input noSpace" id="CustPassConfirm" name="CustPassConfirm" required>

                                    <p id="Error_CustPassConfirm" name="Error_CustPassConfirm" style="color: red; display: none;"></p>
                                </span>
                                </li>
                            </ul>
                        </div>
                        <div class="global_gap10"></div>

                        <div class="children-login">
                            <ul style="padding-top: 0px">
                                <li>
                                    <label>&nbsp;</label>
                                    <span class="fields">
                                    <h3>Address Details</h3>
                                </span>
                                </li>
                                <li>
                                    <label for="CustContact">Contact Number :</label>
                                    <span class="fields">
                                    <input type="text" size="30" maxlength="30" value="<?= (isset($_POST['CustContact']) && $_POST['CustContact'] != '') ? $_POST['CustContact']:''; ?>" class="email-input" id="CustContact" name="CustContact" required>
                                </span>
                                </li>
                                <li>
                                    <label for="CustAddress1">Address 1 :</label>
                                    <span class="fields">
                                    <input type="text" size="30" value="<?= (isset($_POST['CustAddress1']) && $_POST['CustAddress1'] != '') ? $_POST['CustAddress1']:''; ?>" class="email-input onlyCharWithSpace" id="CustAddress1" name="CustAddress1" required>

                                    <p id="Error_CustAddress1" name="Error_CustAddress1" style="color: red; display: none;"></p>
                                </span>
                                </li>
                                <li>
                                    <label for="CustAddress2">Address 2 :</label>
                                    <span class="fields">
                                    <input type="text" size="30" value="<?= (isset($_POST['CustAddress2']) && $_POST['CustAddress2'] != '') ? $_POST['CustAddress2']:''; ?>" class="email-input onlyCharWithSpace" id="CustAddress2" name="CustAddress2" >

                                    <p id="Error_CustAddress2" name="Error_CustAddress2" style="color: red; display: none;"></p>
                                </span>
                                </li>
                                <li>
                                    <label for="CustCity">City :</label>
                                    <span class="fields">
                                    <input type="text" size="30" value="<?= (isset($_POST['CustCity']) && $_POST['CustCity'] != '') ? $_POST['CustCity']:''; ?>" class="email-input onlyAlphabateWithSpace" id="CustCity" name="CustCity" required>

                                    <p id="Error_CustCity" name="Error_CustCity" style="color: red; display: none;"></p>
                                </span>
                                </li>
                                <li>
                                    <label for="CityPostCode">Post Code :</label>
                                    <span class="fields">
                                    <input type="text" size="30" value="<?= (isset($_POST['CityPostCode']) && $_POST['CityPostCode'] != '') ? $_POST['CityPostCode']:''; ?>" class="email-input onlyCharWithSpace" id="CityPostCode" name="CityPostCode" required>

                                    <p id="Error_CityPostCode" name="Error_CityPostCode" style="color: red; display: none;"></p>
                                </span>
                                </li>

                                <li class="leftGapForOrder leftGapRegistrationForOrder" >
                                    <input type="submit" name="BtnRegistration" id="BtnRegistration" value="Register" class="btn_login">
                                </li>
                            </ul>
                        </div>
                        <div class="global_gap10"></div>

                    </form>
                </div>
            </div>
        </div>
    </div>



    <!--    CART SECTION [ START ]      -->
    <div class="innergrid3">
        <div id="cartLoad" class="mycart" style="padding-top: 0px; padding-bottom: 1px; position: static; top: 0px;">
        </div>
    </div>
    <!--    CART SECTION [ END ]      -->
</div>

<script type="text/javascript" src="<?php echo asset_url(); ?>js/Order/order.js"></script>

<script type="text/javascript">
    $(window).on('load', function() {
        loadOrderLoginPagecontent();
    });
</script>

<script type="text/javascript" src="<?php echo asset_url(); ?>js/Customer/customer.js"></script>
<script type="text/javascript" src="<?php echo asset_url(); ?>js/utility.js"></script>

<script type="text/javascript">
    //  This is to add different Validations based on HTML Class [assets/js/utility.js]
    addCustomeClassValidator();

    <?php
    if( isset($validationError) ) {
        ?>
        $(document).ready(function() {
            <?php
            foreach ( $validationError as $key => $value ) {
                ?>
                jQuery("#Error_<?= $key; ?>").html("<?=  $value; ?>");
                jQuery("#Error_<?= $key; ?>").show();
                jQuery("#<?= $key; ?>").attr('style', 'border-color: red !important');
                <?php
            }
            ?>
        });
        <?php
    }

    if( isset($errorMsg) ) {
        ?>
        $(document).ready(function() {
            jQuery("#errorMsg").html("<h3><?=  $errorMsg; ?></h3>");
            jQuery("#errorMsg_Li").show();
        });

        setTimeout( function() {
            jQuery("#errorMsg").html("");
            jQuery("#errorMsg_Li").hide("slow");
        },5000);
        <?php
    }
    else if( isset($successMsg) ) {
        ?>
        $(document).ready(function() {
            jQuery("#successMsg").html("<h3><?=  $successMsg; ?></h3>");
            jQuery("#successMsg_Li").show();

            clear_form_elements("Registration");     //  Clear All The Input Fields [ File Location: js/utility.js ]
        });
        <?php
    }
    ?>

</script>


