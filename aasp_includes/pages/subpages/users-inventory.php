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
<div class="box_right_title"><?php echo $page->titleLink(); ?> &raquo; Inventário dos Personagens</div>
Mostrando o inventário do personagem
<a href="?p=users&s=viewchar&guid=<?php echo $_GET['guid']; ?>&rid=<?php echo $_GET['rid']; ?>">
	<?php echo $account->getCharName($_GET['guid'],$_GET['rid']); ?>
</a>
<hr/>
Filtro:
	   <a href="?p=users&s=inventory&guid=<?php echo $_GET['guid']; ?>&rid=<?php echo $_GET['rid']; ?>&f=equip">
		<?php if(isset($_GET['f']) && $_GET['f']=='equip') echo '<b>'; ?>Itens Equipados</a><?php if(isset($_GET['f']) && $_GET['f']=='equip') echo '</b>'; ?> 
    &nbsp; | 
&nbsp; <a href="?p=users&s=inventory&guid=<?php echo $_GET['guid']; ?>&rid=<?php echo $_GET['rid']; ?>&f=bank">
		<?php if(isset($_GET['f']) && $_GET['f']=='bank') echo '<b>'; ?>Itens no Banco<?php if(isset($_GET['f']) && $_GET['f']=='bank') echo '</b>'; ?></a> 
    &nbsp; | 
&nbsp; <a href="?p=users&s=inventory&guid=<?php echo $_GET['guid']; ?>&rid=<?php echo $_GET['rid']; ?>&f=keyring">
		<?php if(isset($_GET['f']) && $_GET['f']=='keyring') echo '<b>'; ?>Itens no Chaveiro<?php if(isset($_GET['f']) && $_GET['f']=='keyring') echo '</b>'; ?>
        </a> 
     &nbsp; | 
&nbsp; <a href="?p=users&s=inventory&guid=<?php echo $_GET['guid']; ?>&rid=<?php echo $_GET['rid']; ?>&f=currency">
		<?php if(isset($_GET['f']) && $_GET['f']=='currency') echo '<b>'; ?>Moedas<?php if(isset($_GET['f']) && $_GET['f']=='currency') echo '</b>'; ?></a> 
     &nbsp; | 
&nbsp; <a href="?p=users&s=inventory&guid=<?php echo $_GET['guid']; ?>&rid=<?php echo $_GET['rid']; ?>">
		<?php if(!isset($_GET['f'])) echo '<b>'; ?>Todos os Itens<?php if(!isset($_GET['f'])) echo '</b>'; ?></a> 
<p/>
<?php
$server->connectToRealmDB($_GET['rid']);
$equip_array = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18);

$result = mysql_query("SELECT guid,itemEntry,`count` FROM item_instance WHERE owner_guid='".(int)$_GET['guid']."'");
if(mysql_num_rows($result)==0)
	echo 'Nenhum item encontrado!';
else
{	
 echo '<table cellspacing="3" cellpadding="5">';
 while($row = mysql_fetch_assoc($result)) 
 {
	$entry = $row['itemEntry'];
	
	if(isset($_GET['f']))
	{
		if($_GET['f'] == 'equip') 
		{
			$getPos = mysql_query("SELECT slot,bag FROM character_inventory WHERE item='".$row['guid']."' AND bag='0' 
			AND slot IN(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18) AND guid='".(int)$_GET['guid']."'");
		}
		elseif($_GET['f'] == 'bank') 
		{
			$getPos = mysql_query("SELECT slot,bag FROM character_inventory WHERE item='".$row['guid']."'
			AND slot>=39 AND slot<=73");	
		}
		elseif($_GET['f'] == 'keyring') 
		{
			$getPos = mysql_query("SELECT slot,bag FROM character_inventory WHERE item='".$row['guid']."'
			AND slot>=86 AND slot<=117");	
		}
		elseif($_GET['f'] == 'currency') 
		{
			$getPos = mysql_query("SELECT slot,bag FROM character_inventory WHERE item='".$row['guid']."'
			AND slot>=118 AND slot<=135");	
		}
	}
	else
	{
		$getPos = mysql_query("SELECT slot,bag FROM character_inventory WHERE item='".$row['guid']."'");
	}
	
	if(mysql_result($getPos,0)>0)
	{
		$pos = mysql_fetch_assoc($getPos);
		
		$server->selectDB('worlddb');
		$get = mysql_query("SELECT name,entry,quality,displayid FROM item_template WHERE entry='".$entry."'");
		$r = mysql_fetch_assoc($get);
		
		 $server->selectDB('webdb');
		 $getIcon = mysql_query("SELECT icon FROM item_icons WHERE displayid='".$r['displayid']."'");
		 if(mysql_num_rows($getIcon)==0) 
		 {
			 //No icon found. Probably cataclysm item. Get the icon from wowhead instead.
			 $sxml = new SimpleXmlElement(file_get_contents('http://www.wowhead.com/item='.$entry.'&xml'));
			  
			  $icon = strtolower(mysql_real_escape_string($sxml->item->icon));
			  //Now that we have it loaded. Add it into database for future use.
			  //Note that WoWHead XML is extremely slow. This is the main reason why we're adding it into the db.
			  mysql_query("INSERT INTO item_icons VALUES('".$row['displayid']."','".$icon."')");
		 }
		 else 
		 {
		   $iconrow = mysql_fetch_assoc($getIcon);
		   $icon = strtolower($iconrow['icon']);
		 }
	
		$server->connectToRealmDB($_GET['rid']);
		
		?>
			<tr bgcolor="#e9e9e9">
				<td width="36"><img src="http://static.wowhead.com/images/wow/icons/medium/<?php echo $icon; ?>.jpg"></td>
				<td>
					<a href="http://<?php echo $GLOBALS['tooltip_href']; ?>item=<?php echo $r['entry']; ?>" title="" target="_blank"><?php echo $r['name']; ?></a>
				</td>
				<td>x<?php echo $row['count']; ?> 
				
				<?php 
				if(!isset($_GET['f']))
				{
					if(in_array($pos['slot'], $equip_array) && $pos['bag']==0) echo '(Equipado)';
					if($pos['slot']>= 39 && $pos['slot'] <= 73) echo '(Banco)'; 
					if($pos['slot']>= 86 && $pos['slot'] <= 117) echo '(Chaveiro)'; 
					if($pos['slot']>= 118 && $pos['slot'] <= 135) echo '(Moedas)'; 
				}
				?>
            </td>
        </tr>
    <?php
 	}
 }
 echo '</table>';
}
?>