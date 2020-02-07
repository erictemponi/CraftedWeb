<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 

class cache {
	
	public static function buildCache($filename,$content) 
	{
		if ($GLOBALS['useCache']==TRUE) 
		{
			if(!$fh = fopen('cache/'.$filename.'.cache.php', 'w+'))
			{
				buildError('<b>Erro de cache.</b> Não foi possível carregar o arquivo (cache/'.$filename.'.cache.php)');
			}
			fwrite($fh,$content);
			fclose($fh); 
			unset($content,$filename);
		} 
		else 
			self::deleteCache($filename);
	}
	
	public static function loadCache($filename) 
	{
		if ($GLOBALS['useCache']==TRUE)
		 {
			if (file_exists('cache/'.$filename.'.cache.php')) 
				include('cache/'.$filename.'.cache.php');
			else 
				buildError('<b>Erro de cache.</b> Não foi possível carregar o arquivo (cache/'.$filename.'.cache.php)');
		} 
		else 
			self::deleteCache($filename);
	}
	
	public static function deleteCache($filename) 
	{
		if (file_exists('cache/'.$filename.'.cache.php')) 
		{
			$del = unlink('cache/'.$filename.'.cache.php');
			if(!$del) 
				buildError('<b>Erro de cache.</b> Tentou excluir um arquivo de cache que não existe (cache/'.$filename.'.cache.php)');
		} 
	}
	
	
	public static function exists($filename) 
	{
		if (file_exists('cache/'.$filename.'.cache.php')) 
			return TRUE;
		else
			return FALSE;
	}

}

?>