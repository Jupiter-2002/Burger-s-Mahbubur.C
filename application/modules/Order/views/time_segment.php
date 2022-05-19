<div class="text_headings">Timing Instructions</div>
<table border="0" cellspacing="0" cellpadding="0" class="payment-table">
    <tbody>
    <tr class="odd">
        <td width="40%" class="bdr-right bdr-bottom table-detail-font1">Date :</td>
        <td width="60%" class="bdr-bottom table-detail-font1"> <b><?= $currentDate;    ?></b></td>
    </tr>

    <tr class="even">
        <td width="40%" class="bdr-right bdr-bottom table-detail-font1">Time :</td>
        <td width="60%" class="bdr-bottom table-detail-font1"> <b><?= $currentTime;    ?></b></td>
    </tr>

    <?php
    if( isset($_SESSION['selectedOrderType']) && $_SESSION['selectedOrderType'] == 2 && isset($_SESSION['cartExtraDetails']['deliveryDetails']['DeliveryTime']) ) {
        ?>
        <tr class="odd">
            <td width="40%" class="bdr-right bdr-bottom table-detail-font1">Delivery Time :</td>
            <td width="60%" class="bdr-bottom table-detail-font1"> <b><?= $_SESSION['cartExtraDetails']['deliveryDetails']['DeliveryTime'];    ?> min</b></td>
        </tr>
        <?php
    }
    ?>

    <?php
    if( $FoodPrepTime != "00:00" ) {
        ?>
        <tr class="odd">
            <td width="40%" class="bdr-right bdr-bottom table-detail-font1">Food Preparation Time :</td>
            <td width="60%" class="bdr-bottom table-detail-font1"> <b><?= $FoodPrepTime;    ?></b></td>
        </tr>
        <?php
    }
    ?>

    <tr class="even">
        <td width="40%" class="bdr-right bdr-bottom table-detail-font1">
            <?php
            if( isset($_SESSION['selectedOrderType']) && $_SESSION['selectedOrderType'] == 1 ) {
                echo "Order Collection Time: ";
            }
            else if( isset($_SESSION['selectedOrderType']) && $_SESSION['selectedOrderType'] == 2 ) {
                echo "Order Delivery Time: ";
            }
            ?>
        </td>

        <td width="60%" class="bdr-bottom table-detail-font1">
            <select class="dropdown" name="orderExpectedTime" id="orderExpectedTime" >
                <?php
                foreach ( $arrAvailableTime as $time => $timeStr ) {
                    ?>
                    <option value="<?= $time;   ?>"><?= $timeStr;   ?></option>
                    <?php
                }
                ?>
            </select>
        </td>
    </tr>
    </tbody>
</table>