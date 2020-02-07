<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */?>

<?php
define('INIT_SITE', TRUE);
include('../../includes/misc/headers.php');
include('../../includes/configuration.php');

###############################
if(isset($_POST['test'])) 
{
	$errors = array();
	
	/* Test Connection */
	if(!mysql_connect($GLOBALS['connection']['host'],$GLOBALS['connection']['user'],
	$GLOBALS['connection']['password'])) 
		$errors[] = "Erro de conexão com a MySQL. Por favor, verifique suas configurações.";
	else 
	{
		if(!mysql_select_db($GLOBALS['connection']['webdb']))
			$errors[] = "Erro no Banco de Dados. Não foi possível estabelecer uma conexão com o Banco de Dados do site.";
		
		if(!mysql_select_db($GLOBALS['connection']['logondb']))
			$errors[] = "Erro no Banco de Dados. Não foi possível estabelecer uma conexão com o Banco de Dados de logon.";
		
		if(!mysql_select_db($GLOBALS['connection']['worlddb']))
			$errors[] = "Erro no Banco de Dados. Não foi possível estabelecer uma conexão com o Banco de Dados world.";
	}
	
	if (!empty($errors)) 
	{
			foreach($errors as $error) 
			{
				echo  "<strong>*", $error ,"</strong><br/>";
			}
			
		} 
		else
			echo "Nenhum erro ocorrido. As configurações estão corretas.";
}
###############################
?>