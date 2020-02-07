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
	
	$page->validatePageAccess('Interface');
	
    if($page->validateSubPage() == TRUE) {
		$page->outputSubPage();
	} else {
?>
<div class="box_right_title">Modelo</div>          
    
 Aqui você pode escolher qual o modelo que ficará ativo em seu site. Este também é o lugar onde você poderá instalar novos temas em seu site.<br/><br/>
 <h3>Escolha o Modelo</h3>
        <select id="choose_template">
                <?php
                $result = mysql_query("SELECT * FROM template ORDER BY id ASC");
                while($row = mysql_fetch_assoc($result)) {
                    if($row['applied']==1) 
                        echo "<option selected='selected' value='".$row['id']."'>[Active] ";
                    else 
                        echo "<option value='".$row['id']."'>";
                        
                    echo $row['name']."</option>";
                }
                ?>
        </select>
        <input type="submit" value="Salvar" onclick="setTemplate()"/><hr/><p/>
        
        <h3>Instalar um novo modelo</h3>
        <a href="#" onclick="templateInstallGuide()">Como instalar novos modelos em seu site</a><br/><br/><br/>
        Diretório do modelo<br/>
        <input type="text" id="installtemplate_path"/><br/>
        Escolha o nome<br/>
        <input type="text" id="installtemplate_name"/><br/>
        <input type="submit" value="Instalar" onclick="installTemplate()"/>
        <hr/>
        <p/>
        
        <h3>Desinstalar um modelo</h3>
        <select id="uninstall_template_id">
                <?php
                $result = mysql_query("SELECT * FROM template ORDER BY id ASC");
                while($row = mysql_fetch_assoc($result)) {
                    if($row['applied']==1) 
                        echo "<option selected='selected' value='".$row['id']."'>[Active] ";
                    else 
                        echo "<option value='".$row['id']."'>";
                        
                    echo $row['name']."</option>";
                }
                ?>
        </select>
        <input type="submit" value="Desinstalar" onclick="uninstallTemplate()"/> 
 <?php } ?>