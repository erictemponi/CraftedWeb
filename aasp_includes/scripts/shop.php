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
if($_POST['action']=='addsingle') 
{
	$entry = (int)$_POST['entry'];
	$price = (int)$_POST['price'];
	$shop = mysql_real_escape_string($_POST['shop']);
	
	if(empty($entry) || empty($price) || empty($shop))
		die("Por favor, insira todos os campos.");

	$server->selectDB('worlddb');
	$get = mysql_query("SELECT name,displayid,ItemLevel,quality,AllowableRace,AllowableClass,class,subclass,Flags
	FROM item_template WHERE entry='".$entry."'")or die('Erro na obtenção de dados do item do Banco de Dados. Mensagem de Erro: '.mysql_error());
	$row = mysql_fetch_assoc($get);
	
	$server->selectDB('webdb');
	
	if($row['AllowableRace']=="-1")
		$faction = 0;
	elseif($row['AllowableRace']==690)
		$faction = 1;
	elseif($row['AllowableRace']==1101)
		$faction = 2;
	else
		$faction = $row['AllowableRace'];

	mysql_query("INSERT INTO shopitems (entry,name,in_shop,displayid,type,itemlevel,quality,price,class,faction,subtype,flags) VALUES (
	'".$entry."','".mysql_real_escape_string($row['name'])."','".$shop."','".$row['displayid']."','".$row['class']."','".$row['ItemLevel']."'
	,'".$row['quality']."','".$price."','".$row['AllowableClass']."','".$faction."','".$row['subclass']."','".$row['Flags']."'
	)")or die('Erro na adição dos itens ao Banco de Dados. Mensagem de Erro: '.mysql_error());
	
	$server->logThis("Adicionado ".$row['name']." Para a ".$shop." loja");
	
	echo 'Item adicionado com sucesso';
}
###############################
if($_POST['action']=='addmulti') 
{
	$il_from = (int)$_POST['il_from'];
	$il_to = (int)$_POST['il_to'];
	$price = (int)$_POST['price'];
	$quality = mysql_real_escape_string($_POST['quality']);
	$shop = mysql_real_escape_string($_POST['shop']);
	$type = mysql_real_escape_string($_POST['type']);
	
	if(empty($il_from) || empty($il_to) || empty($price) || empty($shop))
		die("Por favor, insira todos os campos.");
		
	$advanced = "";
	if($type!="all") 
	{
		if($type=="15-5" || $type=="15-5")  
		{
			//Mount or pet
			$type = explode('-',$type);
			
			$advanced.= "AND class='".$type[0]."' AND subclass='".$type[1]."'";
		} 
		else	
			$advanced.= "AND class='".$type."'";
	} 	

	if($quality!="all")
		$advanced .= " AND quality='".$quality."'";
	        
	$server->selectDB('worlddb');
	$get = mysql_query("SELECT entry,name,displayid,ItemLevel,quality,class,AllowableRace,AllowableClass,subclass,Flags
	 FROM item_template WHERE itemlevel>='".$il_from."'
	AND itemlevel<='".$il_to."' ".$advanced) or die('Erro na obtenção de dados do item do Banco de Dados. Mensagem de Erro: '.mysql_error());
	
	$server->selectDB('webdb');
	
	$c = 0;
	while($row = mysql_fetch_assoc($get)) 
	{
		$faction = 0;
		
		if($row['AllowableRace']==690) 
			$faction = 1;
		elseif($row['AllowableRace']==1101)
			$faction = 2;
		else
			$faction = $row['AllowableRace'];
	
	mysql_query("INSERT INTO shopitems (entry,name,in_shop,displayid,type,itemlevel,quality,price,class,faction,subtype,flags) VALUES (
	'".$row['entry']."','".mysql_real_escape_string($row['name'])."','".$shop."','".$row['displayid']."','".$row['class']."','".$row['ItemLevel']."'
	,'".$row['quality']."','".$price."','".$row['AllowableClass']."','".$faction."','".$row['subclass']."','".$row['Flags']."'
	)")or die('Erro na adição dos itens ao Banco de Dados. Mensagem de Erro: '.mysql_error());
	
	$c++;
	}
	
	$server->logThis("Added multiple items to the ".$shop." shop");
	echo 'Adicionado com sucesso '.$c.' itens';
}
###############################
if($_POST['action']=='clear') 
{
	$shop = (int)$_POST['shop'];
	
	if($shop==1)
		$shop = "vote";
	elseif($shop==2)
		$shop = "donate";
	
	mysql_query("DELETE FROM shopitems WHERE in_shop='".$shop."'");
	mysql_query("TRUNCATE shopitems");
	return;
}
###############################
if($_POST['action']=='modsingle') 
{
	$entry = (int)$_POST['entry'];
	$price = (int)$_POST['price'];
	$shop = mysql_real_escape_string($_POST['shop']);
	
	if(empty($entry) || empty($price) || empty($shop))
		die("Por favor, insira todos os campos.");
	
	mysql_query("UPDATE shopitems SET price='".$price."' WHERE entry='".$entry."' AND in_shop='".$shop."'");
	echo 'Item modificado com sucesso';
}
###############################
if($_POST['action']=='delsingle') 
{
	$entry = (int)$_POST['entry'];
	$shop = mysql_real_escape_string($_POST['shop']);
	
	if(empty($entry) || empty($shop))
		die("Por favor, insira todos os campos.");
	
	mysql_query("DELETE FROM shopitems WHERE entry='".$entry."' AND in_shop='".$shop."'");
	echo 'Item removido com sucesso';
}
###############################
if($_POST['action']=='modmulti') 
{
	$il_from = (int)$_POST['il_from'];
	$il_to = (int)$_POST['il_to'];
	$price = (int)$_POST['price'];
	$quality = mysql_real_escape_string($_POST['quality']);
	$shop = mysql_real_escape_string($_POST['shop']);
	$type = mysql_real_escape_string($_POST['type']);
	
	if(empty($il_from) || empty($il_to) || empty($price) || empty($shop))
		die("Por favor, insira todos os campos.");
		
	$advanced = "";
	if($type!="all") 
	{
		if($type=="15-5" || $type=="15-5")  
		{
			//Mount or pet
			$type = explode('-',$type);
			
			$advanced.= "AND type='".$type[0]."' AND subtype='".$type[1]."'";
		} 
		else	
			$advanced.= "AND type='".$type."'";
	} 	

	if($quality!="all")
		$advanced .= "AND quality='".$quality."'";
		
	$count = mysql_query("COUNT(*) FROM shopitems WHERE itemlevel >='".$il_from."' AND itemlevel <='".$il_to."' ".$advanced);
		
	mysql_query("UPDATE shopitems SET price='".$price."' WHERE itemlevel >='".$il_from."' AND itemlevel <='".$il_to."' ".$advanced);	
	echo 'Modificado com sucesso '.$count.' itens!';	
}
###############################
if($_POST['action']=='delmulti') 
{
	$il_from = (int)$_POST['il_from'];
	$il_to = (int)$_POST['il_to'];
	$quality = mysql_real_escape_string($_POST['quality']);
	$shop = mysql_real_escape_string($_POST['shop']);
	$type = mysql_real_escape_string($_POST['type']);
	
	if(empty($il_from) || empty($il_to) || empty($shop))
		die("Por favor, insira todos os campos.");
		
	$advanced = "";
	if($type!="all") 
	{
		if($type=="15-5" || $type=="15-5")  
		{
			//Mount or pet
			$type = explode('-',$type);
			
			$advanced.= "AND type='".$type[0]."' AND subtype='".$type[1]."'";
		} 
		else	
			$advanced.= "AND type='".$type."'";
	} 	

	if($quality!="all")
		$advanced .= "AND quality='".$quality."'";
	
	$count = mysql_query("COUNT(*) FROM shopitems WHERE itemlevel >='".$il_from."' AND itemlevel <='".$il_to."' ".$advanced);
		
	mysql_query("DELETE FROM shopitems WHERE itemlevel >='".$il_from."' AND itemlevel <='".$il_to."' ".$advanced);
	echo 'Removido com sucesso '.$count.' itens!';	
}
###############################
?>