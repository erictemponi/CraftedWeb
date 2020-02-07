<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
?>
<?php account::isNotLoggedIn(); ?>
<div class='box_two_title'>Convide um Amigo</div>
<b class='yellow_text'>O seu link de referência: </b> <div id="raf_box">
                  <?php echo $GLOBALS['website_domain']."?p=register&id=".account::getAccountID($_SESSION['cw_user']); ?>
</div><br/>
<h4 class='blue_text'>Como funciona?</h4>

É simples! Basta copiar o link acima e enviá-lo para seus amigos. Se eles criarem uma conta usando o seu link de referência, vocês poderam se aventurar em Azeroth com um ganho de experiência maior e muito mais!