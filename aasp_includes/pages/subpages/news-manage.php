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
$server = new server;
$server->selectDB('webdb');
$result = mysql_query("SELECT * FROM news ORDER BY id DESC");
if(mysql_num_rows($result)==0)
{ 
echo "<span class='blue_text'>Ainda não foi publicado nenhuma notícia!</span>"; 
}
else { 
?>
<div class="box_right_title">Notícias &raquo; Gerenciar</div>
<table width="100%">
<tr>
    <th>ID</th>
    <th>Título</th>
    <th>Conteúdo</th>
    <th>Comentários</th>
    <th>Ações</th>
</tr>
<?php
while($row=mysql_fetch_assoc($result)) {
	$comments = mysql_query("SELECT COUNT(id) FROM news_comments WHERE newsid='".$row['id']."'");
	 echo '<tr class="center">
			   <td>'.$row['id'].'</td>
			   <td>'.$row['title'].'</td>
			   <td>'.strip_tags(substr($row['body'],0,25)).'...</td>
			   <td>'.mysql_result($comments,0).'</td>
			   <td> <a onclick="editNews('.$row['id'].')" href="#">Editar</a> &nbsp;  
			   <a onclick="deleteNews('.$row['id'].')" href="#">Deletar</a></td>
	 </tr>';
}
?></table><?php
}
 ?>    
