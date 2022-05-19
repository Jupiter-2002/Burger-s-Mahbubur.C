<div class="restaurant-odd" >
<ul>
    <li>
        <span class="itemimg"><a href="#"><img src="http://localhost/new_rest_solo/assets/front_dist/images/item1.jpg" alt="" title=""></a></span>

        <span class="itemfulldescription">
            <span class="itemname" style="color: red;">
                POP UP ITEM
                
                <img src="http://localhost/new_rest_solo/assets/front_dist/images/midium-hot.png" alt="" title="Medium Hot">
                POP UP ITEM
            </span>

            <span class="itemprice">$3.00</span>

            <!--    //  For Dynamic Design      -->
            <span class="itemaddtocart"><a href="javascript:void(0)" class="inline" onclick="openStaticItemPopUp()" >#</a></span>

            <span class="itemdescription">POP UP ITEM</span>
        </span>
    </li>
</ul>
</div>

<?php
$idx = 0;
foreach( $itemArray as $baseItmId => $baseItmObj ) {
    ?>
    <div class="restaurant-<?= ($idx%2) ? "even": "odd"; ?>" >
    <ul>
        <li>
            <span class="itemimg"><a href="#"><img src="<?= asset_url() ?>front_dist/images/item1.jpg" alt="" title=""></a></span>

            
            <span class="itemfulldescription">
                <span class="itemname">
                    <?=  ( isset($baseItmObj['BaseNo']) && $baseItmObj['BaseNo'] != "") ? $baseItmObj['BaseNo']."." : "";   ?><?=  $baseItmObj['BaseName'];   ?>&nbsp;&nbsp;
                    
                    <img src="<?= asset_url() ?>front_dist/images/midium-hot.png" alt="" title="Medium Hot">
                    [<?= get_global_values('BaseHotLevelArr', $baseItmObj['BaseHotLevel']) ?>]
                </span>

                <span class="itemprice"><?= $currency.number_formate($baseItmObj['BasePrice']); ?></span>
                
                <!--    //  For Static Design
                <span class="itemaddtocart"><a class="inline cboxElement" href="#newDivValue">+</a></span> 
                -->
                <!--    //  For Dynamic Design      -->
                <?php
                $addItemFunction = "openItemPopUp(".$baseItmObj['PK_BaseId'].")";
                if( $baseItmObj['BaseType'] == 1 ) {
                    //  Normal Item
                    $addItemFunction = "addToCart(".$baseItmObj['PK_BaseId'].", '".urlencode( encodeVal(1) )."')";
                }
                ?>
                <span class="itemaddtocart"><a href="javascript:void(0)" class="inline" onclick="<?= $addItemFunction ?>">+</a></span>

                <span class="itemdescription"><?= $baseItmObj['BaseDesc'] ?></span>
                <!--
                <select class="select">
                    <option>Select an option</option>
                    <option>Small</option>
                    <option>Medium</option>
                    <option>Large</option>
                    <option>Extra Large</option>
                </select>
                -->
            </span>
        </li>
    </ul>
    </div>
    <?php
    $idx++;
}
?>