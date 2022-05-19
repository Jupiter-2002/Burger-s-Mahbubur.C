<div class="inner_global_container">
    <?php
    $this->load->view("common/leftPanel", $dataLeftPanel);
    $this->load->view("common/dashboardContent");
    ?>
</div>

<div class="global_gap10"></div>

<div class="inner_global_container">
    <div class="form-area">

        <?php
        //   For Address Form [ Start ]
        $isEditFlag = false;

        $CustAddLabel = "";
        $CustContact = "";
        $CustAddress1 = "";
        $CustAddress2 = "";
        $CustCity = "";
        $CityPostCode = "";
        //   For Address Form [ End ]
        ?>

        <!--        Address List [ START ]      -->
        <div class="form-left">
            <div class="element1">
                <div class="heading">Address List</div>
                <div class="content-area overflow_auto">

                    <table cellspacing="0" cellpadding="0" border="0" class="payment-table">
                        <tbody>
                        <tr>
                            <td bgcolor="#dddddd" class="bdr-right bdr-bottom "><b>Label</b></td>
                            <td bgcolor="#dddddd" class="bdr-right bdr-bottom "><b>Address</b></td>
                            <td bgcolor="#dddddd" class="bdr-right bdr-bottom "><b>Contact</b></td>
                            <td bgcolor="#dddddd" class="bdr-right bdr-bottom "><b>Action</b></td>
                        </tr>
                        <?php
                        foreach ( $arrCustAddressList as $key => $val ) {
                            if( isset($_GET['address']) && $_GET['address'] != "" && $_GET['address'] == md5($val->PK_CustAddId) ) {
                                $isEditFlag = true;

                                $CustAddLabel = $val->CustAddLabel;
                                $CustContact = $val->CustContact;
                                $CustAddress1 = $val->CustAddress1;
                                $CustAddress2 = $val->CustAddress2;
                                $CustCity = $val->CustCity;
                                $CityPostCode = $val->CityPostCode;
                            }
                            ?>
                            <tr class="odd">
                                <td class="bdr-right bdr-bottom"><b><?= $val->CustAddLabel; ?></b></td>
                                <td class="bdr-right bdr-bottom">
                                    <?php
                                    echo ($val->CustAddress1) ? $val->CustAddress1.",<br />" : "";
                                    echo ($val->CustAddress2) ? $val->CustAddress2.",<br />" : "";

                                    echo ($val->CityPostCode) ? $val->CityPostCode : "";
                                    echo ($val->CustCity) ? ", ".$val->CustCity : "";
                                    echo ($val->CustTown) ? ", ". $val->CustTown : "";
                                    ?>
                                </td>
                                <td class="bdr-right bdr-bottom"><?= $val->CustContact; ?></td>
                                <td class="bdr-bottom">
                                    <a href="<?= base_url() ?>customer/addressBook?address=<?= md5($val->PK_CustAddId) ?>" style="text-decoration:underline;">EDIT</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
        <!--        Address List [ END ]        -->







        <!--        Address Form [ START ]      -->
        <?php
        if( isset($_POST['CustAddLabel']) && $_POST['CustAddLabel'] != "") {
            $CustAddLabel = $_POST['CustAddLabel'];
        }

        if( isset($_POST['CustContact']) && $_POST['CustContact'] != "") {
            $CustContact = $_POST['CustContact'];
        }
        else if( $isEditFlag == false ) {
            $CustContact = $_SESSION['CustomerUserDetails']->CustContact;
        }

        if( isset($_POST['CustAddress1']) && $_POST['CustAddress1'] != "") {
            $CustAddress1 = $_POST['CustAddress1'];
        }

        if( isset($_POST['CustAddress2']) && $_POST['CustAddress2'] != "") {
            $CustAddress2 = $_POST['CustAddress2'];
        }

        if( isset($_POST['CustCity']) && $_POST['CustCity'] != "") {
            $CustCity = $_POST['CustCity'];
        }

        if( isset($_POST['CityPostCode']) && $_POST['CityPostCode'] != "") {
            $CityPostCode = $_POST['CityPostCode'];
        }

        ?>
        <div class="form-right" name="AddressForm" id="AddressForm">
            <form action="<?php echo base_url() ?>customer/addressBook<?= (isset($_GET['address']) && $_GET['address']!="") ? "?address=".$_GET['address']:""; ?>#AddressForm" class="form" method="post" >

                <div class="element1">
                    <div class="heading">Address Form</div>

                    <?php
                    $failMsg = $this->session->flashdata('failMsg');
                    if( $failMsg ) { ?>
                        <div class="content-area"><p style="text-align: center; font-weight: bold; color: red"><?= $failMsg; ?></p></div>
                        <?php
                    }
                    else {
                        $successMsg = $this->session->flashdata('successMsg');
                        if( $successMsg ) { ?>
                            <div class="content-area"><p style="text-align: center; font-weight: bold; color: darkgreen"><?= $successMsg; ?></p></div>
                            <?php
                        }
                    }
                    ?>

                    <div class="content-area">
                        <div class="left">
                            <div class="left-text">Label :<sup><span style="color:#FF0000; font-size:12px; font-size:10px;">*</span></sup></div>
                        </div>
                        <div class="right">
                            <div>
                                <input type="text" style="text-transform: uppercase;" onfocus="" name="CustAddLabel" id="CustAddLabel" class="input1 onlyCharWithSpace" value="<?= $CustAddLabel; ?>" required <?= ( $isEditFlag ) ? "readonly" : ""; ?>>
                                <p id="Error_CustAddLabel" name="Error_CustAddLabel" style="color: red; display: none;"></p>
                            </div>
                        </div>
                    </div>
                    <div class="content-area">
                        <div class="left">
                            <div class="left-text">Contact Number :<sup><span style="color:#FF0000; font-size:12px; font-size:10px;">*</span></sup></div>
                        </div>
                        <div class="right">
                            <div>
                                <input type="text" onfocus="" name="CustContact" id="CustContact" class="input1" value="<?= $CustContact; ?>" required>

                                <p id="Error_CustContact" name="Error_CustContact" style="color: red; display: none;"></p>
                            </div>
                        </div>
                    </div>
                    <div class="content-area">
                        <div class="left">
                            <div class="left-text">Address 1 :<sup><span style="color:#FF0000; font-size:12px; font-size:10px;">*</span></sup></div>
                        </div>
                        <div class="right">
                            <div>
                                <input type="text" onfocus="" name="CustAddress1" id="CustAddress1" class="input1 onlyCharWithSpace" value="<?= $CustAddress1; ?>" required>
                                <p id="Error_CustAddress1" name="Error_CustAddress1" style="color: red; display: none;"></p>
                            </div>
                        </div>
                    </div>
                    <div class="content-area">
                        <div class="left">
                            <div class="left-text">Address 2 :</div>
                        </div>
                        <div class="right">
                            <div>
                                <input type="text" onfocus="" name="CustAddress2" id="CustAddress2" class="input1 onlyCharWithSpace" value="<?= $CustAddress2; ?>">

                                <p id="Error_CustAddress2" name="Error_CustAddress2" style="color: red; display: none;"></p>
                            </div>
                        </div>
                    </div>
                    <div class="content-area">
                        <div class="left">
                            <div class="left-text">City :<sup><span style="color:#FF0000; font-size:12px; font-size:10px;">*</span></sup></div>
                        </div>
                        <div class="right">
                            <div>
                                <input type="text" onfocus="" name="CustCity" id="CustCity" class="input1 onlyAlphabateWithSpace" value="<?= $CustCity; ?>" required>

                                <p id="Error_CustCity" name="Error_CustCity" style="color: red; display: none;"></p>
                            </div>
                        </div>
                    </div>
                    <div class="content-area">
                        <div class="left">
                            <div class="left-text">Post Code :<sup><span style="color:#FF0000; font-size:12px; font-size:10px;">*</span></sup></div>
                        </div>
                        <div class="right">
                            <div>
                                <input type="text" style="text-transform: uppercase;" onfocus="" name="CityPostCode" id="CityPostCode" class="input1 onlyCharWithSpace" value="<?= $CityPostCode; ?>" required>
                                <p id="Error_CityPostCode" name="Error_CityPostCode" style="color: red; display: none;"></p>
                            </div>
                        </div>
                    </div>

                    <div class="content-area">
                        <div class="left">
                            <div class="left-text">&nbsp;</div>
                        </div>
                        <div class="right">
                            <div>
                                <input name="BtnAddress" id="BtnAddress" type="submit" value="<?= ($isEditFlag) ? "Update Address":"Add Address"; ?>" class="common-btn">
                                <?php
                                if( $isEditFlag ) {
                                    ?>
                                    <input name="BtnAddress" id="BtnAddress" type="button" value="CANCEL" class="cancle-btn" onclick="addressBookHome()">
                                    <?php
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
        <!--        Address Form [ END ]        -->

    </div>
</div>

<script type="text/javascript" src="<?php echo asset_url();?>js/utility.js"></script>

<script type="text/javascript">
    //  This is to add different Validations based on HTML Class [assets/js/utility.js]
    addCustomeClassValidator();
    
    function addressBookHome() {
        window.location.replace("<?php echo base_url() ?>customer/addressBook");
    }

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

    if( isset($successMsg) ) { ?>
        $(document).ready(function() {
            clear_form_elements("AddressForm");     //  Clear All The Input Fields [ File Location: js/utility.js ]

            jQuery("#CustContact").val("<?=  $_SESSION['CustomerUserDetails']->CustContact; ?>");
        });
        <?php
    }
    ?>
</script>