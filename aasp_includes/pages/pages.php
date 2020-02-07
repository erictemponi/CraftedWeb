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
	
	$page->validatePageAccess('Pages');
	
    if($page->validateSubPage() == TRUE) {
		$page->outputSubPage();
	} else {
 ?>

<div class="box_right_title">Páginas</div>

<?php if(!isset($_GET['action'])) { ?>

<table class="center">
<tr>
		<th>Nome</th>
	<th>Nome do arquivo</th>
	<th>Ações</th>
</tr>
<?php
	$result = mysql_query("SELECT * FROM custom_pages ORDER BY id ASC");
	while($row = mysql_fetch_assoc($result)) { 
     $check = mysql_query("SELECT COUNT(filename) FROM disabled_pages WHERE filename='".$row['filename']."'");
	 if(mysql_result($check,0)==0) {
		 $disabled = false;
	 } else {
		 $disabled = true;
	 }
    ?>
	<tr <?php if($disabled==true) { echo "style='color: #999;'"; }?>>
         <td width="50"><?php echo $row['name']; ?></td>
         <td width="100"><?php echo $row['filename']; ?>(Banco de Dados)</td>
         <td><select id="action-<?php echo $row['filename']; ?>">
           <option value="1">Habilitar</option>
           <option value="2">Desabilitar</option>
           <option value="3">Editar</option>
           <option value="4">Remover</option>
           <?php if($disabled==true) {  ?>
		 <?php } else { ?>
		 <?php } ?>
</select> &nbsp;<input type="submit" value="Salvar" onclick="savePage('<?php echo $row['filename']; ?>')"></td>
    </tr>
<?php }

foreach ($GLOBALS['core_pages'] as $k => $v) { 
$filename = substr($v, 0, -4);
unset ($check);
$check = mysql_query("SELECT COUNT(filename) FROM disabled_pages WHERE filename='".$filename."'");
	 if(mysql_result($check,0)==0) {
		 $disabled = false;
	 } else {
		 $disabled = true;
	 }
?>

    <tr <?php if($disabled==true) { echo "style='color: #999;'"; }?>>
        <td><?php echo $k; ?></td>
        <td><?php echo $v; ?></td>
        <td><select id="action-<?php echo $filename; ?>">
          <option value="1">Habilitar</option>
          <option value="2">Desabilitar</option>
             <?php if($disabled==true) { ?>
		 <?php } else { ?>
		 <?php } ?>
      </select> &nbsp;<input type="submit" value="Salvar" onclick="savePage('<?php echo $filename; ?>')"></td>
    </tr>
<?php } ?>

</table>

<?php } elseif($_GET['action']=='new') {
	 
 ?>


<?php } elseif($_GET['action']=='edit') {
	
	if(isset($_POST['editpage'])) {
		
		$name = mysql_real_escape_string($_POST['editpage_name']);
		$filename = trim(strtolower(mysql_real_escape_string($_POST['editpage_filename'])));
		$content = mysql_real_escape_string(htmlentities($_POST['editpage_content']));
		
	if(empty($name) || empty($filename) || empty($content)) {
		echo "<h3>Por favor, insira <u>todos</u> os campos.</h3>";
	} else {
		mysql_query("UPDATE custom_pages SET name='".$name."',filename='".$filename."',
		content='".$content."' WHERE filename='".mysql_real_escape_string($_GET['filename'])."'");

		echo "<h3>A página foi atualizada com sucesso.</h3> 
		<a href='".$GLOBALS['website_domain']."?p=".$filename."' target='_blank'>Ver Página</a>";
	}
	}
	
$result = mysql_query("SELECT * FROM custom_pages WHERE filename='".mysql_real_escape_string($_GET['filename'])."'"); 
$row = mysql_fetch_assoc($result);
?>
	   
     <h4>Editando <?php echo $_GET['filename']; ?>.php</h4>
    <form action="?p=pages&action=edit&filename=<?php echo $_GET['filename']; ?>" method="post">
	Nome<br/>
    <input type="text" name="editpage_name" value="<?php echo $row['name']; ?>"><br/>
    Nome do Arquivo<br/>
    <input type="text" name="editpage_filename" value="<?php echo $row['filename']; ?>"><br/>
    Conteúdo<br/>
    <textarea cols="77" rows="14" id="wysiwyg" name="editpage_content"><?php echo $row['content']; ?></textarea>    
    <br/>
    <input type="submit" value="Salvar" name="editpage">
    
<?php } } ?>