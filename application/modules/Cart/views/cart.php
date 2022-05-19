<?php
//printArr($cartDetails);
?>
<div class="cartheading">
    <div class="cartheading_text">Your Order</div>
    <h2><a href="javascript:void(0)" onclick="openItemPopUp(1)" style="display: block; color: red;"><b>POP UP</b></a></h2>
</div>

<div class="cartdelpick">
    <ul>
        <?php
        //printArr($restauranOrderType);

        foreach( $restauranOrderType as $orderType ) {
            ?>
            <li>
                <span class="delpick">
                    <input type="radio" id="<?= $orderType->OrderTypeId; ?>" name="radioOrderType" 
                        <?= (isset($_SESSION['selectedOrderType']) && $_SESSION['selectedOrderType'] == $orderType->OrderTypeId) ? 'checked': ''; ?> 
                        <?= ($orderType->OrderTypeId == 2) ? 'onclick="loadOrderTypePopUp()"': ''; ?>
                        <?= ($orderType->OrderTypeId == 1) ? 'onclick="selectOrderType(1)"': ''; ?>
                    >
                        <?= $orderType->Name ?>
                </span>
            </li>
            <?php
        }
        ?>
    </ul>
</div>

<?php
if( isset($cartDetails) && is_array($cartDetails) ) {
    ?>
    <!--    Items List [ START ]    -->
    <div class="cartscroll">
        <?php
        if( isset($cartDetails['itemList']) && is_array($cartDetails['itemList']) ) { 
            //  foreach loop for 'itemList' idx
            foreach( $cartDetails['itemList'] as $catSortNo => $catObj ) {
                $catName = "";

                //  foreach loop for 'itemList->catSortNo' idx AND Category Details
                foreach( $catObj as $catObjDetailsKey => $catObjDetails ) {
                    if( $catObjDetailsKey == 'CatDetails' ) {
                        if( isset($catObjDetails['CatName']) && $catObjDetails['CatName'] != "" ) {
                            $catName = $catObjDetails['CatName'];
                        }
                    }
                    else {
                        $subCatName = "";
                        $subCatSortNo = $catObjDetailsKey;      //  In here '$catObjDetailsKey' is the '$subCatSortNo'

                        //  foreach loop for 'itemList->catSortNo->subCatSortNo' idx AND Sub Category Details
                        foreach( $catObjDetails as $subCatObjDetailsKey => $subCatObjDetails ) {  
                            if( $subCatObjDetailsKey == 'SubCatDetails' ) {
                                if( isset($subCatObjDetails['SubCatName']) && $subCatObjDetails['SubCatName'] != "" ) {
                                    $subCatName = $subCatObjDetails['SubCatName'];
                                }
                            }
                            else if( $subCatObjDetailsKey == 'ItemListDetails' ) {
                                foreach( $subCatObjDetails as $itemSortNo => $wholeItmObjDetails ) {
                                    //echo "<br/>itemSortNo: ".$itemSortNo."<br/>"; 
                                    //printArr($itmObjDetails); 

                                    foreach( $wholeItmObjDetails as $itmIdentificationKey => $itmObjDetails ) {  
                                        ?>
                                        <div class="cartitem">
                                            <ul>
                                                <li>
                                                    <span class="itemdesc">
                                                        <!--
                                                        <div class="itemdesc">
                                                            <?=   $catSortNo ."-".$subCatSortNo."-".$itemSortNo."-".$itmIdentificationKey."-".$itmObjDetails['itmQty'];    ?>
                                                        </div>
                                                        -->
    
                                                        <div class="itemcatdetails"><?=   $catName.( $subCatName ? " - ".$subCatName:"");    ?></div>
                                                        <div class="itemname"><?php
                                                            echo $itmObjDetails['itmDetails']['BaseName'];

                                                            //  For Selection
                                                            if( isset($itmObjDetails['itmDetails']['SelectionDetails']) && count($itmObjDetails['itmDetails']['SelectionDetails']) > 0 ) {
                                                                foreach ( $itmObjDetails['itmDetails']['SelectionDetails'] as $selectionObj ) {
                                                                    echo " [".$selectionObj->SelecName."]";
                                                                }
                                                            }
                                                            ?>
                                                        </div>

                                                        <?php
                                                        //  For Toppings
                                                        if( isset($itmObjDetails['itmDetails']['ToppingsDetails']) && count($itmObjDetails['itmDetails']['ToppingsDetails']) > 0 ) {
                                                            echo "<div class='itemdesc'>-";
                                                            foreach ( $itmObjDetails['itmDetails']['ToppingsDetails'] as $toppingObj ) {
                                                                echo " [".$toppingObj->ToppName."]";
                                                            }
                                                            echo "</div>";
                                                        }
                                                        ?>
    
                                                        <div class="itemqty">Quantity :
                                                            <span class="qtyred"><?php
                                                                echo $itmObjDetails['itmQty']." * ".number_formate($itmObjDetails['itmUnitPriceAfterDiscount']);
                                                            ?> </span>
                                                        </div>

                                                        <div class="itemcount">
                                                            <span class="plus"><a href="javascript:void(0)" onclick="cartItemIncrease( '<?= encodeVal($catSortNo) ?>', '<?= encodeVal($subCatSortNo) ?>', '<?= encodeVal($itemSortNo) ?>', '<?= encodeVal($itmIdentificationKey) ?>', '<?= encodeVal(1) ?>')">+</a></span>
                                                            <span class="minus"><a href="javascript:void(0)" onclick="cartItemDecrease( '<?= encodeVal($catSortNo) ?>', '<?= encodeVal($subCatSortNo) ?>', '<?= encodeVal($itemSortNo) ?>', '<?= encodeVal($itmIdentificationKey) ?>', '<?= encodeVal(1) ?>')">-</a></span>
                                                            <span class="reduce"><a href="javascript:void(0)" onclick="cartItemDecrease( '<?= encodeVal($catSortNo) ?>', '<?= encodeVal($subCatSortNo) ?>', '<?= encodeVal($itemSortNo) ?>', '<?= encodeVal($itmIdentificationKey) ?>', '<?= encodeVal($itmObjDetails['itmQty']) ?>')">x</a></span>




                                                            <?php
                                                            if( isset($itmObjDetails['itmComment']) && $itmObjDetails['itmComment'] != "" ) {
                                                                ?>
                                                                <span class="spanComments"><a href="#" data-toggle="tooltip" title="<?= $itmObjDetails['itmComment']; ?>"><b>@</b></a></span>
                                                                <?php
                                                            }
                                                            ?>


                                                        </div>
                                                    </span>
                                                    <span class="itemprice">
                                                        <div class="pricefont1"><?= $currency.number_formate($itmObjDetails['itmPrice']);    ?></div>
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <?php
                                    }
                                }

                                /*
                                $itemSortNo = $subCatObjDetailsKey;      //  In here '$subCatObjDetailsKey' is the '$itemSortNo'

                                //  foreach loop for 'itemList->catSortNo->subCatSortNo->itmSortNo' idx AND All the Item Details
                                foreach( $subCatObjDetails['ItemListDetails'] as $itmIdentificationKey => $itmObjDetails ) {  
                                    ?>
                                    <div class="cartitem">
                                        <ul>
                                            <li>
                                                <span class="itemdesc">
                                                    <!--
                                                    <div class="itemdesc">
                                                        <?=   $catSortNo ."-".$subCatSortNo."-".$itemSortNo."-".$itmIdentificationKey."-".$itmObjDetails['itmQty'];    ?>
                                                    </div>
                                                    -->

                                                    <div class="itemcatdetails"><?=   $catName.( $subCatName ? " - ".$subCatName:"");    ?></div>
                                                    <div class="itemname"><?php
                                                        echo $itmObjDetails['itmDetails']['BaseName']." [ Selection ]";
                                                        ?></div>

                                                    <div class="itemdesc">- ( Topping 1, Topping 2, Topping 3 )</div>

                                                    <div class="itemqty">Quantity :
                                                        <span class="qtyred"><?php
                                                            echo $itmObjDetails['itmQty']." * ".number_formate($itmObjDetails['itmUnitPriceAfterDiscount']);
                                                        ?> </span>
                                                    </div>
                                                    <div class="itemcount">
                                                        <span class="plus"><a href="javascript:void(0)" onclick="cartItemIncrease( '<?= encodeVal($catSortNo) ?>', '<?= encodeVal($subCatSortNo) ?>', '<?= encodeVal($itemSortNo) ?>', '<?= encodeVal($itmIdentificationKey) ?>', '<?= encodeVal(1) ?>')">+</a></span>
                                                        <span class="minus"><a href="javascript:void(0)" onclick="cartItemDecrease( '<?= encodeVal($catSortNo) ?>', '<?= encodeVal($subCatSortNo) ?>', '<?= encodeVal($itemSortNo) ?>', '<?= encodeVal($itmIdentificationKey) ?>', '<?= encodeVal(1) ?>')">-</a></span>
                                                        <span class="reduce"><a href="#">x</a></span>
                                                    </div>
                                                </span>
                                                <span class="itemprice">
                                                    <div class="pricefont1"><?= $currency.number_formate($itmObjDetails['itmPrice']);    ?></div>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                    <?php
                                }
                                */
                            }
                        }
                    }
                }
            }
        }
        ?>
    </div>
    <!--    Items List [ END ]    -->

    <?php
    $finalTotal = number_formate($cartDetails['itemTotal']);
    ?>

    <div class="calculation">
        <div class="caltext1">Total Item Price :</div>
        <div class="caltext2"><?=   $currency.number_formate($cartDetails['itemTotal']); ?></div>
    </div>

    <?php
    //  Delivery Fee [ Start ]
    if( selectedOrderType() == 2 && isset($deliveryDetails['DeliveryCharge']) ) {
        $finalTotal += number_formate($deliveryDetails['DeliveryCharge']);
        ?>
        <div class="calculation2">
            <div class="caltext3">Delivery Fee : </div>
            <div class="caltext4"><?=   $currency.number_formate($deliveryDetails['DeliveryCharge']); ?></div>
        </div>
        <?php
    }
    //  Delivery Fee [ End ]
    
    //  Discount [ Start ]
    if( isset($cartDetails['discountDetails']) && $cartDetails['discountDetails'] != false ) {
        $discountTotal = 0;
        foreach( $cartDetails['discountDetails'] as $discountDetails ) {
            $discountTotal += number_formate($discountDetails->amount);
            $finalTotal -= number_formate($discountDetails->amount);
            ?>
            <div class="calculation2">
                <div class="caltext3"><?=   $discountDetails->title; ?></div>
                <div class="caltext4"><?=   $currency.number_formate($discountDetails->amount); ?></div>
            </div>
            <?php
        }

        $_SESSION['cartDetails']['discountTotal'] = number_formate($discountTotal);
    }
    //  Discount [ End ]
    ?>

    <div class="calculation">
        <div class="caltext1">Total :</div>
        <div class="caltext2">
            <?= $currency.number_formate( ( $finalTotal > 0 ) ? $finalTotal : 0 ); ?>
            <?php $_SESSION['cartDetails']['totalWithoutCCFee'] = number_formate( ( $finalTotal > 0 ) ? $finalTotal : 0 ); ?>
        </div>
    </div>

    <?php
    if( $finalTotal < 0 ) {
        ?>
        <div class="calculation">
            <div class="caltext_full" style="color: red">
            Total can not be less then <?=  number_formate(0);   ?> 
            </div>
        </div>
        <?php
    }
    
    if( selectedOrderType() == 2 && isset($deliveryDetails['MinDeliveryAmount']) && $deliveryDetails['MinDeliveryAmount'] > 0 && $cartDetails['itemTotal'] < $deliveryDetails['MinDeliveryAmount'] ) {
        ?>
        <div class="calculation">
            <div class="caltext_full" style="color: red">
                Total item price needs to be more than <?= $currency.number_formate($deliveryDetails['MinDeliveryAmount']);    ?>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="checkoutarea">
            <div class="btncheckout">
                <a href="<?= base_url().'order'; ?>">Checkout</a>
            </div>
        </div>
        <?php
    }
} else {
    ?>
    <div class="cartNoItemContainer">
        Cart is empty
    </div>
    <?php
}
?>

<script type="text/javascript">
    (function(jQuery){
        jQuery('[data-toggle="tooltip"]').tooltip();
    })(jQuery360);
</script>

