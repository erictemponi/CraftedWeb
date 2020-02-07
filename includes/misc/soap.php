<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
function sendSoap($command,$username,$password,$host,$soapport) {

$client = new SoapClient(NULL,
	array(
		"location" => "http://$host:$soapport/",
		"uri" => "urn:TC",
		"style" => SOAP_RPC,
		'login' => $username,
		'password' => $password
	));
try 
{
    $result = $client->executeCommand(new SoapParam($command, "command"));

    echo "Comando bem sucedido! Saída:<br />\n";
    echo $result;
}
catch (Exception $e)
{
    echo "Comando mal sucedido! Motivo:<br />\n";
    echo $e->getMessage();
	}
}

?>