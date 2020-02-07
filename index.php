<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>

*/

require('includes/loader.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-BR">
<!-- ATTENTION COPY-WHORES. THE TEMPLATE, HTML, CSS, JAVASCRIPT AND ALL ITS CODING BELONGS TO CRAFTEDWEB
	 YOU ARE NOT ALLOWED TO DISTRIBUTE ANYTHING WITHOUT APPROVAL FROM THE CREATOR. ILLEGAL DISTRIBUTION WILL RESULT IN LAW SUIT-->
<head>
<?php require('includes/template_loader.php'); ?>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
<title>
<?php 
echo $website_title .' - '; 

while ($page_title = current($GLOBALS['core_pages'])) 
{
    if ($page_title == $_GET['p'].'.php'){
        echo key($GLOBALS['core_pages']);
		$foundPT = true;
    }
    next($GLOBALS['core_pages']);
}
if(!isset($foundPT))
	echo ucfirst($_GET['p']);
?>
</title>
<?php
	$content = new Page('styles/'.$template['path'].'/template.html');
	$content->loadCustoms();
	$content->replace_tags(array('content' => 'modules/content.php'));
	$content->replace_tags(array('menu' => 'modules/menu.php'));
	$content->replace_tags(array('login' => 'modules/login.php'));
	$content->replace_tags(array('account' => 'modules/account.php'));
	$content->replace_tags(array('serverstatus' => 'modules/server_status.php'));
	$content->replace_tags(array('slideshow' => 'modules/slideshow.php'));
	$content->replace_tags(array('footer' => 'modules/footer.php'));
	$content->replace_tags(array('loadjava' => 'includes/javascript_loader.php'));
	$content->replace_tags(array('social' => 'modules/social.php'));
	$content->replace_tags(array('alert' => 'modules/alert.php'));
?>
</head>
<body>
<?php  
    $dirname = "install/";
    if (!is_dir($dirname)){  
		$content->output(); 
	}else{  
		echo "<center><h1>A pasta install ainda existe<br>por favor remova-a para ver seu site.</h2>";  
    }  
?> 
</body>
</html>