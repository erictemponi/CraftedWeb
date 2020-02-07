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
	
	$page->validatePageAccess('Realms');
	
    if($page->validateSubPage() == TRUE) {
		$page->outputSubPage();
	} else {
?>
<div class='box_right_title'>Novo Reino</div>
<?php if(isset($_POST['add_realm'])) {
	$server->addRealm($_POST['realm_id'],$_POST['realm_name'],$_POST['realm_desc'],$_POST['realm_host'],$_POST['realm_port']
			,$_POST['realm_chardb'],$_POST['realm_sendtype'],$_POST['realm_rank_username'],
			$_POST['realm_rank_password'],$_POST['realm_ra_port'],$_POST['realm_soap_port'],$_POST['realm_a_host']
			,$_POST['realm_a_user'],$_POST['realm_a_pass']);	
}?>

                        <form action="?p=realms" method="post" style="line-height: 15px;">
                          <b>Informações Gerais Sobre o Reino</b>
                          <hr/>
                        ID do Reino: <br/>
                        <input type="text" name="realm_id" placeholder="Padrão: 1"/> <br/>
                        <i class='blue_text'>Você deve colocar o mesmo ID que você colocou na tabela realmlist do Banco de Dados auth. Caso contrário, o Tempo de Atividade não irá funcionar se você tiver mais de um reino..</i><br/>
                        Nome do Reino: <br/>
                        <input type="text" name="realm_name" placeholder="Padrão: Reino Simples"/> <br/>
                        (Opcional) Descrição do Reino: <br/>
                        <input type="text" name="realm_desc" placeholder="Padrão: Blizzlike 3x"/> <br/>
                        Porta do Reino: <br/>
                        <input type="text" name="realm_port" placeholder="Padrão: 8085"/> <br/>
                        Host: (IP ou DNS) <br/>
                        <input type="text" name="realm_host" placeholder="Padrão: 127.0.0.1"/> <br/>
                        
                        <br/>
                        <b>Informações do Consolo Remoto</b> <i>(Loja de Doação e Votação)</i>
                        <hr/>
                        Consolo Remoto <i>(Você sempre poderá alterar isso mais tarde)</i>: <br/>
                        <select name="realm_sendtype">
                                 <option value="ra">RA</option>
                                 <option value="soap">SOAP</option>
                        </select><br/>
                        <i class='blue_text'>Especifique uma conta GM nível 3 (usada para o Console Remoto)<br>
                        Dica: Não use a conta de adminsitrador. Use uma conta de nível 3.
                        </i><br/>
                        Nome de Usuário: <br/>
                        <input type="text" name="realm_rank_username" placeholder="Padrão: admin"/> <br/>
                        Senha: <br/>
                        <input type="password" name="realm_rank_password" placeholder="Padrão: admin"/> <br/>
                        Porta RA: <i>(Pode ser ignorada, caso tenha escolhido a SOAP)</i> <br/>
                        <input type="text" name="realm_ra_port" placeholder="Padrão: 3443"/> <br/>
                        Porta SOAP: <i>(Pode ser ignorada, caso tenha escolhido a RA)</i> <br/>
                        <input type="text" name="realm_soap_port" placeholder="Padrão: 7878"/> <br/>
                        <br/>
                        <b>Informações MySQL</b> <i>(Se deixada em branco, as informações serão copiadas do seu arquivo de configurações)</i>
                        <hr/>
                        Host da MySQL: <br/>
                        <input type="text" name="realm_m_host" placeholder="Padrão: localhost"/><br/>
                        Usuário da MySQL: <br/>
                        <input type="text" name="realm_m_user" placeholder="Padrão: root"/><br/>
                        Senha da MySQL: <br/>
                        <input type="text" name="realm_m_pass" placeholder="Padrão: ascent"/><br/>
                        Banco de Dados dos Personagens:<br/>
                        <input type="text" name="realm_chardb" placeholder="Padrão: characters"/> <br/>
                        <hr/>
                        <input type="submit" value="Add" name="add_realm" />                     
                        </form>
<?php } ?>
