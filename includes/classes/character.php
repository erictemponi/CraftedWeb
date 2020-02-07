<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
class character {
	
	public static function unstuck($guid,$char_db) 
	{
		$guid = (int)$guid;
		$rid = server::getRealmId($char_db);
		connect::connectToRealmDB($rid);
		
        if(character::isOnline($guid)==TRUE) 
			echo '<b class="red_text">Por favor, deslogue o personagem antes de continuar.';
		else 
		{
			if($GLOBALS['service']['unstuck']['currency']=='vp')
			{
				if(account::hasVP($_SESSION['cw_user'],$GLOBALS['service']['unstuck']['price'])==FALSE) 
					die('<b class="red_text">Pontos de Votação insuficiente!</b>' );
				else
					account::deductVP(account::getAccountID($_SESSION['cw_user']),$GLOBALS['service']['unstuck']['price']);	
		}
		
			if($GLOBALS['service']['unstuck']['currency']=='dp')
			{
				if(account::hasDP($_SESSION['cw_user'],$GLOBALS['service']['unstuck']['price'])==FALSE) 
					die('<b class="red_text">Insuficiente '.$GLOBALS['donation']['coins_name'].'</b>');
				else
					account::deductDP(account::getAccountID($_SESSION['cw_user']),$GLOBALS['service']['unstuck']['price']);
		}
			
		$getXYZ = mysql_query("SELECT * FROM character_homebind WHERE guid='".$guid."'"); 
		$row = mysql_fetch_assoc($getXYZ);
		
		$new_x = $row['posX']; 
		$new_y = $row['posY']; 
		$new_z = $row['posZ']; 
		$new_zone = $row['zoneId']; 
		$new_map = $row['mapId'];
		
		mysql_query("UPDATE characters SET position_x='".$new_x."', position_y='".$new_y."', 
		position_z='".$new_z."', zone='".$new_zone."',map='".$new_map."' WHERE guid='".$guid."'");
		
		account::logThis("Unstuck realizado em ".character::getCharName($guid,$rid),'Unstuck',$rid);
		
		return TRUE;
	  }
	}
	
	public static function revive($guid,$char_db) 
	{
		$guid = (int)$guid;
		$rid = server::getRealmId($char_db);
		connect::connectToRealmDB($rid);
		
		if(character::isOnline($guid)==TRUE) 
			echo '<b class="red_text">Por favor, deslogue o personagem antes de continuar.';
	    else 
		{
			if($GLOBALS['service']['revive']['currency']=='vp')
			{
				if(account::hasVP($_SESSION['cw_user'],$GLOBALS['service']['unstuck']['price'])==FALSE) 
					die('<b class="red_text">Pontos de Votação insuficiente!</b>');
				else
					account::deductVP(account::getAccountID($_SESSION['cw_user']),$GLOBALS['service']['revive']['price']);	
			}
		
		if($GLOBALS['service']['revive']['currency']=='dp')
		{
			if(account::hasDP($_SESSION['cw_user'],$GLOBALS['service']['unstuck']['price'])==FALSE) 
				die( '<b class="red_text">Insuficiente '.$GLOBALS['donation']['coins_name'].'</b>' );
			else
				account::deductDP(account::getAccountID($_SESSION['cw_user']),$GLOBALS['service']['revive']['price']);	
		}
			
		    mysql_query("DELETE FROM character_aura WHERE guid = '".$guid."' AND spell = '20584' OR guid = '".$guid."' AND spell = '8326'");
			
			account::logThis("Realizado o reviver em ".character::getCharName($guid,$rid),'Reviver',$rid);
			
			return TRUE;
	  }
	}
	
	public static function instant80($values) 
	{
		die("Este recurso está desativado. <br/><i>Além disso, você não deveria estar aqui...</i>");
		$values = mysql_real_escape_string($values);
		$values = explode("*",$values);
		
		connect::connectToRealmDB($values[1]);
		
		if(character::isOnline($values[0])==TRUE) 
			echo '<b class="red_text">Por favor, deslogue seu personagem antes de continuar.';
		else 
		{
		$service_values = explode("*",$GLOBALS['service']['instant80']);
		if ($service_values[1]=="dp") 
		{
			if(account::hasDP($_SESSION['cw_user'],$GLOBALS['service']['instant80']['price'])==FALSE) 
			{
				echo '<b class="red_text">Insuficiente '.$GLOBALS['donation']['coins_name'].'</b>';
				$error = true;
			}
		} 
		elseif($service_values[1]=="vp") 
		{
			if(account::hasVP($_SESSION['cw_user'],$GLOBALS['service']['instant80']['price'])==FALSE) 
			{
				echo '<b class="red_text">Pontos de Votação insuficiente.</b>';
				$error = true;
			}
		} 
		
		if ($error!=true) 
		{
			//User got coins. Boost them up to 80 :D
			connect::connectToRealmDB($values[1]);
			mysql_query("UPDATE characters SET level='80' WHERE guid = '".$values[0]."'");
			
			account::logThis("Realizado o nível máximo instantâneo em ".character::getCharName($values[0],NULL),'Instantâneo',NULL);
			
			echo '<h3 class="green_text">O nível do personagem foi definido para 80!</h3>';
		}
	}
 }
 
 public static function isOnline($char_guid) 
 {
	 $char_guid = (int)$char_guid;
	 $result = mysql_query("SELECT COUNT('guid') FROM characters WHERE guid='".$char_guid."' AND online=1");
	 if (mysql_result($result,0)==0) 
		 return FALSE;
	 else 
		 return TRUE;
  }
  
  public static function getRace($value) 
  {
	  switch($value) 
	  {
		 default:
			 return "Desconhecido";
		 break;
		 #######
		 case(1):
		 	return "Humano";
		 break;
		 #######		 
		 case(2):
		 	return "Orc";
		 break;
		 #######
		 case(3):
			 return "Anão";
		 break;
		 #######
		 case(4):
		 	return "Elfo Noturno";
		 break;
		 #######
		 case(5):
		 	return "Morto-vivo";
		 break; 
		 #######
		 case(6):
			 return "Tauren";
		 break;
		 #######
		 case(7):
		 	return "Gnomo";
		 break;
		 #######
		 case(8):
		 	return "Troll";
		 break;
		 #######
		 case(9):
			 return "Goblin";
		 break;
		 #######
		 case(10):
			return "Elfo Sangrento";
		 break;
		 #######
		 case(11):
		 	return "Draenei";
		 break;
		 #######
		 case(22):
			 return "Worgen";
		 break;
         #######
	  }
  }
  
  public static function getGender($value) 
  {
	 if($value==1) 
		 return 'Feminino';
	 elseif($value==0)
		 return 'Masculino';
	 else 
		 return 'Desconhecido';
  }
  
  public static function getClass($value) 
  {
	  switch($value) 
	  {
		 default:
		 	return "Desconhecido";
		 break;
		 #######
		 case(1):
		 	return "Guerreiro";
		 break;
		 #######
		 case(2):
		 	return "Paladino";
		 break;
		 #######
		 case(3):
			 return "Caçador";
		 break;
		 #######
		 case(4):
			 return "Ladino";
		 break;
		 #######
		 case(5):
			 return "Sacerdote";
		 break;
		 #######
		 case(6):
		 	return "Cavaleiro da Morte";
		 break;
		 #######
		 case(7):
			 return "Xamã";
		 break;
		 #######
		 case(8):
		 	return "Mago";
		 break;
		 #######
		 case(9):
		 	return "Bruxo";
		 break;
		 #######
		 case(11):
		 	return "Druida";
		 break;
		 ####### 
		 #######
		 case(12):
		 	return "Monge";
		 break;
		 ####### 
	  }
  }
  
  public static function getClassIcon($value) 
  {   
	  return '<img src="styles/global/images/icons/class/'.$value.'.gif" />';
  }
  
  public static function getFactionIcon($value) 
  {
	   $a = array(1,3,4,7,11,22);
	   $h = array(2,5,6,8,9,10);
	   
	   if(in_array($value,$a)) 
		   return '<img src="styles/global/images/icons/faction/0.gif" />';
	   elseif(in_array($value,$h)) 
		   return '<img src="styles/global/images/icons/faction/1.gif" />';
  }

   public static function getCharName($id,$realm_id) 
   {
		$id = (int)$id;
		connect::connectToRealmDB($realm_id);
		
		$result = mysql_query("SELECT name FROM characters WHERE guid='".$id."'");
		$row = mysql_fetch_assoc($result);
		return $row['name'];	
	}

    public static function isAccountCharacter($char_guid, $acct_id)
    {
        $char_guid = (int)$char_guid;
        $acct_id = (int)$acct_id;
        $result = mysql_query("SELECT COUNT('guid') FROM characters WHERE guid='{$char_guid}' AND account = '{$acct_id}'");
        if (mysql_result($result,0)==0)
            return FALSE;
        else
            return TRUE;
    }
}