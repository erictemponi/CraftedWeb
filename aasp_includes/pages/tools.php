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
	
    if($page->validateSubPage() == TRUE) {
		$page->outputSubPage();
	} else {
		?>
        <div class='box_right_title'>Hey! Você não deveria estar aqui!</div>
        
		<pre>O script pode ter redirecionado você para o local errado. Ou... Você está tentando hackear!? De qualquer forma, boa sorte.</pre>
        
        <a href="?p=tools&s=tickets" class="content_hider">Tickets</a>
		<a href="?p=tools&s=accountaccess" class="content_hider">Acesso à Conta</a>
		<?php
	 }
?>
