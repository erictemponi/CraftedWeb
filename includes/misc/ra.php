<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */

function sendRA($command,$ra_user,$ra_pass,$server,$realm_port)
{
	$telnet = @fsockopen($server, $realm_port, $error, $error_str, 3);
	if($telnet)
	{
		fgets($telnet,1024);
		fputs($telnet, $ra_user."\n");
		sleep(3);

	    fputs($telnet, $ra_pass."\n");
		sleep(3);

		fputs($telnet, $command."\n");
		sleep(3);
		fclose($telnet);
        return;
	}
	else
        return $error_str;
		#die('Problemas de conexão...Abortando | Erro: '.$error_str);
}
?>