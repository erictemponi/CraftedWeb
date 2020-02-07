<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
?>
<?php $page = new page; $server = new server; ?>
<div class="box_right_title"><?php echo $page->titleLink(); ?> &raquo; Slideshow</div>
<?php 
if($GLOBALS['enableSlideShow']==true) 
$status = 'Habilitado';
else
$status = 'Desabilitado';

$server->selectDB('webdb');
$count = mysql_query("SELECT COUNT(*) FROM slider_images");
?>
O slideshow está <b><?php echo $status; ?></b>. Você tem <b><?php echo round(mysql_result($count,0)); ?></b> imagens em seu slideshow.
<hr/>
<?php 
if(isset($_POST['addSlideImage']))
{
	$page = new page;
	$page->addSlideImage($_FILES['slideImage_upload'],$_POST['slideImage_path'],$_POST['slideImage_url']);
}
?>
<a href="#addimage" onclick="addSlideImage()" class="content_hider">Add imagem</a>
<div class="hidden_content" id="addSlideImage">
<form action="" method="post" enctype="multipart/form-data">
Carregar uma imagem:<br/>
<input type="file" name="slideImage_upload"><br/>
ou digite o URL da imagem: (Isso substituirá a imagem que você carregou)<br/>
<input type="text" name="slideImage_path"><br/>
Para onde a imagem irá redirecionar? (Deixe em branco para não redirecionar)<br/>
<input type="text" name="slideImage_url"><br/>
<input type="submit" value="Add" name="addSlideImage">
</form>
</div>
<br/>&nbsp;<br/>
<?php 
$server->selectDB('webdb');
$result = mysql_query("SELECT * FROM slider_images ORDER BY position ASC");
if(mysql_num_rows($result)==0) 
{
	echo "Você não tem nenhuma imagem no Slideshow!";
}
else 
{
	echo '<table>';
	$c = 1;
	while($row = mysql_fetch_assoc($result))
	{
		echo '<tr class="center">';
		echo '<td><h2>&nbsp; '.$c.' &nbsp;</h2><br/>
		<a href="#remove" onclick="removeSlideImage('.$row['position'].')">Remover</a></td>';
		echo '<td><img src="../'.$row['path'].'" alt="'.$c.'" class="slide_image" maxheight="200"/></td>';
		echo '</tr>';
		$c++;
	}
	  echo '</table>';
}
?>

