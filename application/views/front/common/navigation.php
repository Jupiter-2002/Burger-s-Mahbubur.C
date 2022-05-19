<?php
/**
 * Created by PhpStorm.
 * User: jahidulhaquerassel
 * Date: 2021-06-07
 * Time: 14:39
 */

//printArr($dataNavigation);
?>
<div id="nav_wrap">
    <div id="nav_block">
        <nav id="main-menu">
            <ul>
                <?php
                foreach ( $dataNavigation as $key => $value ) {
                    ?>
                    <li> <a href="<?= $value['URL']?>"><?= $value['Label']?></a></li>
                    <?php

                    //  For Checking '$dataNavigation' Last Element and NOT ADDING "|" in the last element [ START ]
                    end($dataNavigation);
                    if ( $key === key($dataNavigation) ) {
                        //  Do Nothing
                    }
                    else { ?>   <li>|</li>   <?php }
                    //  For Checking '$dataNavigation' Last Element and NOT ADDING "|" in the last element [ END ]
                }
            ?>
            </ul>
            <!--
            <ul>
                <li>
                    <a href="#">Home</a>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Vision &amp; Mission</a></li>
                        <li><a href="#">Play Your Part</a></li>
                        <li><a href="donate.html">Donate</a></li>
                    </ul>
                </li>
                <li>|</li>
                <li> <a href="#">Order Online</a></li>
                <li>|</li>
                <li> <a href="specialoffer.html">Special Offers</a></li>
                <li>|</li>
                <li> <a href="#">Business Hour</a></li>
                <li>|</li>
                <li> <a href="#">Contact</a></li>
                <li>|</li>
                <li> <a href="#">Login</a></li>
            </ul>
            -->
        </nav>
    </div>
</div>
