<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
?>
<div class='box_two_title'>Unstuck Personagem</div>
Escolha o personagem em que você deseja realizar o Unstuck. O personagem será teleportado para o local de seu nascimento.<hr/>
<?php
$service = "unstuck";

if($GLOBALS['service'][$service]['price']==0) 
      echo '<span class="attention">Unstuck é gratuito.</span>';
else
{ ?>
<span class="attention">Custos do Unstuck 
<?php 
echo $GLOBALS['service'][$service]['price'].' '.website::convertCurrency($GLOBALS['service'][$service]['currency']); ?></span>
<?php 
if($GLOBALS['service'][$service]['currency']=="vp")
	echo "<span class='currency'>Pontos de Votação: ".account::loadVP($_SESSION['cw_user'])."</span>";
elseif($GLOBALS['service'][$service]['currency']=="dp")
	echo "<span class='currency'>".$GLOBALS['donation']['coins_name'].": ".account::loadDP($_SESSION['cw_user'])."</span>";
} 

account::isNotLoggedIn();
connect::selectDB('webdb');
$num = 0;
$result = mysql_query('SELECT char_db,name FROM realms ORDER BY id ASC');
while($row = mysql_fetch_assoc($result)) 
{
	$acct_id = account::getAccountID($_SESSION['cw_user']);
	$realm = $row['name'];
	$char_db = $row['char_db'];
		          	
	connect::selectDB($char_db);
	$result = mysql_query('SELECT name,guid,gender,class,race,level,online FROM characters WHERE account='.$acct_id);
	while($row = mysql_fetch_assoc($result)) {
	?><div class='charBox'>
    <table width="100%">
	        <tr>
                <td width="73">
                <?php if(!file_exists('styles/global/images/portraits/'.$row['gender'].'-'.$row['race'].'-'.$row['class'].'.gif'))
				       echo '<img src="styles/'.$GLOBALS['template']['path'].'/images/unknown.png" />';
					   else 
					   { ?>
                <img src="styles/global/images/portraits/
					<?php echo $row['gender'].'-'.$row['race'].'-'.$row['class']; ?>.gif" border="none">
                    <?php } ?>
                </td>
                
                <td width="160"><h3><?php echo $row['name']; ?></h3>
					<?php echo $row['level']." ".character::getRace($row['race'])." ".character::getGender($row['gender']).
                    " ".character::getClass($row['class']); ?>
                </td>
                
                <td>Reino: <?php echo $realm; ?>
					<?php if($row['online']==1)
                   echo "<br/><span class='red_text'>Please log out before trying to unstuck.</span>";?>
                </td>
                
                <td align="right"> &nbsp; <input type="submit" value="Unstuck" 
				   <?php if($row['online']==0) { ?> 
                   onclick='unstuck(<?php echo $row['guid']; ?>,"<?php echo $char_db; ?>")' <?php }
                   else { echo 'disabled="disabled"'; } ?>>
               </td>
            </tr>                         
	</table>
    </div> <?php 
	
	$num++;
}
}
?>