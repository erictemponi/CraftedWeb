<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
if(!isset($_SESSION)) 
	session_start();

if(isset($_SESSION['cw_staff']) && !isset($_SESSION['cw_staff_id']))
{
	exit('Parece que está faltando uma ou mais sessões. Você foi desconectado devido a razões de segurança.');	
	session_destroy();
}

if(isset($_SESSION['cw_admin']) && !isset($_SESSION['cw_admin_id']))
{
	exit('Parece que está faltando uma ou mais sessões. Você foi desconectado devido a razões de segurança.');	
	session_destroy();
}
	
class server 
{
	public function getConnections() 
	{
		$this->selectDB('logondb');
		
		$result = mysql_query("SELECT COUNT(id) FROM account WHERE online='1'");
		return mysql_result($result,0);
	}
	
	public function getPlayersOnline($rid) 
	{	
	    $this->connectToRealmDB($rid);
	    $result = mysql_query("SELECT COUNT(guid) FROM characters WHERE online='1'");
	    return round(mysql_result($result,0));
	}
	
	public function getUptime($rid) 
	{	
	   $this->selectDB('logondb');
	   
	   $getUp = mysql_query("SELECT starttime FROM uptime WHERE realmid='".(int)$rid."' ORDER BY starttime DESC LIMIT 1"); 
	   $row = mysql_fetch_assoc($getUp); 
			   
	   $time = time();
	   $uptime = $time - $row['starttime'];
	   
		if($uptime<60) 
			$string = 'Segundos';
		elseif ($uptime > 60) 
		{
			$uptime = $uptime / 60;
			$string = 'Minutos'; 
			if ($uptime > 60) 
			{									 
				$string = 'Horas';
				$uptime = $uptime / 60;
			if ($uptime > 24) 
			{
				$string = 'Dias';
				$uptime = $uptime / 24;
			}
			}
			$uptime = ceil($uptime);
		}
		return $uptime.' '.$string;
	}
	
	public function getServerStatus($rid)
	{
		$this->selectDB('webdb');
		
		$result = mysql_query("SELECT host,port FROM realms WHERE id='".(int)$rid."'");
		$row = mysql_fetch_assoc($result);
		
		$fp = fsockopen($row['host'], $row['port'], $errno, $errstr, 1);
		if (!$fp) 
		   return '<font color="#990000">Offline</font>';
		else 
		 	return 'Online';
	}
	
	public function getGMSOnline() 
	{
		$this->selectDB('logondb');
		$result = mysql_query("SELECT COUNT(id) FROM account WHERE username IN ( select username FROM account WHERE online IN ('1')) 
		AND id IN (SELECT id FROM account_access WHERE gmlevel>'1');");
		
		return mysql_result($result,0);
	}
	
	public function getAccountsCreatedToday() 
	{
		$this->selectDB('logondb');
		$result = mysql_query("SELECT COUNT(id) FROM account WHERE joindate LIKE '%".date("Y-m-d")."%'");
		return mysql_result($result,0);
	}
	
	public function getActiveAccounts() 
	{
		$this->selectDB('logondb');
		$result = mysql_query("SELECT COUNT(id) FROM account WHERE last_login LIKE '%".date("Y-m")."%'");
		return mysql_result($result,0);
	}
	
	public function getActiveConnections() 
	{
		$this->selectDB('logondb');
		$result = mysql_query("SELECT COUNT(id) FROM account WHERE online=1");
		return mysql_result($result,0);
	}
	
	public function getFactionRatio($rid) 
	{
		$this->selectDB('webdb');
		$result = mysql_query("SELECT id FROM realms");
		if(mysql_num_rows($result)==0) 
			$this->faction_ratio = "Desconhecido";
		else 
		{
			$t = 0;
			$a = 0;
			$h = 0;
			while($row=mysql_fetch_assoc($result))
			{
				$this->connectToRealmDB($row['id']);
			    $result = mysql_query("SELECT COUNT(*) FROM characters");
				$t = $t + mysql_result($result,0);
				
				$result = mysql_query("SELECT COUNT(*) FROM characters WHERE race IN('3','4','7','11','1','22')");
				$a = $a + mysql_result($result,0);
				
				$result = mysql_query("SELECT COUNT(*) FROM characters WHERE race IN('2','5','6','8','10','9')");
				$h = $h + mysql_result($result,0);
			}
			$a = ($a / $t)*100;
			$h = ($h / $t)*100;
			return '<font color="#0066FF">'.round($a).'%</font> &nbsp; <font color="#CC0000">'.round($h).'%</font>';
		}
	}
	
	public function getAccountsLoggedToday() 
	{
		$this->selectDB('logondb');
		
		$result = mysql_query("SELECT COUNT(*) FROM account WHERE last_login LIKE '%".date('Y-m-d')."%'");
		return mysql_result($result,0);
	}
	
	public function connect() 
	{
		mysql_connect($GLOBALS['connection']['host'],$GLOBALS['connection']['user'],$GLOBALS['connection']['password']);
	}
	
	public function connectToRealmDB($realmid) 
	{ 
		$this->selectDB('webdb');
		$getRealmData = mysql_query("SELECT mysql_host,mysql_user,mysql_pass,char_db FROM realms WHERE id='".(int)$realmid."'");
		if(mysql_num_rows($getRealmData)>0)
		{
			$row = mysql_fetch_assoc($getRealmData);
			if($row['mysql_host'] != $GLOBALS['connection']['host'] || $row['mysql_user'] != $GLOBALS['connection']['user'] 
			|| $row['mysql_pass'] != $GLOBALS['connection']['password'])
			{
				mysql_connect($row['mysql_host'],$row['mysql_user'],$row['mysql_pass'])or 
				buildError("<b>Erro de conexão com o Banco de Dados:</b> A conexão não pode ser estabelecida com o Reino. Erro: ".mysql_error(),NULL);
			}
			else
				$this->connect();

			mysql_select_db($row['char_db'])or 
				buildError("<b>Erro na seleção do Banco de Dados:</b> O Banco de Dados do Reino não pode ser selecionado. Erro: ".mysql_error(),NULL);
		}
	}
	
	public function selectDB($db) 
	{
		$this->connect();
		
		switch($db) {
			default: 
				mysql_select_db($db);
			break;
			case('logondb'):
				mysql_select_db($GLOBALS['connection']['logondb']);
			break;
			case('webdb'):
				mysql_select_db($GLOBALS['connection']['webdb']);
			break;
			case('worlddb'):
				mysql_select_db($GLOBALS['connection']['worlddb']);
			break;
		}
	}
	
	public function getItemName($id) 
	{
		$this->selectDB('worlddb');
		
		$result = mysql_query("SELECT name FROM item_template WHERE entry='".$id."'");
		$row = mysql_fetch_assoc($result);
		return $row['name'];
	}
	
	public function getAddress() 
	{
		return $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }
	
	public function logThis($action,$extended = NULL) 
	{
		$this->selectDB('webdb');
		$url = $this->getAddress();
		
		if(isset($_SESSION['cw_admin']))
			$aid = (int)$_SESSION['cw_admin_id'];
		elseif(isset($_SESSION['cw_staff']))
			$aid = (int)$_SESSION['cw_staff_id'];	
		
		mysql_query("INSERT INTO admin_log VALUES ('','".mysql_real_escape_string($url)."','".$_SERVER['REMOTE_ADDR']."',
		'".time()."','".mysql_real_escape_string($action)."','".$aid."','".mysql_real_escape_string($extended)."')");
	}
	
	public function addRealm($id,$name,$desc,$host,$port,$chardb,$sendtype,$rank_user,$rank_pass,$ra_port,$soap_port,$m_host,$m_user,$m_pass) 
	{
		$id = (int)$id;
		$name = mysql_real_escape_string($name);
		$desc = mysql_real_escape_string($desc);
		$host = mysql_real_escape_string($host);
		$port = mysql_real_escape_string($port);
		$chardb = mysql_real_escape_string($chardb);
		$sendtype = mysql_real_escape_string($sendtype);
		$rank_user = mysql_real_escape_string($rank_user);
		$rank_pass = mysql_real_escape_string($rank_pass);
		$ra_port = mysql_real_escape_string($ra_port);
		$soap_port = mysql_real_escape_string($soap_port);
		$m_host = mysql_real_escape_string($m_host);
		$m_user = mysql_real_escape_string($m_user);
		$m_pass = mysql_real_escape_string($m_pass);
		
		if (empty($name) || empty($host) || empty($port) || empty($chardb) || empty($rank_user) || empty($rank_pass))
			echo "<pre><b class='red_text'>Por favor, insira todos os campos obrigatórios!</b></pre><br/>";
		else 
		{
			if(empty($m_host))
				$m_host = $GLOBALS['connection']['host'];
			if(empty($m_user))
				$m_host = $GLOBALS['connection']['user'];
			if(empty($m_pass))
				$m_pass = $GLOBALS['connection']['password'];		
			
			if (empty($ra_port))
				$ra_port = 3443;
			if (empty($soap_port))
				$soap_port = 7878;
			
		   $this->selectDB('webdb');
		  mysql_query("INSERT INTO realms VALUES ('".$id."','".$name."','".$desc."','".$chardb."','".$port."',
		  '".$rank_user."','".$rank_pass."','".$ra_port."','".$soap_port."','".$host."','".$sendtype."','".$m_host."',
		  '".$m_user."','".$m_pass."')");
		  
		  $this->logThis("Adicionado o Reino ".$name."<br/>");
		  
			echo '<pre><h3>&raquo; Adicionado com sucesso o Reino '.$name.'!</h3></pre><br/>';
		}
	}
	
	public function getRealmName($realm_id) 
	{
		$this->selectDB('webdb');
		
		$result = mysql_query("SELECT name FROM realms WHERE id='".(int)$realm_id."'");
		$row = mysql_fetch_assoc($result);
		
		if(empty($row['name']))
		   return '<i>Desconhecido</i>';
		else   
		   return $row['name'];
	}
	
	public function checkForNotifications() 
	{
		/* Not used! */
		$this->selectDB('webdb');
		
		//Check for old votelogs
		$old = time() - 2592000;
		$result = mysql_query("SELECT COUNT(*) FROM votelog WHERE `timestamp` <= ".$old."");
			
		if(mysql_result($result,0)>1)
		{
			echo '<div class="box_right">
        		  <div class="box_right_title">Notificações</div>';
			echo 'Você tem '.mysql_result($result,0).' registros de votação de 30 dias ou mais. E que não são necessários. 
					 Sugerimos que você limpe seus registros. ';	  
			echo '</div>';
		}
	}	
	
	public function serverStatus()
	{
		if(!isset($_COOKIE['presetRealmStatus']))
		{
			$this->selectDB('webdb');
			$getRealm = mysql_query('SELECT id FROM realms ORDER BY id ASC LIMIT 1');
			$row = mysql_fetch_assoc($getRealm);
			
			$rid = $row['id'];
		}
		else
			$rid = $_COOKIE['presetRealmStatus'];
		
		echo 'Reino selecionado: <b>'.$this->getRealmName($rid).'</b> <a href="#" onclick="changePresetRealmStatus()">(Alterar Reino)</a><hr/>';
		 ?>
        <table>
               <tr valign="top">
                   <td width="70%">Situação do Servidor: <br/>
                        Tempo de Atividade: <br/>
                        Jogadores Online: <br/>
                   </td>
                   <td>
                   <b>
                   	   <?php echo $this->getServerStatus($rid);?><br/>
                       <?php echo $this->getUptime($rid);?><br/>
                       <?php echo $this->getPlayersOnline($rid);?><br/>
                   </b>
                   </td>
               </tr>
            </table>
            <hr/>
            <b>Situação Geral:</b><br/>
            <table>
               <tr valign="top">
                   <td width="70%">Conexões ativas: <br/>
                        Contas criadas hoje: <br/>
                        Contas ativas (Este mês)</td>
                   <td>
                   <b>
                       <?php echo $this->getActiveConnections();?><br/>
                       <?php echo $this->getAccountsCreatedToday();?><br/>
                       <?php echo $this->getActiveAccounts();?><br/>
                   </b>
                   </td>
               </tr>
            </table>
      
        <?php
	 }
}

class account 
{
	public function getAccID($user) 
	{
		$server = new server;
		$server->selectDB('logondb');
		
		$user = mysql_real_escape_string($user);
		$result = mysql_query("SELECT id FROM account WHERE username='".mysql_real_escape_string($user)."'");
		$row = mysql_fetch_assoc($result);
		
        return $row['id'];
	}
	
	public function getAccName($id) 
	{
		$server = new server;
		$server->selectDB('logondb');
		
		$result = mysql_query("SELECT username FROM account WHERE id='".(int)$id."'");
		$row = mysql_fetch_assoc($result);
		
		if(empty($row['username']))
		   return '<i>Desconhecido</i>';
		else
		   return ucfirst(strtolower($row['username']));
	}
	
	public function getCharName($id,$realm_id) 
	{
		$server = new server;
		
		$server->connectToRealmDB($realm_id);	
		
		$result = mysql_query("SELECT name FROM characters WHERE guid='".(int)$id."'");
		if(mysql_num_rows($result)==0)
		   return '<i>Desconhecido</i>';
		else
		{   
		$row = mysql_fetch_assoc($result);
		   if(empty($row['name'])) 
		      return '<i>Desconhecido</i>';
		    else  
		      return $row['name'];
		}
	}
	
	public function getEmail($id) 
	{
		$server = new server;
		$server->selectDB('logondb');
		
		$result = mysql_query("SELECT email FROM account WHERE id='".(int)$id."'");
		$row = mysql_fetch_assoc($result);
		return $row['email'];
	}
	
	public function getVP($id) 
	{
		$server = new server;
		$server->selectDB('webdb');
		
		$result = mysql_query("SELECT vp FROM account_data WHERE id='".(int)$id."'");
		if(mysql_num_rows($result)==0)
			return 0;

		$row = mysql_fetch_assoc($result);
		return $row['vp'];
	}
	
	public function getDP($id) 
	{
		$server = new server;
		$server->selectDB('webdb');
		
		$result = mysql_query("SELECT dp FROM account_data WHERE id='".(int)$id."'");
		if(mysql_num_rows($result)==0)
			return 0;

		$row = mysql_fetch_assoc($result);
		return $row['dp'];
	}
	
	public function getBan($id) 
	{
		$server = new server;
		$server->selectDB('logondb');
		
		$result = mysql_query("SELECT * FROM account_banned WHERE id='".(int)$id."' AND active = 1 ORDER by bandate DESC LIMIT 1");
		if(mysql_num_rows($result)==0)
			return "<span class='green_text'>Ativo</span>";

		$row = mysql_fetch_assoc($result);
		if($row['unbandate'] < $row['bandate'])
			$time = "Nunca";
		else
			$time = date("Y-m-d H:i", $row['unbandate']);

		return 
		"<font size='-4'><b class='red_text'>Banido</b><br/>
		Data do desbanimento: <b>".$time."</b><br/>
		Banido por: <b>".$row['bannedby']."</b><br/>
		Motivo: <b>".$row['banreason']."</b></font>
		";
	}
	
	private function downloadFile ($url, $path) 
	{
	  /* Not used! */
	  $newfname = $path;
	  $file = fopen ($url, "rb");
	  if ($file) 
	  {
		$newf = fopen ($newfname, "wb");
	
		if ($newf)
		{
		while(!feof($file)) 
		{
		  fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
		}
	   }
	  }
	
	  if ($file) 
		fclose($file);
	
	  if ($newf) 
		fclose($newf);
	 }
	 
}


class page { 

   public function validateSubPage() 
   {
	   if(isset($_GET['s']) && !empty($_GET['s']))
		  return TRUE;  
	   else
		  return FALSE;  
   }
   
   public function validatePageAccess($page) {
	   if(isset($_SESSION['cw_staff']) && !isset($_SESSION['cw_admin']))
	   {
		   if($GLOBALS['staffPanel_permissions'][$page]!=true) 
		   {
			 header("Location: ?p=notice&e=<h2>Não autorizado!</h2>
					Você não tem permissão para visualizar esta página!");
               exit;
		   }
	   }
   }
	
	public function outputSubPage($panel) 
	{
		 $page = $_GET['p'];
		 $subpage = $_GET['s'];  
		 $pages = scandir('../aasp_includes/pages/subpages');
		 unset($pages[0],$pages[1]);
		 
		 if (!file_exists('../aasp_includes/pages/subpages/'.$page.'-'.$subpage.'.php'))
			 include('../aasp_includes/pages/404.php');
		 elseif(in_array($page.'-'.$subpage.'.php',$pages))
			 include('../aasp_includes/pages/subpages/'.$page.'-'.$subpage.'.php');
		 else
			  include('../aasp_includes/pages/404.php');
	}
	
	public function titleLink() 
	{
		return '<a href="?p='.$_GET['p'].'" title="Voltar para '.ucfirst($_GET['p']).'">'.ucfirst($_GET['p']).'</a>';
	}
	
	public function addSlideImage($upload,$path,$url) 
	{
		$path = mysql_real_escape_string($path);
		$url = mysql_real_escape_string($url);
		
		if(empty($path)) 
		{
			//No path set, upload image.
			if($upload['error']>0) 
			{
				echo "<span class='red_text'><b>Erro:</b> O envio de arquivos não foi bem sucedido!</span>";
				$abort = true;
			}
			else 
			{
				if ((($upload["type"] == "image/gif")
					|| ($upload["type"] == "image/jpeg")
					|| ($upload["type"] == "image/pjpeg")
					|| ($upload["type"] == "image/png")))
					{
						if (file_exists("../styles/global/slideshow/images/" . $upload["name"]))
						  {
						    unlink("../styles/global/slideshow/images/" . $upload["name"]);
							move_uploaded_file($upload["tmp_name"],"../styles/global/slideshow/images/" . $upload["name"]);
						    $path = "styles/global/slideshow/images/" . $upload["name"];
						  }
						else
						  {
						  move_uploaded_file($upload["tmp_name"],"../styles/global/slideshow/images/" . $upload["name"]);
						  $path = "styles/global/slideshow/images/" . $upload["name"];
						  }
					} 
					else
						$abort = true;
			}
		} 
		else 
			$path = $path;

		if(!isset($abort)) 
		{
			$server = new server;
			$server->selectDB('webdb');
			mysql_query("INSERT INTO slider_images VALUES('','".$path."','".$url."')");
		}
	}
	
}

class character 
{
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
		 return "Feminino";
	 elseif($value==0)
		 return "Masculino";
	 else 
		 return "Desconhecido";
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
	
}

function activeMenu($p) 
{
	if(isset($_GET['p']) && $_GET['p']==$p)
		echo "style='display:block;'";
}

function limit_characters ($str,$n)
{    
    $str = preg_replace("/<img[^>]+\>/i", "(image) ", $str); 
	if ( strlen ( $str ) <= $n )
		return $str;
	else
		return substr ($str, 0, $n).'';
}

function stripBBCode($text_to_search) 
{
	 $pattern = '|[[\/\!]*?[^\[\]]*?]|si';
	 $replace = '';
	 return preg_replace($pattern, $replace, $text_to_search);
} 

?>
