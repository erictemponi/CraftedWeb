<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
define('INIT_SITE', TRUE);
include('../../includes/misc/headers.php');
include('../../includes/configuration.php');
include('../functions.php');
$server = new server;
$account = new account;

$server->selectDB('webdb');

###############################
if($_POST['action']=="payments") 
{
		$result = mysql_query("SELECT paymentstatus,mc_gross,datecreation FROM payments_log WHERE userid='".(int)$_POST['id']."'");
		if(mysql_num_rows($result)==0)
			echo "<b color='red'>Nenhum pagamento desta conta foi encontrado.</b>";
		else 
		{
		?> <table width="100%">
               <tr>
                   <th>Quantidade </th>
                   <th>Situação do Pagamento</th>
                   <th>Data</th>
               </tr>
           <?php
		while($row = mysql_fetch_assoc($result)) 
		{ ?>
			<tr>
                 <td><?php echo $row['mc_gross'];?>$</td>
                 <td><?php echo $row['paymentstatus']; ?></td>
                 <td><?php echo $row['datecreation']; ?></td>   
            </tr>
		<?php }
		echo '</table>';
		}
	}
###############################	
elseif($_POST['action']=='dshop') 
{
		$result = mysql_query("SELECT entry,char_id,date,amount,realm_id FROM shoplog WHERE account='".(int)$_POST['id']."' AND shop='donate'");
		if(mysql_num_rows($result)==0)
			echo "<b color='red'>Não foi encontrado nenhum registro desta conta.</b>";
		else 
		{
		?> <table width="100%">
               <tr>
                   <th>Item</th>
                   <th>Personagem</th>
                   <th>Data/th>
                   <th>Valor</th>
               </tr>
           <?php
		while($row = mysql_fetch_assoc($result)) { ?>
			<tr>
                 <td><a href="http://<?php echo $GLOBALS['tooltip_href']; ?>item=<?php echo $row['entry']; ?>" title="" target="_blank">
				 	 <?php echo $server->getItemName($row['entry']);?></a></td>
                 <td><?php echo $account->getCharName($row['char_id'],$row['realm_id']); ?></td>
                 <td><?php echo $row['date']; ?></td>   
                 <td>x<?php echo $row['amount']; ?></td>
            </tr>
		<?php }
		echo '</table>';
		}
	}
###############################	
elseif($_POST['action']=='vshop') 
{
		$result = mysql_query("SELECT entry,char_id,realm_id,date,amount FROM shoplog WHERE account='".(int)$_POST['id']."' AND shop='vote'");
		if(mysql_num_rows($result)==0)
			echo "<b color='red'>Não foi encotrada nenhum registro desta conta.</b>";
		else 
		{
		?> <table width="100%">
               <tr>
              	 <th>Item</th>
                 <th>Personagem</th>
                 <th>Data</th>
                 <th>Valor</th>
               </tr>
           <?php
		while($row = mysql_fetch_assoc($result)) { ?>
			<tr>
                 <td><a href="http://<?php echo $GLOBALS['tooltip_href']; ?>item=<?php echo $row['entry']; ?>" title="" target="_blank">
				 	 <?php echo $server->getItemName($row['entry']);?></a></td>
                 <td><?php echo $account->getCharName($row['char_id'],$row['realm_id']); ?></td>
                 <td><?php echo $row['date']; ?></td>
                 <td>x<?php echo $row['amount']; ?></td>   
            </tr>
		<?php }
		echo '</table>';
		}
	}	
###############################	
elseif($_POST['action']=="search") 
{
	$input = mysql_real_escape_string($_POST['input']);
	$shop = mysql_real_escape_string($_POST['shop']);
	?>
    <table width="100%">
    <tr>
        <th>Usuário</th>
        <th>Personagem</th>
        <th>Reino</th>
        <th>Item</th>
        <th>Data</th>
        <th>Quantidade</th>
    </tr>
	
	<?php 
	//Procurar pelo nome do personagem...
	$loopRealms = mysql_query("SELECT id FROM realms");
	while($row = mysql_fetch_assoc($loopRealms)) 
	{
		   $server->connectToRealmDB($row['id']);
		   $result = mysql_query("SELECT guid FROM characters WHERE name LIKE '%".$input."%'");
		   if(mysql_num_rows($result)>0) {
		   $row = mysql_fetch_assoc($result);
		   $server->selectDB('webdb');
		   $result = mysql_query("SELECT * FROM shoplog WHERE shop='".$shop."' AND char_id='".$row['guid']."'"); 
           
            while($row = mysql_fetch_assoc($result)) { ?>
		<tr class="center">
            <td><?php echo $account->getAccName($row['account']); ?></td>
            <td><?php echo $account->getCharName($row['char_id'],$row['realm_id']); ?></td>
            <td><?php echo $server->getRealmName($row['realm_id']); ?></td>
            <td><a href="http://<?php echo $GLOBALS['tooltip_href']; ?>item=<?php echo $row['entry']; ?>" title="" target="_blank">
			<?php echo $server->getItemName($row['entry']); ?></a></td>
            <td><?php echo $row['date']; ?></td>
            <td>x<?php echo $row['amount']; ?></td>   
        </tr>	
		<?php } } }?>
        
        
        <?php 
	        //Procurar pelo nome da conta
	       $server->selectDB('logondb');
		   $result = mysql_query("SELECT id FROM account WHERE username LIKE '%".$input."%'");
		   if(mysql_num_rows($result)>0) {
		   $row = mysql_fetch_assoc($result);
		   $server->selectDB('webdb');
		   $result = mysql_query("SELECT * FROM shoplog WHERE shop='".$shop."' AND account='".$row['id']."'"); 
           
            while($row = mysql_fetch_assoc($result)) { ?>
		<tr class="center">
            <td><?php echo $account->getAccName($row['account']); ?></td>
            <td><?php echo $account->getCharName($row['char_id'],$row['realm_id']); ?></td>
            <td><?php echo $server->getRealmName($row['realm_id']); ?></td>
            <td><a href="http://<?php echo $GLOBALS['tooltip_href']; ?>item=<?php echo $row['entry']; ?>" title="" target="_blank">
			<?php echo $server->getItemName($row['entry']); ?></a></td>
            <td><?php echo $row['date']; ?></td>
            <td>x<?php echo $row['amount']; ?></td>   
        </tr>	
		<?php } } ?>
        
        
        <?php 
	        //Procurar pelo nome do item
	       $server->selectDB('worlddb');
		   $result = mysql_query("SELECT entry FROM item_template WHERE name LIKE '%".$input."%'");
		   if(mysql_num_rows($result)>0) {
		   $row = mysql_fetch_assoc($result);
		   $server->selectDB('webdb');
		   $result = mysql_query("SELECT * FROM shoplog WHERE shop='".$shop."' AND entry='".$row['entry']."'"); 
           
            while($row = mysql_fetch_assoc($result)) { ?>
		<tr class="center">
            <td><?php echo $account->getAccName($row['account']); ?></td>
            <td><?php echo $account->getCharName($row['char_id'],$row['realm_id']); ?></td>
            <td><?php echo $server->getRealmName($row['realm_id']); ?></td>
            <td><a href="http://<?php echo $GLOBALS['tooltip_href']; ?>item=<?php echo $row['entry']; ?>" title="" target="_blank">
			<?php echo $server->getItemName($row['entry']); ?></a></td>
            <td><?php echo $row['date']; ?></td>
            <td>x<?php echo $row['amount']; ?></td>   
        </tr>	
		<?php } } ?>
        
        <?php 
	        //Search via date
			$server->selectDB('webdb');
		    $result = mysql_query("SELECT * FROM shoplog WHERE shop='".$shop."' AND date LIKE '%".$input."%'"); 
           
            while($row = mysql_fetch_assoc($result)) { ?>
		<tr class="center">
            <td><?php echo $account->getAccName($row['account']); ?></td>
            <td><?php echo $account->getCharName($row['char_id'],$row['realm_id']); ?></td>
            <td><?php echo $server->getRealmName($row['realm_id']); ?></td>
            <td><a href="http://<?php echo $GLOBALS['tooltip_href']; ?>item=<?php echo $row['entry']; ?>" title="" target="_blank">
			<?php echo $server->getItemName($row['entry']); ?></a></td>
            <td><?php echo $row['date']; ?></td>
            <td>x<?php echo $row['amount']; ?></td>   
        </tr>	
        
        
		<?php } 
		if($input=="Procurar...") 
		{
			 //Visualizar os 10 últimos registros
			$server->selectDB('webdb');
		   $result = mysql_query("SELECT * FROM shoplog WHERE shop='".$shop."' ORDER BY id DESC LIMIT 10"); 
           
            while($row = mysql_fetch_assoc($result)) { ?>
		<tr class="center">
            <td><?php echo $account->getAccName($row['account']); ?></td>
            <td><?php echo $account->getCharName($row['char_id'],$row['realm_id']); ?></td>
            <td><?php echo $server->getRealmName($row['realm_id']); ?></td>
            <td><a href="http://<?php echo $GLOBALS['tooltip_href']; ?>item=<?php echo $row['entry']; ?>" title="" target="_blank">
			<?php echo $server->getItemName($row['entry']); ?></a></td>
            <td><?php echo $row['date']; ?></td>
            <td>x<?php echo $row['amount']; ?></td>   
        </tr>	
			<?php } }
		 ?>
        
</table>
    <?php
}
###############################

?>