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
 	 $server->selectDB('webdb'); 
 	 $page = new page;
	 
	 $page->validatePageAccess('Users');
	 
     if($page->validateSubPage() == TRUE) {
		 $page->outputSubPage();
	 } else {
		 $server->selectDB('logondb');
		 $usersTotal = mysql_query("SELECT COUNT(*) FROM account");
		 $usersToday = mysql_query("SELECT COUNT(*) FROM account WHERE joindate LIKE '%".date("Y-m-d")."%'");
		 $usersMonth = mysql_query("SELECT COUNT(*) FROM account WHERE joindate LIKE '%".date("Y-m")."%'");
		 $usersOnline = mysql_query("SELECT COUNT(*) FROM account WHERE online=1");
		 $usersActive = mysql_query("SELECT COUNT(*) FROM account WHERE last_login LIKE '%".date("Y-m")."%'");
		 $usersActiveToday = mysql_query("SELECT COUNT(*) FROM account WHERE last_login LIKE '%".date("Y-m-d")."%'");	 
?>
<div class="box_right_title">Visão Geral dos Usuários</div>
<table style="width: 100%;">
<tr>
<td><span class='blue_text'>Total de usuários</span></td><td><?php echo round(mysql_result($usersTotal,0)); ?></td>
<td><span class='blue_text'>Novos usuários de hoje</span></td><td><?php echo round(mysql_result($usersToday,0)); ?></td>
</tr>
<tr>
    <td><span class='blue_text'>Novos usuários deste mês</span></td><td><?php echo round(mysql_result($usersMonth,0)); ?></td>
    <td>Usuários online</td><td><?php echo round(mysql_result($usersOnline,0)); ?></td>
</tr>
<tr>
    <td><span class='blue_text'>Usuários ativos (Este mês)</span></td><td><?php echo round(mysql_result($usersActive,0)); ?></td>
    <td>Usuários que logaram hoje</td><td><?php echo round(mysql_result($usersActiveToday,0)); ?></td>
</tr>
</table>
<hr/>
<a href="?p=users&s=manage" class="content_hider">Gerenciar usuários</a>
<?php } ?>
