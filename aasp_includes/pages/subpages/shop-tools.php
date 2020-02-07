<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
?>
<?php $page = new page; ?>
<div class="box_right_title"><?php echo $page->titleLink(); ?> &raquo; Ferramentas</div>
<input type="submit" value="Limpar Loja de Votação" onclick="clearShop('vote')"/>  
&nbsp; Isto irá remover todos os itens da Loja de Votação
<br/><br/>
<input type="submit" value="Limpar Loja de Doação" onclick="clearShop('donate')"/> 
&nbsp; isto irá remvoer todos os itens da Loja de Doação
