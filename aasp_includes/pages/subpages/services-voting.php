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
	$server = new server;
	$account = new account;
?> 
<div class="box_right_title">Links de Votação</div>
<table class="center">
<tr>
  <th>Título</th>
  <th>Pontos</th>
  <th>Imagem</th>
  <th>URL</th>
  <th>Ações</th></tr>
<?php
$server->selectDB('webdb');
$result = mysql_query("SELECT * FROM votingsites ORDER BY id ASC");
while($row = mysql_fetch_assoc($result)) { ?>
	     <tr>
              <td><?php echo $row['title']; ?></td>
              <td><?php echo $row['points']; ?></td>
              <td><img src="<?php echo $row['image']; ?>"></td>
              <td><?php echo $row['url']; ?></td>
              <td><a href="#" onclick="editVoteLink('<?php echo $row['id']; ?>','<?php echo $row['title']; ?>','<?php echo $row['points']; ?>',
              '<?php echo $row['image']; ?>','<?php echo $row['url']; ?>')">Editar</a> 
              <br/> 
              <a href="#" onclick="removeVoteLink('<?php echo $row['id']; ?>')">Remover</a><br />
              </td>   
          </tr>
  <?php 
  }
?>
</table>
<br/>
<a href="#" class="content_hider" onclick="addVoteLink()">Add um novo site de votação</a>