<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
class server {
	
	public function getRealmId($char_db)
	{
		connect::selectDB('webdb');
		$get = mysql_query("SELECT id FROM realms WHERE char_db='".mysql_real_escape_string($char_db)."'");
		$row = mysql_fetch_assoc($get);
		return $row['id'];
	}
	
	public function getRealmName($char_db)
	{
		connect::selectDB('webdb');
		$get = mysql_query("SELECT name FROM realms WHERE char_db='".mysql_real_escape_string($char_db)."'");
		$row = mysql_fetch_assoc($get);
		return $row['name'];
	}
	
	public static function serverStatus($realm_id) 
	{
		//Get status
	    $fp = fsockopen($GLOBALS['realms'][$realm_id]['host'], $GLOBALS['realms'][$realm_id]['port'], $errno, $errstr, 5);
		if (!$fp) 
		   echo $status = '<h4 class="realm_status_title_offline">'.$GLOBALS['realms'][$realm_id]['name'].' -  Offline</h4>';
		else 
		{
		   echo $status = '<h4 class="realm_status_title_online">'.$GLOBALS['realms'][$realm_id]['name'].' - Online</h4>';
			 
       echo '<span class="realm_status_text">';
	   
	   /* Players online bar */
	   if($GLOBALS['serverStatus']['factionBar']==TRUE) 
	   {   
		   connect::connectToRealmDB($realm_id);
		   $getChars = mysql_query("SELECT COUNT(online) FROM characters WHERE online=1");
		   $total_online = mysql_result($getChars,0);
	   
		   $getAlliance = mysql_query("SELECT COUNT(online) FROM characters WHERE online=1 AND race IN('3','4','7','11','1','22')");
		   $alliance = mysql_result($getAlliance,0);
		   
		   $getHorde = mysql_query("SELECT COUNT(online) FROM characters WHERE online=1 AND race IN('2','5','6','8','10','9')");
		   $horde = mysql_result($getHorde,0);
	   
		   if($total_online == 0) 
		   {
			  $per_alliance = 50; 
			  $per_horde = 50;
		   }
		   else
		   {
			   if($alliance == 0)
				   $per_alliance = 0;
			   else
				   $per_alliance = round(($alliance / $total_online) * 100);
			   
			   if($horde == 0)
				   $per_horde = 0;  
			   else
				   $per_horde = round(($horde / $total_online) * 100);
		   }
	   
	   if($per_alliance + $per_horde > 100) 
		   $per_horde = $per_horde - 1 ;
	   
	   ?>
           <div class='srv_status_po'>
                  <div class='srv_status_po_alliance' style="width: <?php echo $per_alliance; ?>%;"></div>
                  <div class='srv_status_po_horde' style="width: <?php echo $per_horde; ?>%;"></div>
                  <div class='srv_status_text'>Aliança: <?php echo $alliance;?> &nbsp;  Horda: <?php echo $horde;?></div>
           </div>
	   <?php
	    }
	    echo '<table width="100%"><tr>';
		//Get players online
		if ($GLOBALS['serverStatus']['playersOnline']==TRUE) 
		{
			connect::connectToRealmDB($realm_id);
			$getChars = mysql_query("SELECT COUNT(online) FROM characters WHERE online=1");
			$pOnline = mysql_result($getChars,0);
			if ($pOnline == 1) 
			{
				echo '<td><b>1</b> Jogador Online</td>';
			}
			else {
				echo '<td><b>',$pOnline,'</b> Jogadores Online</td>';
			}
		}
		
		//Get uptime
		if ($GLOBALS['serverStatus']['uptime']==TRUE) 
		{	
			connect::selectDB('logondb');
			$getUp = mysql_query("SELECT starttime FROM uptime WHERE realmid='".$realm_id."' ORDER BY starttime DESC LIMIT 1"); 
			$row = mysql_fetch_assoc($getUp); 
			       
			$time = time();
			$uptime = $time - $row['starttime'];
			
			 echo '
			       <td>
			       	   <b>'.convTime($uptime).'</b> online
				   </td>
			       </tr>';
			}
	}
	if ($GLOBALS['serverStatus']['nextArenaFlush']==TRUE) 
	{
		//Arena flush
		 connect::connectToRealmDB($realm_id);
		 $getFlush = mysql_query("SELECT value FROM worldstates WHERE comment='NextArenaPointDistributionTime'");
		 $row = mysql_fetch_assoc($getFlush);
		 $flush = date('d M H:i', $row['value']);
			 
		 echo '<tr>
		 	   <td>
			   	   Próximo reset nas arenas: <b>'.$flush.'</b>
			   </td>';
	}
	echo '</tr>
	      </table>
		  </span>';
  }
}
?>