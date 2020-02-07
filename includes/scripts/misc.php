<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */

 

require('../ext_scripts_class_loader.php');

if(isset($_POST['element']) &&$_POST['element'] =='vote') 
{
   echo 'Pontos de Votação: '.account::loadVP($_POST['account']);
}
#################
elseif(isset($_POST['element']) && $_POST['element']=='donate') 
{
   echo $GLOBALS['donation']['coins_name'].': '.account::loadDP($_POST['account']);
}
#################
if(isset($_POST['action']) && $_POST['action']=='removeComment') 
{
   connect::selectDB('webdb');
   mysql_query("DELETE FROM news_comments WHERE id='".(int)$_POST['id']."'");
}
#################
if(isset($_POST['action']) && $_POST['action']=='getComment') 
{
   connect::selectDB('webdb');
   $result = mysql_query("SELECT `text` FROM news_comments WHERE id='".(int)$_POST['id']."'");
   $row = mysql_fetch_assoc($result);
   echo $row['text'];
}
#################
if(isset($_POST['action']) && $_POST['action']=='editComment') 
{
   $content = mysql_real_escape_string(trim(htmlentities($_POST['content'])));
	
   connect::selectDB('webdb');
   mysql_query("UPDATE news_comments SET `text` = '".$content."' WHERE id='".(int)$_POST['id']."'");
   
   mysql_query("INSERT INTO admin_log (full_url, ip, timestamp, action, account, extended_inf) 
   VALUES('/index.php?page=news','".$_SERVER['REMOTE_ADDR']."', '".time()."', 'Comentário editado', '".$_SESSION['cw_user_id']."', 
   'ID do comentário editado: ".(int)$_POST['id']."')");
}
#################
if(isset($_POST['getTos'])) 
{
   include("../../documents/termsofservice.php");
   echo $tos_message;
}
#################
if(isset($_POST['getRefundPolicy'])) 
{
   include("../../documents/refundpolicy.php");
   echo $rp_message;
}
#################
if(isset($_POST['serverStatus'])) 
{
   echo '<div class="box_one_title">Situação do Servidor</div>';
		 $num = 0;
		 foreach ($GLOBALS['realms'] as $k => $v) {
			 if ($num != 0) { echo "<hr/>"; }
			   server::serverStatus($k);
			   $num++;
		   }
		   if ($num == 0) {
			 buildError("<b>Nenhum reino encontrado: </b> Por favor, configure seu Banco de Dados e adicione um reino!",NULL);  
			 echo "Nenhum reino encontrado.";
		   }
		unset($num);
?>
<hr/>
<span id="realmlist">Set Realmlist <?php echo $GLOBALS['connection']['realmlist']; ?></span>
</div>
<?php   
}
#################
if(isset($_POST['convertDonationList']))
{
	for ($row = 0; $row < count($GLOBALS['donationList']); $row++)
		{
				$value = (int)$_POST['convertDonationList'];
				if($value == $GLOBALS['donationList'][$row][1])
				{
					echo $GLOBALS['donationList'][$row][2];
					exit();
				}
		}
}

?>