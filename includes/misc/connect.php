<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */

 
class connect {
	
	public static $connectedTo = NULL;

    public static function connectToDB() 
	{
		if(static::$connectedTo != 'global')
		{
			if (!mysql_connect($GLOBALS['connection']['host'],$GLOBALS['connection']['user'],$GLOBALS['connection']['password']))
				buildError("Erro de conexão com o Banco de Dados: Não foi possível estabelecer uma conexão. Erro: ".mysql_error(),NULL);
			else
				static::$connectedTo = 'global';
		}
	}
	 
	public static function connectToRealmDB($realmid) 
	{
        static::selectDB('webdb');
		
			if($GLOBALS['realms'][$realmid]['mysql_host'] != $GLOBALS['connection']['host'] 
			|| $GLOBALS['realms'][$realmid]['mysql_user'] != $GLOBALS['connection']['user'] 
			|| $GLOBALS['realms'][$realmid]['mysql_pass'] != $GLOBALS['connection']['password'])
			{
				mysql_connect($GLOBALS['realms'][$realmid]['mysql_host'],
							  $GLOBALS['realms'][$realmid]['mysql_user'],
							  $GLOBALS['realms'][$realmid]['mysql_pass'])
							  or 
							  buildError("Erro de conexão com o Banco de Dados: A conexão não pode ser estabelecida com o Reino. Erro: ".mysql_error(),NULL);
			}
			else
			{
                static::connectToDB();
			}
			mysql_select_db($GLOBALS['realms'][$realmid]['chardb']) or 
			buildError("Erro de seleção do Banco de Dados: O Reino não foi selecionado no Banco de Dados. Erro: ".mysql_error(),NULL);
            static::$connectedTo = 'chardb';

	}
	 
	 
	public static function selectDB($db) 
	{
		static::connectToDB();
		
		switch($db)
		{
			case('logondb'):
				mysql_select_db($GLOBALS['connection']['logondb']);
				break;
			case('webdb'):
				mysql_select_db($GLOBALS['connection']['webdb']);
				break;
			case('worlddb'):
				mysql_select_db($GLOBALS['connection']['worlddb']);
				break;
			default: 
				mysql_select_db($db);
				break;
		}
		
		mysql_query("SET NAMES 'utf8'");
		mysql_query('SET character_set_connection=utf8');
		mysql_query('SET character_set_client=utf8');
		mysql_query('SET character_set_results=utf8');
		
		return TRUE;
	}
}

    /*************************/
	/* Realms & service prices automatic settings
	/*************************/
	$realms = array();
	$service = array();

    connect::selectDB('webdb');

	$getRealms = mysql_query("SELECT * FROM realms ORDER BY id ASC");
	while($row = mysql_fetch_assoc($getRealms))
	{
		$realms[$row['id']] = $row;
		$realms[$row['id']]['mysql_host'] = $row['mysql_host'];
		$realms[$row['id']]['mysql_user'] = $row['mysql_user'];
		$realms[$row['id']]['mysql_pass'] = $row['mysql_pass'];
		$realms[$row['id']]['chardb']	  = $row['char_db'];
    }

     //Service prices
  $getServices = mysql_query("SELECT enabled,price,currency,service FROM service_prices");
  while($row = mysql_fetch_assoc($getServices))
  {
    $service[$row['service']]['status'] = $row['enabled'];
    $service[$row['service']]['price'] = $row['price'];
    $service[$row['service']]['currency'] = $row['currency'];
  }

  ##Unset Magic Quotes
  if (get_magic_quotes_gpc())
  {
    $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    while (list($key, $val) = each($process))
    {
        foreach ($val as $k => $v)
        {
            unset($process[$key][$k]);
            if (is_array($v))
            {
                $process[$key][stripslashes($k)] = $v;
                $process[] = &$process[$key][stripslashes($k)];
            }
            else
            $process[$key][stripslashes($k)] = stripslashes($v);
        }
    }
    unset($process);
    }
