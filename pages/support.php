<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
#################
# Not finished. #
#################

?>
<div class='box_two_title'>Suporte</div>
<?php exit('Esta página nunca foi concluída.'); ?>
<table class='splashWebformLink'>
       <tr>
           <td>
           <a href="?p=support&do=email">
           <span class="splashWebformLogo"></span>
           <span class="webformText">E-mail de Suporte</span></a>
           </td>
           <td>
           <a href="?p=support&do=faq">
           <span class="splashWebformLogo"></span>
           <span class="webformText">FaQ</span></a>
           </td>
       </tr>
</table> 
<?php 
if (isset($_GET['do']) && $_GET['do']=="email")
	support::loadEmailForm();
?>      