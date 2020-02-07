<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
?>
<?php $page = new page; $server = new server; $account = new account; ?>
<div class="box_right_title"><?php echo $page->titleLink(); ?> &raquo; Gerenciar Usuário</div>

<?php
if(isset($_GET['char']))  {
	echo 'Search results for <b>'.$_GET['char'].'</b><pre>';
	$result = mysql_query("SELECT name, id FROM realms");
	while($row = mysql_fetch_assoc($result)) 
	{
		$server->connectToRealmDB($row['id']);
		$get = mysql_query("SELECT account,name FROM characters WHERE name='".mysql_real_escape_string($_GET['char'])."' OR guid='".(int)$_GET['char']."'");
		$rows = mysql_fetch_assoc($get);
			echo '<a href="?p=users&s=manage&user='.$rows['account'].'">'.$rows['name'].' - '.$row['name'].'</a><br/>';
	}
	echo '</pre><hr/>';
}

if(isset($_GET['user']))  {
	
	$server->selectDB('logondb');
	$value = mysql_real_escape_string($_GET['user']);
	$result = mysql_query("SELECT * FROM account WHERE username='".$value."' OR id='".$value."'");
	if(mysql_num_rows($result)==0) {
		echo "<span class='red_text'>Nenhum resultado encontrado!</span>";
	} else {
		$row = mysql_fetch_assoc($result);?>
		<table width="100%">
			<tr>
			<td><span class='blue_text'>Nome da conta</span></td><td> <?php echo ucfirst(strtolower($row['username']));?> (<?php echo $row['last_ip']; ?>)</td>
			<td><span class='blue_text'>Entrou</span></td><td><?php echo $row['joindate']; ?></td>
			</tr>
			<tr>
				<td><span class='blue_text'>Endereço de e-mail</span></td><td><?php echo $row['email'];?></td>
				<td><span class='blue_text'>Pontos de Votação</span></td><td><?php  echo $account->getVP($row['id']); ?></td>
			</tr>
			<tr>
				<td><span class='blue_text'>Situação da conta</span></td><td><?php echo $account->getBan($row['id']); ?></td>
				<td><span class='blue_text'><?php echo $GLOBALS['donation']['coins_name']; ?></span></td><td><?php echo $account->getDP($row['id']); ?></td>
			</tr>
			<tr>
			<td><a href='?p=users&s=manage&getlogs=<?php echo $row['id']; ?>'>Pagamentos da conta e Registros da Loja</a><br />
            <a href='?p=users&s=manage&getslogs=<?php echo $row['id']; ?>'>Registros de Serviços</a></td>
			<td></td>
			<td><a href='?p=users&s=manage&editaccount=<?php echo $row['id']; ?>'>Editar as informações da conta</a></tr>
			</table>
            <hr/>
            <b>Personagens</b><br/>
            <table>
            <tr>
            	<th width="32">Guid</th>
                <th width="40">Nome</th>
                <th width="36">Nível</th>
                <th width="45">Classe</th>
                <th width="36">Raça</th>
                <th width="40">Reino</th>
                <th width="57">Situação</th>
                <th width="74">Ações</th>
            </tr>
            <?php
			 $server->selectDB('webdb');
			 $result = mysql_query("SELECT name,id FROM realms");
			 while($row = mysql_fetch_assoc($result))
			 {
				$acct_id = $account->getAccID($_GET['user']);
				$server->connectToRealmDB($row['id']);
				$result = mysql_query("SELECT name,guid,level,class,race,gender,online FROM characters WHERE account='".(int)$_GET['user']."'
				OR account='".$acct_id."'");
				 
				while($rows = mysql_fetch_assoc($result))
				{
					?>
                    <tr class="center">
                    	<td><?php echo $rows['guid']; ?></td>
                        <td><?php echo $rows['name']; ?></td>
                        <td><?php echo $rows['level']; ?></td>
                        <td><img src="../styles/global/images/icons/class/<?php echo $rows['class']; ?>.gif" /></td>
                        <td><img src="../styles/global/images/icons/race/<?php echo $rows['race'].'-'.$rows['gender']; ?>.gif" /></td>
                        <td><?php echo $row['name']; ?></td>
                        <td>
                        <?php
						if($rows['online']==1)
							echo '<font color="#009900">Online</font>';
						else
							echo '<font color="#990000">Offline</font>';	
						?>
                        </td>
                        <td><a href="#" onclick="characterListActions('<?php echo $rows['guid']; ?>','<?php echo $row['id']; ?>')">Listar ações</a></td>
                    </tr>
                    <?php 
				}
			 }
			 ?>
             </table>
            <hr/>
		<?php
	}
 }
elseif(isset($_GET['getlogs'])) {
	?>
	Conta selecionada: <a href='?p=users&s=manage&user=<?php echo $_GET['getlogs']; ?>'><?php echo $account->getAccName($_GET['getlogs']); ?></a>
	<p />
	
	<h4 class='payments' onclick='loadPaymentsLog(<?php echo (int)$_GET['getlogs']; ?>)'>Registros de pagamentos</h4>
	<div class='hidden_content' id='payments'></div>
	<hr/>
	<h4 class='payments' onclick='loadDshopLog(<?php echo (int)$_GET['getlogs']; ?>)'>Registros da Loja de Doação</h4>
	<div class='hidden_content' id='dshop'></div>
	<hr/>
	<h4 class='payments' onclick='loadVshopLog(<?php echo (int)$_GET['getlogs']; ?>)'>Registros da Loja de Votação</h4>
	<div class='hidden_content' id='vshop'></div>
	<?php
}
elseif(isset($_GET['editaccount'])) {
   ?>Conta selecionada: <a href='?p=users&s=manage&user=<?php echo $_GET['editaccount']; ?>'><?php echo $account->getAccName($_GET['editaccount']); ?></a>
	<p />
   <table width="100%">
	<input type="hidden" id="account_id" value="<?php echo $_GET['editaccount']; ?>" />
		   <tr>
		     <td>E-mail</td> <td><input type="text" id="edit_email" class='noremove' 
		   value="<?php echo $account->getEmail($_GET['editaccount']); ?>"/> </tr> 
		   <tr>
		     <td>Definir senha</td><td><input type="text" id="edit_password" class='noremove'/></td></tr>
		   <tr>
		     <td>Pontos de Votação</td> <td><input type="text" id="edit_vp" value="<?php echo $account->getVP($_GET['editaccount']); ?>" class='noremove'/> </tr>
		   <tr><td><?php echo $GLOBALS['donation']['coins_name']; ?></td> 
									<td><input type="text" id="edit_dp" value="<?php echo $account->getDP($_GET['editaccount']); ?>" class='noremove'/></td></tr>
		   <tr><td></td><td><input type="submit" value="Salvar" onclick="save_account_data()"/></td></tr>
   </table>
   <hr/>
<?php } 
 elseif(isset($_GET['getslogs'])) {
	?>
	Conta selecionada: <a href='?p=users&s=manage&user=<?php echo $_GET['getslogs']; ?>'><?php echo $account->getAccName($_GET['getslogs']); ?></a>
	<p />
	<table>
    	<tr>
        	<th>Serviço</th>
            <th>Descrição</th>
            <th>Reino</th>
            <th>Data</th>
        </tr>
        <?php
		$server->selectDB('webdb');
		$result = mysql_query("SELECT * FROM user_log WHERE account='".(int)$_GET['getslogs']."'");
		if(mysql_num_rows($result)==0)
			echo 'Nenhum registro encontrado desta conta!';
		else
		{
			while($row = mysql_fetch_assoc($result))
			{
				echo '<tr class="center">';
					echo '<td>'.$row['service'].'</td>';
					echo '<td>'.$row['desc'].'</td>';
					echo '<td>'.$server->getRealmName($row['realmid']).'</td>';
					echo '<td>'.date('Y-m-d H:i',$row['timestamp']).'</td>';
				echo '</tr>';
			}
		}
		?>
    </table>
    <hr/>
<?php
}
?>
<table width="100%">
  			<tr>
            	<td>Nome de Usuário ou ID: </td>	
                <form action="" method="get">
                <input type="hidden" name="p" value="users">
                <input type="hidden" name="s" value="manage">
                <td><input type="text" name="user"></td><td><input type="submit" value="Go"></td>
            </tr></form>
            
            <tr>
                <td>Nome do Personagem ou GUID: </td>	
                <form action="" method="get">
                <input type="hidden" name="p" value="users">
                <input type="hidden" name="s" value="manage">
                <td><input type="text" name="char"></td><td><input type="submit" value="Go"></td>
           </tr></form>
</table>