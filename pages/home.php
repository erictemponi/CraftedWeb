<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
     website::getNews();
	 
	 if ($GLOBALS['enableSlideShow']==false && $GLOBALS['news']['enable']==false)  
	 {
		 buildError("<b>Erro no arquivo de Configuração.</b>Tanto o slideshow quanto as notícias estão desativados, a página está vazia.");
		 echo "Parece que a página está vazia!";
	 }
