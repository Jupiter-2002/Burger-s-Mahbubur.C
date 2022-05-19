<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if( isset($arrFormatedItemList) && count($arrFormatedItemList) ) {
    foreach( $arrFormatedItemList as $categoryId => $categoryObj ) {
        //////////////////////////////////////////////
        //          For Category [ START ]          //
        //  Category Details [ Start ]
        if( isset($categoryObj['categoryDetails']) ) {
            ?>
            <div class="menuheading" id="CatItmContainer_<?= $categoryObj['categoryDetails']['CatName']; ?>" ><?= $categoryObj['categoryDetails']['CatName']; ?></div>
            <div class="text_details"><?= $categoryObj['categoryDetails']['CatDesc']; ?></div>
            <?php
        }
        //  Category Details [ End ]

        //  Category Based Items Details [ Start ]
        if( isset($categoryObj['items']) ) {
            echo $this->load->view('item_list_executor', array('itemArray'=>$categoryObj['items']), true);
        }
        //  Category Based Items Details [ End ]
        //          For Category [ END ]            //
        //////////////////////////////////////////////

        //////////////////////////////////////////////////
        //          For Sub Category [ START ]          //
        if( isset($categoryObj['subCategoryDetails']) ) {
            foreach( $categoryObj['subCategoryDetails'] as $subCategoryIdx => $subCategoryObj ) {
                //  Sub Category Details [ Start ]
                ?>
                <div class="submenuheading" style="margin-top: 10px;"><?= $subCategoryObj['SubCatName']; ?></div>
                <div class="sub_menu_text_details"><?= $subCategoryObj['SubCatDesc']; ?></div>

                <?php
                if( isset( $subCategoryObj['items'] ) ) {
                    echo $this->load->view('item_list_executor', array('itemArray'=>$subCategoryObj['items']), true);   
                }
                //  Sub Category Details [ End ]
            }
        }
        //          For Sub Category [ END ]            //
        //////////////////////////////////////////////////
        ?>
        <div class="full_width_resitem_gap"></div>
        <?php
    }
}
?>