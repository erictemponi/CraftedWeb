<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
?>
<?php 
     $page = new page;
	 
	 $page->validatePageAccess('Shop');
	 
     if($page->validateSubPage() == TRUE) {
		 $page->outputSubPage();
	 } else {
		 $server->selectDB('webdb');
		 $inShop = mysql_query("SELECT COUNT(*) FROM shopitems");
		 $purchToday = mysql_query("SELECT COUNT(*) FROM shoplog WHERE date LIKE '%".date('Y-m-d')."%'");
		 $getAvg = mysql_query("SELECT AVG(*) AS priceAvg FROM shopitems");
		 $totalPurch = mysql_query("SELECT COUNT(*) FROM shoplog");
		 
		 //Note: The round() function will return 0 if no value is set :)
?>
<div class="box_right_title">Visão Geral da Loja</div>
<table style="width: 100%;">
<tr>
<td><span class='blue_text'>Itens na loja</span></td><td><?php echo round(mysql_result($inShop,0));?></td>
</tr>
<tr>
    <td><span class='blue_text'>As compras de hoje</span></td><td><?php echo round(mysql_result($purchToday,0)); ?></td>
    <td><span class='blue_text'>Total de compras</span></td><td><?php echo round(mysql_result($totalPurch,0)); ?></td>
</tr>
<tr>
    <td><span class='blue_text'>Custo médio dos itens</span></td><td><?php echo round(mysql_result($getAvg,0)); ?></td>
</tr>
</table>
<hr/>
<a href="?p=shop&s=add" class="content_hider">Add Itens</a>
<a href="?p=shop&s=manage" class="content_hider">Gerenciar Items</a>
<a href="?p=shop&s=tools" class="content_hider">Ferramentas</a>
<?php } ?>
