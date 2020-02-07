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
if($_POST['action']=="setTemplate") 
{
	mysql_query("UPDATE template SET applied='0' WHERE applied='1'");
	mysql_query("UPDATE template SET applied='1' WHERE id='".(int)$_POST['id']."'");
}
###############################
if($_POST['action']=="installTemplate") 
{
	mysql_query("INSERT INTO template VALUES('','".mysql_real_escape_string(trim($_POST['name']))."','".mysql_real_escape_string(trim($_POST['path']))."','0')");
	$server->logThis("Instalado o modelo ".$_POST['name']);
}
###############################
if($_POST['action']=="uninstallTemplate") 
{
	mysql_query("DELETE FROM template WHERE id='".(int)$_POST['id']."'");
	mysql_query("UPDATE template SET applied='1' ORDER BY id ASC LIMIT 1");
	
	$server->logThis("Um modelo foi desinstalado");
}
###############################
if($_POST['action']=="getMenuEditForm") 
{
	$result = mysql_query("SELECT * FROM site_links WHERE position='".(int)$_POST['id']."'");
	$rows = mysql_fetch_assoc($result);
	 ?>
    Título<br/>
    <input type="text" id="editlink_title" value="<?php echo $rows['title']; ?>"><br/>
    URL<br/>
    <input type="text" id="editlink_url" value="<?php echo $rows['url']; ?>"><br/>
    Exibido quando<br/>
    <select id="editlink_shownWhen">
      <option value="always">Sempre</option>
      <option value="logged">O usuário está logado</option>
      <option value="notlogged">O usuário não está logado</option>
    </select><br/>
    <input type="submit" value="Salvar" onclick="saveMenuLink('<?php echo $rows['position']; ?>')">
	
<?php }
###############################
if($_POST['action']=="saveMenu") 
{
	$title = mysql_real_escape_string($_POST['title']);
	$url = mysql_real_escape_string($_POST['url']);
	$shownWhen = mysql_real_escape_string($_POST['shownWhen']);
	$id = (int)$_POST['id'];
	
	if(empty($title) || empty($url) || empty($shownWhen)) {
		die("Por favor, insira todos os campos.");
	}
	
	mysql_query("UPDATE site_links SET title='".$title."',url='".$url."',shownWhen='".$shownWhen."' WHERE position='".$id."'");
	
	$server->logThis("Menu modificado");
	
	echo TRUE;
}
###############################
if($_POST['action']=="deleteLink") 
{
	mysql_query("DELETE FROM site_links WHERE position='".(int)$_POST['id']."'");
	
	$server->logThis("Um link foi removido do menu");
	
	echo TRUE;
}
###############################
if($_POST['action']=="addLink") 
{
	$title = mysql_real_escape_string($_POST['title']);
	$url = mysql_real_escape_string($_POST['url']);
	$shownWhen = mysql_real_escape_string($_POST['shownWhen']);
	
	if(empty($title) || empty($url) || empty($shownWhen)) {
		die("Por favor, insira todos os campos.");
	}
	
	mysql_query("INSERT INTO site_links VALUES('','".$title."','".$url."','".$shownWhen."')");
	
	$server->logThis("Adicionado ".$title." ao menu");
	
	echo TRUE;
}
###############################
if($_POST['action']=="deleteImage") 
{
	$id = (int)$_POST['id'];
	mysql_query("DELETE FROM slider_images WHERE position='".$id."'");
	
	$server->logThis("Uma imagem foi removida do slideshow");
	
	return;
}
###############################
if($_POST['action']=="disablePlugin") 
{
	$foldername = mysql_real_escape_string($_POST['foldername']);
	
	mysql_query("INSERT INTO disabled_plugins VALUES('".$foldername."')");
	
	include('../../plugins/'.$foldername.'/info.php');
	$server->logThis("Desabilitado o plugin ".$title);
}
###############################
if($_POST['action']=="enablePlugin") 
{
	$foldername = mysql_real_escape_string($_POST['foldername']);
	
	mysql_query("DELETE FROM disabled_plugins WHERE foldername='".$foldername."'");
	
	include('../../plugins/'.$foldername.'/info.php');
	$server->logThis("Habilitado o plugin ".$title);
}
###############################
?>