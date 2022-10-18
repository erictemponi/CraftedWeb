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
include('../../includes/classes/account.php');
mysql_connect($GLOBALS['connection']['host'],$GLOBALS['connection']['user'],$GLOBALS['connection']['password']);

###############################
if(isset($_POST['login'])) 
{
	$username = mysql_real_escape_string(strtoupper(trim($_POST['username']))); 
	$password = mysql_real_escape_string(strtoupper(trim($_POST['password'])));
	if(empty($username) || empty($password))
		die("Por favor, insira os dois campos.");
	 
	mysql_select_db($GLOBALS['connection']['logondb']);
	
	$data = mysql_query("SELECT id, salt, verifier FROM account WHERE username = '".$username."'");
	$data = mysql_fetch_assoc($data);
	$uid = $data['id'];
	$salt = $data['salt'];
	$verifier = $data['verifier'];
	
	if (!account::verifySRP6($username, $password, $salt, $verifier))
		die("Combinação de Nome de Usuário/Senha inválida.");
	
	$result = mysql_query("SELECT SecurityLevel FROM account_access WHERE AccountID='".$uid."' 
	AND SecurityLevel >= '".$GLOBALS[$_POST['panel'].'Panel_minlvl']."'");
	
	if(mysql_num_rows($result)==0)
		die("A conta especificada não tem acesso a essa área!");
	 
	$rank = mysql_fetch_assoc($result);	 
	
	$_SESSION['cw_'.$_POST['panel']]=ucfirst(strtolower($username));
	$_SESSION['cw_'.$_POST['panel'].'_id']=$uid;
	$_SESSION['cw_'.$_POST['panel'].'_level']=$rank['SecurityLevel'];
	
	if(empty($_SESSION['cw_'.$_POST['panel']]) || empty($_SESSION['cw_'.$_POST['panel'].'_id'])
	|| empty($_SESSION['cw_'.$_POST['panel'].'_level']))
		die('Os scripts encontraram um erro. (1 ou mais sessões foram definidas como nulas)');
	
	sleep(1);
	die(TRUE);
  }
###############################  
?>