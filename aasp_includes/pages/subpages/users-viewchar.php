<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
?>
<?php $page = new page; $server = new server; $account = new account; $character = new character; ?>
<div class="box_right_title"><?php echo $page->titleLink(); ?> &raquo; Gerenciar Personagem</div>
Personagem selecionado:  <?php echo $account->getCharName($_GET['guid'],$_GET['rid']); ?>
<?php
$server->connectToRealmDB($_GET['rid']);

$usersTotal = mysql_query("SELECT name,race,account,class,level,money,leveltime,totaltime,online,latency,gender FROM characters WHERE guid='".$_GET['guid']."'");
$row = mysql_fetch_assoc($usersTotal);
?>
<hr/>
<table style="width: 100%;">
<tr>
    <td>Nome do Personagem</td>
    <td><input type="text" value="<?php echo $row['name']; ?>" class="noremove" id="editchar_name"/></td>
</tr>
<tr>
    <td>Conta</td>
    <td><input type="text" value="<?php echo $account->getAccName($row['account']); ?>" class="noremove" id="editchar_accname"/>
    <a href="?p=users&s=manage&user=<?php echo strtolower($account->getAccName($row['account'])); ?>">Visualizar</a></td>
</tr>
<tr>
    <td>Raça</td>
    <td>
    	<select id="editchar_race">
    	  <option value="1">Humano</option>
    	  <option value="3">Anão</option>
            <option value="4">Elfo Noturno</option>
            <option value="7">Gnomo</option>
            <option value="11">Draenei</option>
             <?php if($GLOBALS['core_expansion']>=3) ?>
            	<option <?php if($row['race']==22) echo 'selected'; ?> value="22">Worgen</option>
            <option <?php if($row['race']==2) echo 'selected'; ?> value="2">Orc</option>
            <option <?php if($row['race']==6) echo 'selected'; ?> value="6">Tauren</option>
            <option <?php if($row['race']==8) echo 'selected'; ?> value="8">Troll</option>
            <option value="5">Morto-vivo</option>
            <option value="10">Elfo Sangrento</option>
            <?php if($GLOBALS['core_expansion']>=3) ?>
            	<option <?php if($row['race']==9) echo 'selected'; ?> value="9">Goblin</option>
            <?php if($GLOBALS['core_expansion']>=4) ?>
            	<option <?php if($row['race']==NULL) echo 'selected'; ?> value="NULL">Pandaren</option>    
        </select>
    </td>
</tr>
<tr>   
    <td>Classe</td>
    <td>
    	<select id="editchar_class">
    	  <option value="1">Guerreiro</option>
    	  <option value="2">Paladino</option>
    	  <option value="11">Druida</option>
    	  <option value="3">Caçador</option>
    	  <option value="5">Sacerdote</option>
    	  <option value="6">Cavaleiro da Morte</option>
    	  <option value="9">Bruxo</option>
    	  <option value="7">Xamã</option>
    	  <option value="4">Ladino</option>
    	  <option value="8">Mago</option>
    	  <option value="12">Monge</option>
             <?php if($GLOBALS['core_expansion']>=2) ?>
            <?php if($GLOBALS['core_expansion']>=4) ?>
</select>
    </td>
</tr>
<tr>   
    <td>Sexo</td>
    <td>
    	<select id="editchar_gender">
    	  <option value="0">Masculino</option>
    	  <option value="1">Feminino</option>
        </select>
    </td>
</tr>
<tr>
    <td>Nível</td>
    <td><input type="text" value="<?php echo $row['level']; ?>" class="noremove" id="editchar_level"/></td>
</tr>
<tr>    
    <td>Dinheiro (Ouro)</td>
    <td><input type="text" value="<?php echo floor($row['money'] / 10000); ?>" class="noremove" id="editchar_money"/></td>
</tr>
<tr>
    <td>Tempo upando</td>
    <td><input type="text" value="<?php echo $row['leveltime']; ?>" disabled="disabled"/></td>
</tr>
<tr>    
    <td>Tempo Total</td>
    <td><input type="text" value="<?php echo $row['totaltime']; ?>" disabled="disabled"/></td>
</tr>
<tr>
    <td>Situação</td>
    <td>
	<?php if ($row['online']==0)
				  echo '<input type="text" value="Offline" disabled="disabled"/>';
			  else
			  	  echo '<input type="text" value="Online" disabled="disabled"/>'; 
	?>              
    </td>
</tr>
<tr>    
    <td>Latência</td>
    <td><input type="text" value="<?php echo $row['latency']; ?>" disabled="disabled"/></td>
</tr>
<tr>
	<td></td>
    <td><input type="submit" value="Salvar" onclick="editChar('<?php echo $_GET['guid']; ?>','<?php echo $_GET['rid']; ?>')"/> 
    	<i>* Nota</i>: Você não pode editar todos os dados se o personagem estiver online.</td>
</tr>
</table>
<hr/>