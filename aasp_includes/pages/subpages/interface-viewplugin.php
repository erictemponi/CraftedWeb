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
	
	$filename = $_GET['plugin']; 
	include('../plugins/'.$filename.'/info.php');			
?>
<div class="box_right_title"><a href="?p=interface&s=plugins">Plugins</a> &raquo; <?php echo $title; ?></div>
<b><?php echo $title; ?></b><br/>
<?php echo $desc; ?>
<hr/>
Autor: <?php echo $author; ?> - <?php echo $created; ?>
<p/>
<b>Arquivos:</b><br/>
<?php
$bad = array('.','..');
//Classes
$folder = scandir('../plugins/'.$filename.'/classes/');
foreach($folder as $file)
{
	if(!in_array($file,$bad))
	{
		echo $file.' (Class)<br/>';
	}
}
//Modules
$folder = scandir('../plugins/'.$filename.'/modules/');
foreach($folder as $file)
{
	if(!in_array($file,$bad))
	{
		echo $file.' (Module)<br/>';
	}
}

//Pages
$folder = scandir('../plugins/'.$filename.'/pages/');
foreach($folder as $file)
{
	if(!in_array($file,$bad))
	{
		echo $file.' (Page)<br/>';
	}
}

//Styles
$folder = scandir('../plugins/'.$filename.'/styles/');
foreach($folder as $file)
{
	if(!in_array($file,$bad))
	{
		echo $file.' (Stylesheet)<br/>';
	}
}

//Javascript
$folder = scandir('../plugins/'.$filename.'/javascript/');
foreach($folder as $file)
{
	if(!in_array($file,$bad))
	{
		echo $file.' (Javascript)<br/>';
	}
}

$server->selectDB('webdb');
$chk = mysql_query("SELECT COUNT(*) FROM disabled_plugins WHERE foldername='".mysql_real_escape_string($filename)."'");
if(mysql_result($chk,0)>0)
	echo '<input type="submit" value="Habilitar Plugin" onclick="enablePlugin(\''.$filename.'\')">';
else
	echo '<input type="submit" value="Desabilitar Plugin" onclick="disablePlugin(\''.$filename.'\')">';
?>