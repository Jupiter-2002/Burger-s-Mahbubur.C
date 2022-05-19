<div class="inner_global_container" >
    <?php
    $this->load->view("front/common/leftPanel");
    ?>

    <div class="innergrid5">
        <!--        Opening Time [ START ]      -->
        <?php
        if( $arrTimeScheduleOpening != false ) { ?>
            <div class="text_headings">Opening Time</div>
            <!--    <div class="text_details">If you have questions or are unsure about anything, please feel free to contact us. We stand ready did try to help!</div>     -->

            <div class="full_width_container" style="padding-bottom: 10px;">
                <div class="client-dashboard overflow_auto">
                    <ul>
                        <table border="0" cellspacing="0" cellpadding="0" class="payment-table">
                            <?php
                            foreach ( $arrTimeScheduleOpening as $key => $value ) {
                                ?>
                                <tr class="<?= ( $key % 2 == 0 ) ? "odd" : "even" ?>">
                                    <td width="30%"><?= $value->Day ?> : </td>
                                    <td><?= ( $value->CloseFlag == 1 ) ? "CLOSED" : $value->tim_slot_text; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </ul>
                </div>
            </div>
            <?php
        }
        ?>
        <!--        Opening Time [ END ]        -->

        <!--        Collection Time [ START ]      -->
        <?php
        if( $arrTimeScheduleCollection != false ) { ?>
            <div class="text_headings">Collection Time</div>
            <!--    <div class="text_details">If you have questions or are unsure about anything, please feel free to contact us. We stand ready did try to help!</div>     -->

            <div class="full_width_container" style="padding-bottom: 10px;">
                <div class="client-dashboard overflow_auto">
                    <ul>
                        <table border="0" cellspacing="0" cellpadding="0" class="payment-table">
                            <?php
                            foreach ( $arrTimeScheduleCollection as $key => $value ) {
                                ?>
                                <tr class="<?= ( $key % 2 == 0 ) ? "odd" : "even" ?>">
                                    <td width="30%"><?= $value->Day ?> : </td>
                                    <td><?= ( $value->CloseFlag == 1 ) ? "CLOSED" : $value->tim_slot_text; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </ul>
                </div>
            </div>
            <?php
        }
        ?>
        <!--        Collection Time [ END ]       -->

        <!--        Delivery Time [ START ]      -->
        <?php
        if( $arrTimeScheduleDelivery != false ) { ?>
            <div class="text_headings">Delivery Time</div>
            <!--    <div class="text_details">If you have questions or are unsure about anything, please feel free to contact us. We stand ready did try to help!</div>     -->

            <div class="full_width_container" style="padding-bottom: 10px;">
                <div class="client-dashboard overflow_auto">
                    <ul>
                        <table border="0" cellspacing="0" cellpadding="0" class="payment-table">
                            <?php
                            foreach ( $arrTimeScheduleDelivery as $key => $value ) {
                                ?>
                                <tr class="<?= ( $key % 2 == 0 ) ? "odd" : "even" ?>">
                                    <td width="30%"><?= $value->Day ?>: </td>
                                    <td><?= ( $value->CloseFlag == 1 ) ? "CLOSED" : $value->tim_slot_text; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </ul>
                </div>
            </div>
            <?php
        }
        ?>
        <!--        Delivery Time [ END ]        -->

    </div>
</div>

