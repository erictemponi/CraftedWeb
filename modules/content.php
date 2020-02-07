<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
 connect::selectDB('webdb');
 $pages = scandir('pages');
 unset($pages[0],$pages[1]);
 $page = mysql_real_escape_string($_GET['p']);
 
 if (!isset($page))  
	 include('pages/home.php');
 elseif(isset($_SESSION['loaded_plugins_pages']) && $GLOBALS['enablePlugins']==true && !in_array($page.'.php',$pages))
	plugins::load('pages'); 
	
 elseif(in_array($page.'.php',$pages)) 
 {
	 $result = mysql_query("SELECT COUNT(filename) FROM disabled_pages WHERE filename='".$page."'");
	 if(mysql_result($result,0)==0) 
	   include('pages/'.$page.'.php');
	 else
	   include('pages/404.php'); 
 }
 else 
 {
	 $result = mysql_query("SELECT * FROM custom_pages WHERE filename='".$page."'");
	 if(mysql_num_rows($result)>0) 
	 {	  
		 $check = mysql_query("SELECT COUNT(filename) FROM disabled_pages WHERE filename='".$page."'");
		 if(mysql_result($check,0)==0) 
		 {
			$row = mysql_fetch_assoc($result);
			echo html_entity_decode($row['content']); 
		 } 
	} 
	else 
	  include('pages/404.php');
 }