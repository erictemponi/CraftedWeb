<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
define('INIT_SITE', TRUE);
include('../../includes/misc/headers.php');
include('../../includes/configuration.php');
include('../functions.php');
$server = new server;
$account = new account;

$server->selectDB('webdb');

###############################
if($_POST['function']=='post') 
{
	if(empty($_POST['title']) || empty($_POST['author']) || empty($_POST['content']))
		die('<span class="red_text">Por favor, insira todos os campos.</span>');

	mysql_query("INSERT INTO news (title,body,author,image,date) VALUES
	('".mysql_real_escape_string($_POST['title'])."','".mysql_real_escape_string(trim(htmlentities($_POST['content'])))."',
	'".mysql_real_escape_string($_POST['author'])."','".mysql_real_escape_string($_POST['image'])."',
	'".date("Y-m-d H:i:s")."')");
	
	$server->logThis("Notícia Postada");
	echo "Notícia postada com sucesso.";
}
################################
elseif($_POST['function']=='delete') 
{
	if(empty($_POST['id']))
		die('Nenhum ID especificado. Abortando...');

	mysql_query("DELETE FROM news WHERE id='".mysql_real_escape_string($_POST['id'])."'");
	mysql_query("DELETE FROM news_comments WHERE id='".mysql_real_escape_string($_POST['id'])."'");
	$server->logThis("Notícia deletada");
}
##############################
elseif($_POST['function']=='edit') 
{
	$id = (int)$_POST['id'];
	$title = ucfirst(mysql_real_escape_string($_POST['title']));
	$author = ucfirst(mysql_real_escape_string($_POST['author']));
	$content = mysql_real_escape_string(trim(htmlentities($_POST['content'])));
	
	if(empty($id) || empty($title) || empty($content))
	 	die("Por favor, insira os dois campos.");
    else 
	{
		mysql_query("UPDATE news SET title='".$title."', author='".$author."', body='".$content."' WHERE id='".$id."'");
		$server->logThis("Notícia atualizada para o ID: <b>".$id."</b>");
        die("sucesso");
	}
}
#############################
elseif($_POST['function']=='getNewsContent') 
{
	$result = mysql_query("SELECT * FROM news WHERE id='".(int)$_POST['id']."'");
	$row = mysql_fetch_assoc($result);
	$content = str_replace('<br />', "\n", $row['body']);
	
	echo "Título: <br/><input type='text' id='editnews_title' value='".$row['title']."'><br/>Contúdo:<br/><textarea cols='55' rows='8' id='wysiwyg'>"
	.$content."</textarea><br/>Autor:<br/><input type='text' id='editnews_author' value='".$row['author']."'><br/><input type='submit' value='Salvar' onclick='editNewsNow(".$row['id'].")'>";
}

?>