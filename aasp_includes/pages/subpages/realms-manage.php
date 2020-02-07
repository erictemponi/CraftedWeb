<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
?>
<?php $page = new page; $server = new server;?>
<div class="box_right_title">Gerenciar Reinos</div>
<table class="center">
<tr><th>ID</th>
<th>Nome</th><th>Host</th>
<th>Porta</th>
<th>BD dos Personagens</th>
<th>Ações</th></tr>
<?php
    $server->selectDB('webdb');
	$result = mysql_query("SELECT * FROM realms ORDER BY id DESC");
	while($row = mysql_fetch_assoc($result)) { ?>
		  <tr>
              <td><?php echo $row['id']; ?></td>
              <td><?php echo $row['name']; ?></td>
              <td><?php echo $row['host']; ?></td>
              <td><?php echo $row['port']; ?></td>
              <td><?php echo $row['char_db']; ?></td>
              <td><a href="#" onclick="edit_realm(<?php echo $row['id']; ?>,'<?php echo $row['name']; ?>','<?php echo $row['host']; ?>',
              '<?php echo $row['port']; ?>','<?php echo $row['char_db']; ?>')">Editar</a> &nbsp; 
              <a href="#" onclick="delete_realm(<?php echo $row['id']; ?>,'<?php echo $row['name']; ?>')">Deletar</a><br/>
              <a href="#" onclick="edit_console(<?php echo $row['id']; ?>,'<?php echo $row['sendType']; ?>','<?php echo $row['rank_user']; ?>',
			  '<?php echo $row['rank_pass']; ?>')">Editar as Configurações do Console</a>
              </td>
          </tr>
	<?php }
?>
</table>