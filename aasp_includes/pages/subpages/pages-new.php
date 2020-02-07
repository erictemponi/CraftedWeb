<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
?>
<?php $page = new page;
if(isset($_POST['newpage'])) {
	
	$name = mysql_real_escape_string($_POST['newpage_name']);
	$filename = trim(strtolower(mysql_real_escape_string($_POST['newpage_filename'])));
	$content = mysql_real_escape_string(htmlentities($_POST['newpage_content']));
	
	if(empty($name) || empty($filename) || empty($content)) {
		echo "<h3>Por favor, insira <u>todos</u> os campos.</h3>";
	} else {
		mysql_query("INSERT INTO custom_pages VALUES ('','".$name."','".$filename."','".$content."',
		'".date("Y-m-d H:i:s")."')");

		echo "<h3>A página foi criada com sucesso.</h3> 
		<a href='".$GLOBALS['website_domain']."?p=".$filename."' target='_blank'>Visualizar página</a><br/><br/>";
	}
} ?>
<div class="box_right_title"><?php echo $page->titleLink(); ?> &raquo; Nova página</div>
<form action="?p=pages&s=new" method="post">
Nome <br/>
<input type="text" name="newpage_name"><br/>
Nome do arquivo <i>(Este será o ?p=NOMEDOARQUIVO)<br/>
<input type="text" name="newpage_filename"><br/>
Conteúdo<br/>
<textarea cols="77" rows="14" id="wysiwyg" name="newpage_content">
<?php if(isset($_POST['newpage_content'])) { echo $_POST['newpage_content']; } ?></textarea>    <br/>
<input type="submit" value="Criar" name="newpage">