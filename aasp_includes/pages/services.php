<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
?>
<?php 
	$server->selectDB('webdb'); 
 	$page = new page;
	
	$page->validatePageAccess('Services');
	
    if($page->validateSubPage() == TRUE) {
		$page->outputSubPage();
	} 
	else 
	{
		echo '<h2>Proibido!</h2>Ou, na verdade... Não há nada aqui'; 
	}
?>