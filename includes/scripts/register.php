<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 

require('../ext_scripts_class_loader.php');

connect::selectDB('logondb');

if (isset($_POST['register'])) 
{
	$username = trim($_POST['username']);
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	$repeat_password = trim($_POST['password_repeat']);
	$captcha = (int)$_POST['captcha'];
	$raf = $_POST['raf'];
	
	account::register($username,$email,$password,$repeat_password,$captcha,$raf);
	echo TRUE;
}

if(isset($_POST['check'])) 
{
	if($_POST['check']=="username") 
	{
		$username = mysql_real_escape_string($_POST['value']);
		
		$result = mysql_query("SELECT COUNT(id) FROM account WHERE username='".$username."'");
		if(mysql_result($result,0)==0)
			echo "<i class='green_text'>O Nome de Usuário está disponível</i>";
		else 
			echo "<i class='red_text'>O Nome de Usuário não está disponível</i>";
	}
}
?>