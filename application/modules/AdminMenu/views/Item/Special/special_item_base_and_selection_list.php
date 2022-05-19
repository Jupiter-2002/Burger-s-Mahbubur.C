
<div class="widget" >

    <div class="title">
        <img src="http://localhost/new_rest_solo/assets/dist/images/icons/dark/frames.png" alt="" class="titleIcon">
        <h6 style="padding: 11px;">Selection List</h6>
    </div>

    <ul class="partners">
        <?php
        foreach ( $arrSpecialItemSelection as $objSpecialItemSelection ) {
            ?>
            <li style="border: 1px solid rgb(205, 205, 205); margin: 10px;">
                <div class="pInfo">
                    <a href="javascript:void(0)" title=""><strong>Selection Name: <?= $objSpecialItemSelection['SpecialItmSelectionName']; ?></strong></a>

                    <a href="#" title="" style="color: #00CC00"><strong>[ EDIT ]</strong></a>

                </div>
                <div class="clear"></div>
            </li>
            <?php
            if( isset($objSpecialItemSelection['SpecialItemBaseDetails']) && count($objSpecialItemSelection['SpecialItemBaseDetails']) > 0 ) {
                ?>
                <li>
                    <div class="pInfo">
                        <a href="javascript:void(0)" title=""><strong>Base Lists</strong></a>
                    </div>
                    <div class="clear"></div>
                    <div class="widget" style="margin-top: 10px;">
                        <table class="sTable" width="100%" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <td class="sortCol"><div><b>Base Name</b></div></td>
                                <td class="sortCol"><div><b>Price</b></div></td>
                                <td class="sortCol"><div><b>Action</b></div></td>
                            </tr>
                        </thead>
                        <tbody>



                        <?php
                        foreach ( $objSpecialItemSelection['SpecialItemBaseDetails'] as $objSpecialItemBaseDetails ) {
                            ?>
                            <tr style="color: green">
                                <td><?= $objSpecialItemBaseDetails['BaseName']; ?></td>
                                <td><?= number_formate($objSpecialItemBaseDetails['BasePrice']); ?></td>
                                <td>
                                    <a href="javascript:void(0);" class="tipS" original-title="Update" title="TOPPING LIST" onclick="loadBaseSelectionToppingList(9, 1, true)">
                                        <img src="http://localhost/new_rest_solo/assets/dist/images/icons/dark/files.png" alt="">
                                    </a>
                                    <a href="javascript:void(0);" class="tipS" original-title="Update" title="TOPPING ADD/EDIT" onclick="loadSelectionToppingBaseForm(9, 1)">
                                        <img src="http://localhost/new_rest_solo/assets/dist/images/icons/dark/settings.png" alt="">
                                    </a>
                                </td>
                            </tr>
                            <!--    For Base Selection [ Start ]    -->


                            <!--    For Base Selection [ Start ]    -->
                            <?php
                            if( isset($objSpecialItemBaseDetails['SpecialItemBaseSelectionDetails']) && count($objSpecialItemBaseDetails['SpecialItemBaseSelectionDetails']) > 0 ) {
                                ?>
                                <tr>
                                    <td colspan="3">
                                    <div class="form widget" style="min-height: 50px; margin-top: 10px; border-color: blue">
                                    <ul>
                                        <li style="padding: 0px;">
                                            <!--
                                            <div class="pInfo">
                                                <a href="javascript:void(0)" title=""><strong>Selection Category: ItmSelCat 1</strong></a>
                                            </div>
                                            -->
                                            <div class="clear"></div>
                                            <table class="sTable" width="100%" cellspacing="0" cellpadding="0">
                                                <thead>
                                                <tr>
                                                    <td class="sortCol"><div><b>Selection Category</b></div></td>
                                                    <td class="sortCol"><div><b>Selection Name</b></div></td>
                                                    <td class="sortCol"><div><b>Price</b></div></td>
                                                    <td class="sortCol"><div><b>Action</b></div></td>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                    <?php
                                                    foreach ( $objSpecialItemBaseDetails['SpecialItemBaseSelectionDetails'] as $objSpecialItemBaseSelectionDetails ) {
                                                        ?>
                                                        <tr>
                                                            <td><?=     $objSpecialItemBaseSelectionDetails['SelecCatName']     ?></td>
                                                            <td><?=     $objSpecialItemBaseSelectionDetails['SelecName']     ?></td>
                                                            <td><?=     number_formate($objSpecialItemBaseSelectionDetails['BaseSelectionPrice'])     ?></td>
                                                            <td>
                                                                <a href="javascript:void(0);" class="tipS" original-title="Update" title="TOPPING LIST" onclick="loadBaseSelectionToppingList(9, 1, true)">
                                                                    <img src="http://localhost/new_rest_solo/assets/dist/images/icons/dark/files.png" alt="">
                                                                </a>
                                                                <a href="javascript:void(0);" class="tipS" original-title="Update" title="TOPPING ADD/EDIT" onclick="loadSelectionToppingBaseForm(9, 1)">
                                                                    <img src="http://localhost/new_rest_solo/assets/dist/images/icons/dark/settings.png" alt="">
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    } ?>

                                                </tbody>

                                            </table>
                                        </li>
                                    </ul>
                                    </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <!--    For Base Selection [ End ]    -->
                            <?php
                        }
                        ?>



                        </tbody>
                        </table>
                    </div>
                </li>

                <?php
            }
        }
        ?>
    </ul>
</div>
