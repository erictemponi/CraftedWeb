<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
?>
<?php $page = new page; 
$server = new server;
$account = new account;
?> 
<div class="box_right_title">Registros da Loja de Doação</div>
<?php $result = mysql_query("SELECT * FROM shoplog WHERE shop='donate' ORDER BY id DESC LIMIT 10 "); 
if(mysql_num_rows($result)==0) {
	echo "Parece que os registros da Loja de Doação estão vazios!";
} else {
?>
 <input type='text' value='Procurar...' id="logs_search" onkeyup="searchLog('donate')"><hr/>
<div id="logs_content">
<table width="100%">
        <tr>
          <th>Usuário</th>
          <th>Personagem</th>
          <th>Reino</th><th>Item</th>
          <th>Data</th></tr>
        <?php while($row = mysql_fetch_assoc($result)) { ?>
		<tr class="center">
            <td><?php echo $account->getAccName($row['account']); ?></td>
            <td><?php echo $account->getCharName($row['char_id'],$row['realm_id']); ?></td>
            <td><?php echo $server->getRealmName($row['realm_id']); ?></td>
            <td><a href="http://<?php echo $GLOBALS['tooltip_href']; ?>item=<?php echo $row['entry']; ?>" title="" target="_blank">
			<?php echo $server->getItemName($row['entry']); ?></a></td>
            <td><?php echo $row['date']; ?></td>
        </tr>	
		<?php } ?>
</table>
</div>
<?php } ?>