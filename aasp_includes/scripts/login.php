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
include('../../includes/configuration.php');;
mysql_connect($GLOBALS['connection']['host'],$GLOBALS['connection']['user'],$GLOBALS['connection']['password']);

###############################
if(isset($_POST['login'])) 
{
	 $username = mysql_real_escape_string(strtoupper(trim($_POST['username']))); 
	 $password = mysql_real_escape_string(strtoupper(trim($_POST['password'])));
	 if(empty($username) || empty($password))
		 die("Por favor, insira os dois campos.");
	 
		 $password = sha1("".$username.":".$password."");
		 mysql_select_db($GLOBALS['connection']['logondb']);
		 
		 $result = mysql_query("SELECT COUNT(id) FROM account WHERE username='".$username."' AND 
		 sha_pass_hash = '".$password."'");
		 if(mysql_result($result,0)==0)
			 die("Combinação de Nome de Usuário/Senha inválida.");
		 
		 $getId = mysql_query("SELECT id FROM account WHERE username='".$username."'");
		 $row = mysql_fetch_assoc($getId);
		 $uid = $row['id'];
		 $result = mysql_query("SELECT gmlevel FROM account_access WHERE id='".$uid."' 
		 AND gmlevel >= '".$GLOBALS[$_POST['panel'].'Painel_minlvl']."'");
		
		 if(mysql_num_rows($result)==0)
			 die("A conta especificada não tem acesso a essa área!");
			 
		 $rank = mysql_fetch_assoc($result);	 
		 
		 $_SESSION['cw_'.$_POST['panel']]=ucfirst(strtolower($username));
		 $_SESSION['cw_'.$_POST['panel'].'_id']=$uid;
		 $_SESSION['cw_'.$_POST['panel'].'_level']=$rank['gmlevel'];
		 
		 if(empty($_SESSION['cw_'.$_POST['panel']]) || empty($_SESSION['cw_'.$_POST['panel'].'_id'])
		 || empty($_SESSION['cw_'.$_POST['panel'].'_level']))
		 	die('Os scripts encontraram um erro. (1 ou mais sessões foram definidas como nulas)');
		 
		 sleep(1);
		 die(TRUE);
  }
###############################  
?>