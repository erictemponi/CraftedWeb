<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 

include('documents/alert.php');

if($alert_enabled == true)
{
	echo '<div id="alert"><b>Nota:</b> ';
		echo $alert_message; 
	echo '</div>';
}