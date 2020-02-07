<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
if($GLOBALS['showLoadTime']==TRUE) 
{
	$end = number_format((microtime(true) - $GLOBALS['start']),2);
	if ($end == 1)
		echo "Página carregada em ", $end, " segundo. <br/>";
	else
		echo "Página carregada em ", $end, " segundos. <br/>";
}
echo "&copy 2020 - <a href='http://erictemponi.000webhostapp.com/' target=\"_blank\">Erictemponi</a>";
#echo $GLOBALS['footer_text'];