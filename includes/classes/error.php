<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
function buildError($error,$num) 
{
	if ($GLOBALS['useDebug']==false) 
		log_error($error,$num);
	else 
		errors($error,$num);
}

function errors($error,$num) 
{
	log_error(strip_tags($error),$num);
	die("<center><b>Erro de site</b>  <br/>
		O script do site encontrou um erro e morreu. <br/><br/>
		<b>Mensagem de erro: </b>".$error."  <br/>
		<b>Número do erro: </b>".$num."
		<br/><br/><br/><i>Desenvolvido por CraftedWeb, Editado por Eric Temponi
		<br/><font size='-2'>Profissionalmente desenvolvido com amor e muita dor de cabeça.</font></i></center>
		");
}

function log_error($error,$num) 
{
 error_log("*[".date("d M Y H:i")."] ".$error, 3, "error.log");
}

function loadCustomErrors() 
{
  set_error_handler("customError");   
}

function customError($errno, $errstr)
{
    if ($errno!=8 && $errno!=2048 && $GLOBALS['useDebug']==TRUE) 
          error_log("*[".date("d M Y H:i")."]<i>".$errstr."</i>", 3, "error.log");
}
?>