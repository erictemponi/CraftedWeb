<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 

$service = $_GET['s'];
$serviceBR;

switch($service) {
	case 'appearance':
		$serviceBR = 'a Aparência';
		break;
	case 'name':
		$serviceBR = 'o Nome';
		break;
	case 'faction':
		$serviceBR = 'a Facção';
		break;
	case 'race':
		$serviceBR = 'a Raça';
		break;
	default:
		$serviceBR = 'não sei o quê';
}

$service_title = 'Alterar '.$serviceBR;

if($GLOBALS['service'][$service]['status']!="TRUE") 
	echo "Esta página está indisponível.";
else
{
	if(isset($_GET['service'])&&$_GET['service']=='applied')
	{
		echo '<div class="box_two_title">Serviço aplicado!</div>';
		echo 'O serviço foi aplicado com sucesso no personagem selecionado. Você terá que relogar, deletando a pasta Cache do diretório do seu WoW para notar as alterações.';
		echo '<p/>Sua ação foi registrada no nosso Banco de Dados no caso de você precisar de alguma ajuda.';
	}
	else
	{
?>
<div class="box_two_title"><?php echo $service_title; ?></div>
Escolha o personagem no qual você deseja aplicar este serviço.
<?php
if($GLOBALS['service'][$service]['price']==0) 
      	echo '<span class="attention">'.$service_title.' é gratuito.</span>';
else
{ ?>
<span class="attention"><?php echo $service_title; ?> custa 
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
$result = mysql_query('SELECT char_db,name,id FROM realms ORDER BY id ASC');
while($row = mysql_fetch_assoc($result)) 
{
         $acct_id = account::getAccountID($_SESSION['cw_user']);
		 $realm = $row['name'];
		 $char_db = $row['char_db'];
		 $realm_id = $row['id'];
		          	
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
                <img src="styles/global/images/portraits/<?php echo $row['gender'].'-'.$row['race'].'-'.$row['class']; ?>.gif" border="none">
                    <?php } ?>
                </td>
                
                <td width="220"><h3><?php echo $row['name']; ?></h3>
					<?php echo character::getRace($row['race'])." ".character::getClass($row['class'])." Nível ".$row['level'].
                    " <br>Sexo ".character::getGender($row['gender']); ?>
                </td>
                
                <td>Reino: <?php echo $realm; ?>
					<?php if($row['online']==1)
                   echo "<br/><span class='red_text'>Por favor, deslogue antes de aplicar este serviço.</span>";?>
                </td>
                
                <td align="right"> &nbsp; <input type="submit" value="Selecionar" 
				   <?php if($row['online']==0) { ?> 
                   onclick='nstepService(<?php echo $row['guid']; ?>,<?php echo $realm_id; ?>,"<?php echo $service; ?>","<?php echo $service_title; ?>"
                   ,"<?php echo $row['name']; ?>")' <?php }
                   else { echo 'disabled="disabled"'; } ?>>
               </td>
            </tr>                         
	</table>
    </div> 
	<?php 
		$num++;
	}
   }
  }
}
?>
