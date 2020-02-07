<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
connect::selectDB('webdb');
if (!isset($_SESSION['cw_user'])) 
	$sql = "WHERE shownWhen = 'always' OR shownWhen = 'notlogged'"; 
else 
	$sql = "WHERE shownWhen = 'always' OR shownWhen = 'logged'";
			 		
 $getMenuLinks = mysql_query("SELECT * FROM site_links ".$sql." ORDER BY position ASC");
 if (mysql_num_rows($getMenuLinks)==0) 
 {
	 buildError("<b>Erro no Modelo:</b> Nenhum link do menu foi encontrado no Banco de Dados do Site!",NULL);
	 echo "<br/>Não foi encontrado nenhum link do menu!";
 }
		 
 while($row = mysql_fetch_assoc($getMenuLinks)) 
 {
	 $curr = substr($row['url'],3);
	 if ($_GET['p']==$curr)
			 echo '<li><a href="'.$row['url'].'" class="current">'.$row['title'].'</a></li>';
	 else
		 echo '<li><a href="'.$row['url'].'">'.$row['title'].'</a></li>';
 }