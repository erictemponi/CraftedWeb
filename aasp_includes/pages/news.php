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
	 
	 $page->validatePageAccess('News');
	 
     if($page->validateSubPage() == TRUE) {
		 $page->outputSubPage();
	 } else {
?>
<div class="box_right_title">Notícias &raquo; Postar notícia</div>                  
<div id="news_status"></div>
<input type="text" value="Título..." id="news_title"/> <br/>
<input type="text" value="Autor..." id="news_author"/> <br/>
<input type="text" value="URL da Imagem..." id="news_image"/> <br/>
<textarea cols="72" rows="7" id="wysiwyg">Conteúdo...</textarea>
<input type="submit" value="Postar" onclick="postNews()"/>  <input type="submit" value="Visualização" onclick="previewNews()" disabled="disabled"/>                                    
<?php } ?>
                                    