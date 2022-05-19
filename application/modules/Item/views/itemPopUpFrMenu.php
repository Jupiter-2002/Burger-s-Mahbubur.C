<?php
//printArr($arrSelecList);
?>

<div  class="popupshow">
    <div class="seperate_div">

        <form name="itemPopUpForm" id="itemPopUpForm">

        <!--    Item Basic [ START ]    -->
        <div class="popup_heading">
            <?= $arrBaseItemDetails[0]->BaseName;  ?>
            <span class="float_right">
                Price: <?= $currency ?>
                <span id="PopUpUnitPrice" name="PopUpUnitPrice"><?=$arrBaseItemDetails[0]->BasePrice;  ?></span>
            </span>
        </div>

        <div class="popup_commontext">Temporary Text</div>

        <div class="global_gap10"></div>

        <div class="popup_heading_2">Description :</div>

        <div class="popup_commontext"><?= $arrBaseItemDetails[0]->BaseDesc;  ?></div>

        <div class="global_gap10"></div>
        <!--    Item Basic [ END ]    -->

        <!--    Base Item Selection [ START ]    -->
        <?php
        if( isset($arrSelecList) && count($arrSelecList) > 0 ) {
            foreach ( $arrSelecList as $keySelectionCat => $objSelectionCat ) {
                $currentSelecCatId = "";
                $currentSelecCatName = "";
                foreach ( $objSelectionCat as $keySelection => $objSelection ) {
                    if( isset($objSelection['SelecCatName']) && $currentSelecCatName != $objSelection['SelecCatName'] ) {
                        $currentSelecCatId = $objSelection['SelecCatId'];
                        $currentSelecCatName = $objSelection['SelecCatName'];
                    }

                    if( $keySelection == "SelecCatDetails" ) {
                        ?>
                        <div class="popup_heading_2">Selection Category: <?= $currentSelecCatName ?></div>
                        <?php
                    }
                    else if( $keySelection == "SelectionDetails" ) {
                        if( count($objSelection) > 0 ) {
                            ?>
                            <div class="popup_commontext">
                                <select id="Base_Selec[<?= $currentSelecCatId; ?>]" name="Base_Selec[<?= $currentSelecCatId; ?>]" class="selection_dropdown popup_input" >
                                    <option value="">Select <?= $currentSelecCatName ?></option>
                                    <?php
                                    foreach ( $objSelection as $keySelec => $objSelec ) {
                                        ?>
                                        <option value="<?= $objSelec['PK_J_SelecToElementID'];    ?>"><?= $objSelec['SelecName']." - ".$currency." ".$objSelec['J_SelecPrice'];    ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="global_gap10"></div>


                            <!--    Selection to Toppings [ START ]    -->
                            <div id="Div_Base_Sele_Topp_<?= $currentSelecCatId; ?>" name="Div_Base_Sele_Topp_<?= $currentSelecCatId; ?>" style="display: none" >
                                <div class="popupspan_100">
                                    <div class="popupmenu">
                                        <div class="popupmenu_span25">
                                            <span class="popcheckbox_radio"><input type="checkbox" /></span>
                                            <span class="poptext">Tmp Topping 1</span>
                                            <span class="poptext2">Tk 100.00</span>
                                        </div>

                                        <div class="popupmenu_span25">
                                            <span class="popcheckbox_radio"><input type="checkbox" /></span>
                                            <span class="poptext">Tmp Topping 2</span>
                                            <span class="poptext2">Tk 200.00</span>
                                        </div>

                                        <div class="popupmenu_span25">
                                            <span class="popcheckbox_radio"><input type="checkbox" /></span>
                                            <span class="poptext">Tmp Topping 3</span>
                                            <span class="poptext2">Tk 300.00</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="global_gap10"></div>
                            </div>
                            <!--    Selection to Toppings [ END ]    -->
                            <?php
                        }
                    }
                }
            }
        }
        ?>
        <!--    Base Item Selection [ END ]    -->

        <!--    Base Item Topping [ START ]    -->
        <?php
        if( isset($arrToppList) ) {
            ?>
            <div class="popup_heading_2 dashed">
                <span>Base Topping Section</span>
            </div>
            <?php
            //printArr($arrToppList);
            foreach ( $arrToppList as $keyWholeToppCat => $objWholeToppCat ) {
                $currentToppCatId = "";
                $currentToppCatName = "";

                foreach ( $objWholeToppCat as $keyToppingCat => $objToppingCat ) {
                    if (isset($objToppingCat['ToppCatName']) && $currentToppCatName != $objToppingCat['ToppCatName']) {
                        $currentToppCatId = $objToppingCat['ToppCatId'];
                        $currentToppCatName = $objToppingCat['ToppCatName'];
                    }

                    if( $keyToppingCat == "ToppCatDetails" ) {
                        ?>
                        <div class="popup_heading_2">Topping Category: <?= $currentToppCatName ?></div>
                        <?php
                    }
                    else if( $keyToppingCat == "ToppDetails" ) {
                        if( count($objToppingCat) > 0 ) {
                            ?>
                            <div class="popupspan_100">
                                <div class="popupmenu">
                                    <?php
                                    foreach ( $objToppingCat as $keyTopping => $objTopping ) {
                                        ?>
                                        <div class="popupmenu_span25">
                                            <span class="popcheckbox_radio">
                                                <input name="Base_Topping[<?= $currentToppCatId ?>][<?= $objTopping['PK_J_ToppintToElementID'] ?>]" id="Base_Topping[<?= $currentToppCatId ?>][<?= $objTopping['PK_J_ToppintToElementID'] ?>]" type="checkbox" <?= ($objTopping['J_ToppDefaultFlag']) ? " checked  onclick='return false;'":""; ?> />
                                            </span>
                                            <span class="poptext">
                                                <?php
                                                echo $objTopping['ToppName'];
                                                echo ($objTopping['J_ToppFreeFlag']) ? " [FREE]":"";
                                                ?>
                                            </span>
                                            <span class="poptext2"><?= $currency." ".$objTopping['J_ToppPrice'] ?></span>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="global_gap10"></div>
                            <?php
                        }
                    }
                }
            }
        }
        ?>
        <!--    Base Item Topping [ END ]    -->










        <!--    Item Quantity [ START ]    -->
        <div class="popupspan_100">
            <div class="popup_quantity">
                <span class="popup_quantitytext">Quantity :</span>
                <span class="popup_plus"><img src="<?= asset_url() ?>front_dist/images/popump-plus.jpg" alt="" title="" style="height: 23px" /></span>
                <span class="popup_quantity_amount">
                    <input type="text" name="PopUpQty" id="PopUpQty" value="1" class="onlyNumberClass" />
                </span>
                <span class="popup_minus"><img src="<?= asset_url() ?>front_dist/images/popump-minus.jpg" alt="" title="" style="height: 23px" /></span>
            </div>
        </div>

        <div class="global_gap10"></div>
        <!--    Item Quantity [ END ]    -->

        <!--    Item Comments [ START ]    -->
        <div class="popupspan_100">
            <div class="popupspan_100">
                <div class="global_gap"></div>
                <textarea name="PopUpComment" id="PopUpComment" class="popup_textarea" placeholder="Item Comment......."></textarea>
            </div>
        </div>

        <div class="global_gap10"></div>
        <!--    Item Comments [ END ]    -->















        <!--    Item Total Amount [ START ]    -->
        <div class="popupspan_100">
            <div class="popup_quantity">
                <span class="popup_quantitytext">
                    Total Amount: <?= $currency ?>
                    <span class="ash" id="PopUpTotalPrice" name="PopUpTotalPrice"><?=$arrBaseItemDetails[0]->BasePrice;  ?></span>
                </span>
            </div>
        </div>

        <div class="global_gap10"></div>
        <!--    Item Total Amount [ END ]    -->

        <div class="popupspan_100">
            <input type="button" class="common-btn" value="Add" onclick="addToCartPopUp(<?= $arrBaseItemDetails[0]->PK_BaseId;  ?>)"/>
            <input type="button" class="common-btn" value="Close" onclick="colorBoxClose()"/>
        </div>


        </form>

    </div>
</div>

<script type="text/javascript">
    //  This is to add different Validations based on HTML Class [assets/js/utility.js]
    addCustomeClassValidator();
</script>