<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 

require('../ext_scripts_class_loader.php');

if (!isset($_SESSION['cw_user']))
    die('Acesso inválido!');

$acct_id = account::getAccountID($_SESSION['cw_user']);

if($_POST['action']=='unstuck') 
{
	$guid = (int)$_POST['guid'];
	$realm_id = server::getRealmId($_POST['char_db']);
	connect::connectToRealmDB($realm_id);
    if (character::isAccountCharacter($guid, $acct_id)==FALSE)
        die('<b class="red_text">Este personagem não pertence a você!');

	character::unstuck($guid,$_POST['char_db']);
}	

if($_POST['action']=='revive') 
{
	$guid = (int)$_POST['guid'];
	$realm_id = server::getRealmId($_POST['char_db']);
	connect::connectToRealmDB($realm_id);
    if (character::isAccountCharacter($guid, $acct_id)==FALSE)
        die('<b class="red_text">Este personagem não pertence a você!');

	character::revive($guid,$_POST['char_db']);
}	

if ($_POST['action']=='getLocations') 
{
	$values = explode('*',$_POST['values']);
	
	$char = mysql_real_escape_string($values[0]);
	$realm_id = server::getRealmId($values[1]);
	connect::connectToRealmDB($realm_id);
	
	$result = mysql_query("SELECT race FROM characters WHERE guid='".$char."'");
	$row = mysql_fetch_assoc($result);
	$alliance = array(1,3,4,7,11);
	if (in_array($row['race'],$alliance)) 
	{
		//Alliance
		$locations_name = array( 1  => "Ventobravo" , 2 => "Altaforja", 3 => "Darnassus", 4 => "Exodar", 5 => "Dalaran", 6 => "Shattrath");
        $locations_image = array("Ventobravo" => "spell_arcane_teleportstormwind", "Altaforja" => "spell_arcane_teleportironforge", "Darnassus"  => "spell_arcane_teleportdarnassus", 
		"Exodar" => "spell_arcane_teleportexodar","Dalaran" => "spell_arcane_teleportdalaran", "Shattrath" => "spell_arcane_teleportshattrath");
	} else {
		//Horde
		$locations_name = array( 1  => "Orgrimmar" , 2 => "Cidade Baixa", 3 => "Penhasco do Trovão", 4 => "Luaprata", 5 => "Dalaran", 6 => "Shattrath");
        $locations_image = array("Orgrimmar" => "spell_arcane_teleportorgrimmar", "Cidade Baixa" => "spell_arcane_teleportundercity", 
		"Penhasco do Trovão"  => "spell_arcane_teleportthunderbluff", "Luaprata" => "spell_arcane_teleportsilvermoon", "Dalaran" => "spell_arcane_teleportdalaran", 
		"Shattrath" => "spell_arcane_teleportshattrath");
	}
	echo '<h3>Escolha o Local</h3>';
	foreach ($locations_name as $v) 
	{
	 ?>
        <div class="charBox" style="cursor:pointer;" onclick="portTo('<?php echo $v; ?>','<?php echo $values[1]; ?>','<?php echo $values[0]; ?>')">
        <table width="100%">
               <tr> <td width="15%"><img src="styles/global/images/icons/<?php echo $locations_image[$v]?>.jpg" /></td>
               <td align="left" width="90%"><b><?php echo $v; ?></b><br/>
                </td>
               </tr>
        </table>
        </div>
<?php }
}

if ($_POST['action']=='teleport') 
{
	$character = mysql_real_escape_string($_POST['character']);
	$char_db = mysql_real_escape_string($_POST['char_db']);
	$location = mysql_real_escape_string($_POST['location']);
	
    $realm_id = server::getRealmId($_POST['char_db']);
	connect::connectToRealmDB($realm_id);
    $result = mysql_query("SELECT race, level, online, name, position_x, position_y, position_z, map FROM characters WHERE guid='".$character."' AND account='{$acct_id}'");
    
	if (mysql_num_rows($result) == 0)
		die("<span class='alert'>O personagem não existe nessa conta!</span>");
		
	else 
	{
	$row = mysql_fetch_assoc($result);
	
	if($row['online']==1)
		die("Por favor, deslogue antes de continuar.");

	$race = $row['race'];
	$level = $row['level'];

        $char_name = $row['name'];
        $char_x = $row['position_x'];
        $char_y = $row['position_y'];
        $char_z = $row['position_z'];
        $char_map = $row['map'];
        $from = "X: ".$char_x." - Y: ".$char_y." - Z: ".$char_z." - ID do Mapa: ".$char_map;

	 if($GLOBALS['service']['teleport']['currency']=="vp" && $GLOBALS['service']['teleport']['price']>0) 
	 {
		 if(account::hasVP($_SESSION['cw_user'],$GLOBALS['service']['teleport']['price'])==FALSE)
		     die("Pontos de Votação insuficientes!");
	 } 
	 elseif($GLOBALS['service']['teleport']['currency']=="dp" && $GLOBALS['service']['teleport']['price']>0) 
	 {
		  if(account::hasDP($_SESSION['cw_user'],$GLOBALS['service']['teleport']['price'])==FALSE)
		     die($GLOBALS['donation']['coins_name']." Insuficientes!");
	 }
    	
	$map = $x = $y = $z = NULL;
	
	switch($location)
	{
		//stormwind
		case "Ventobravo":
			$map = "0";
			$x = "-8921.019531";
			$y = "547.346985";
			$z = "94.191597";
			break;
		//ironforge
		case "Altaforja":
			$map = "0";
			$x = "-4981.25";
			$y = "-881.542";
			$z = "501.66";
			break;
		//darnassus
		case "Darnassus":
			$map = "1";
			$x = "9951.52";
			$y = "2280.32";
			$z = "1341.39";
			break;
		//exodar
		case "Exodar":
			$map = "530";
			$x = "-3987.29";
			$y = "-11846.6";
			$z = "-2.01903";
			break;
		//orgrimmar
		case "Orgrimmar":
			$map = "1";
			$x = "1434.260010";
			$y = "-4397.500000";
			$z = "25.462500";
			break;
		//thunderbluff
		case "Penhasco do Trovão":
			$map = "1";
			$x = "-1196.22";
			$y = "29.0941";
			$z = "176.949";
			break;
		//undercity
		case "Cidade Baixa":
			$map = "0";
			$x = "1586.48";
			$y = "239.562";
			$z = "-52.149";
			break;
		//silvermoon
		case "Luaprata":
			$map = "530";
			$x = "9473.03";
			$y = "-7279.67";
			$z = "14.2285";
			break;
		//shattrath
		case "Shattrath":
			$map = "530";
			$x = "-1863.03";
			$y = "4998.05";
			$z = "-21.1847";
			break;
		//dalaran
		case "Dalaran":
			$map = "571";
			$x = "5804.149902";
			$y = "624.770996";
			$z = "647.767029";
			break;	
	} 

	//disallows factions to use enemy portals
	switch($race)
	{
		//alliance
		case 1:
		case 3:
		case 4:
		case 7:
		case 11:
			if((($location >=5) && ($location <=8)) && ($location != 9))
				die("<span class='alert'>Os jogadores da Aliança <b>NÃO</b> podem teleportar para áreas da Horda!</span>");	
			break;
		//horde
		case 2:
		case 5:
		case 6:
		case 8:
		case 10:
			if ((($location >=1) && ($location <=4)) && ($location != 9))
				die("<span class='alert'>Os jogadores da Horda <b>NÃO</b> podem teleportar para áreas da Aliança!</span>");
			break;
		default:
			die("<span class='alert'>Essa não é uma Raça válida!</span>");
			break;
	}
	
	if ($location == "Dalaran" && $level < 68)
		die("Abortando...<br/><span class='alert'>Seu personagem deve estar no nível 68 ou superior para se teleportar para Nortúndria!</span>");

	if($GLOBALS['service']['teleport']['currency']=="vp")
        account::deductVP($acct_id,$GLOBALS['service']['teleport']['price']);
	elseif($GLOBALS['service']['teleport']['currency']=="dp")
        account::deductDP($acct_id,$GLOBALS['service']['teleport']['price']);
	
	connect::connectToRealmDB($realm_id);

        mysql_query("UPDATE characters SET position_x = ".$x.", position_y= ".$y.", position_z = ".$z.", map = ".$map." WHERE account = ".$acct_id. " AND guid = '".$character."'");
     
	 if($GLOBALS['service']['teleport']['currency']=="vp")
		 echo $GLOBALS['service']['teleport']['price']." Pontos de Votação foram retirados da sua conta.";
	 elseif($GLOBALS['service']['teleport']['currency']=="dp")
		echo $GLOBALS['service']['teleport']['price']." ".$GLOBALS['donation']['coins_name']." foram retirados da sua conta.";

        account::logThis($char_name." foi teleportado de ".$from." para ".$location,'Teleportar',$realm_id);
	
		//echo true;
	}
	
}

if($_POST['action']=='service') 
{
	$guid = (int)$_POST['guid'];
	$realm_id = (int)$_POST['realm_id'];
	$serviceX = mysql_real_escape_string($_POST['service']);
    connect::connectToRealmDB($realm_id);

    if (character::isAccountCharacter($guid, $acct_id)==FALSE)
        die('<b class="red_text">Este personagem não pertence a você!');
	
	if(character::isOnline($guid)==TRUE) 
			die('<b class="red_text">Por favor, deslogue seu personagem antes de continuar.');
	
	if($GLOBALS['service'][$serviceX]['currency']=='vp')
	{
		if(account::hasVP($_SESSION['cw_user'],$GLOBALS['service'][$serviceX]['price'])==FALSE)
			die('<b class="red_text">Pontos de Votação Insuficientes!</b>');
	}
	
	if($GLOBALS['service'][$serviceX]['currency']=='dp')
	{
		if(account::hasDP($_SESSION['cw_user'],$GLOBALS['service'][$serviceX]['price'])==FALSE)
			die('<b class="red_text">'.$GLOBALS['donation']['coins_name'].' Insuficientes</b>');
	}
	
	switch($serviceX)
	{
		default:
			die("Erro Desconhecido");
		break;
		
		case('appearance'):
			$command = "customize";
			$info = "Personalizar a aparência";
		break;
		
		case('name'):
			$command = "rename";
			$info = "Alterar o nome";
		break;
		
		case('faction'):
			$command = "changefaction";
			$info = "Alterar a facção";
		break;
		
		case('race'):
		 	$command = "changerace";
			$info = "Alterar a raça";
		break;
		
	}
	
	connect::selectDB('webdb');
	$getRA = mysql_query("SELECT sendType,host,ra_port,soap_port,rank_user,rank_pass FROM realms WHERE id='".$realm_id."'");
	$row = mysql_fetch_assoc($getRA);
	
	if($row['sendType']=='ra') 
	{
		 require('../misc/ra.php');
		 
		 sendRa("character ".$command." ".character::getCharname($guid,$realm_id),
		 $row['rank_user'],$row['rank_pass'],$row['host'],$row['ra_port']);

    } 
	elseif($row['sendType']=="soap") 
	{
		 require('../misc/soap.php');
		 
		 sendSoap("character ".$command." ".character::getCharname($guid,$realm_id),
		 $row['rank_user'],$row['rank_pass'],$row['host'],$row['soap_port']);
    }
	
	if($GLOBALS['service'][$serviceX]['currency']=='vp')
		account::deductVP(account::getAccountID($_SESSION['cw_user']),$GLOBALS['service'][$serviceX]['price']);
	
	if($GLOBALS['service'][$serviceX]['currency']=='dp')
		account::deductDP(account::getAccountID($_SESSION['cw_user']),$GLOBALS['service'][$serviceX]['price']);
		
		account::logThis("No próximo login, você poderá ".$info." do personagem ".character::getCharName($guid,$realm_id),$serviceX,$realm_id);
	
	//echo true;
}

?>