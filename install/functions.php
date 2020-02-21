<?php
session_start();
ini_set('display_errors',1);

if(isset($_POST['step']))
{
	switch($_POST['step'])
	{
		case(1):
			step1($_POST['realmlist'],$_POST['host'],$_POST['port'],$_POST['user'],$_POST['pass'],$_POST['webdb'],$_POST['worlddb'],$_POST['logondb'],$_POST['domain'],
			$_POST['title'],$_POST['email'],$_POST['expansion'],$_POST['paypal']);
		break;
		
		case(2):
			step2();
		break;
		
		case(3):
			step3();
		break;
		
		case(4):
			step4();
		break;
		
		case(5):
			step5($_POST['rid'],$_POST['name'],$_POST['port'],$_POST['host'],$_POST['m_host'],$_POST['m_user'],$_POST['m_pass'],$_POST['a_user'],$_POST['a_pass'],
			$_POST['desc'],$_POST['sendtype'],$_POST['chardb'],$_POST['raport'],$_POST['soapport']);
		break;
	}
}

function step1($realmlist,$host,$port,$user,$pass,$webdb,$worlddb,$logondb,$domain,$title,$email,$exp,$paypal) 
{
	if(empty($host) || empty($port) || empty($user) || empty($logondb) || empty($worlddb) || empty($webdb) || empty($realmlist) || empty($title)
	|| empty($domain) || empty($email))
		exit('Por favor, preencha todos os campos!');
		
	$_SESSION['install']['database']['host'] = $host;
	$_SESSION['install']['database']['port'] = $port;
	$_SESSION['install']['database']['user'] = $user;
	$_SESSION['install']['database']['pass'] = $pass;
	$_SESSION['install']['database']['logondb'] = $logondb;
	$_SESSION['install']['database']['worlddb'] = $worlddb;
	$_SESSION['install']['database']['webdb'] = $webdb;
	$_SESSION['install']['database']['realmlist'] = $realmlist;
	$_SESSION['install']['database']['title'] = $title;
	$_SESSION['install']['database']['domain'] = $domain;
	$_SESSION['install']['database']['exp'] = $exp;
	$_SESSION['install']['database']['email'] = $email;
	$_SESSION['install']['database']['paypal'] = $paypal;
	
	print true;
}

function step2() 
{
	if (is_writable('../includes/configuration.php'))
	 	$config = true;
	else
		$config = false;
	
	if (is_readable('sql/CraftedWeb_Base.sql'))
	 	$sql = true;
	else
		$sql = false;	
	
	if($sql==true && $config==true)
		exit( "Os arquivos são graváveis.<BR /> <a href='?st=3'>Clique aqui para prosseguir</a>" );
	if($sql==true && $config==false)
		exit( "O Arquivo SQL <i>é</i> gravável, mas o Arquivo de Configuração <b>NÃO</b> é gravável. Por favor, verifique as instruções acima." );
	if($sql==false && $config==true)
		exit( "O Arquivo SQL <b>NÃO</b> é gravável, mas o Arquivo de Configuração <i>é</i> gravável. Por favor, verifique as instruções acima." );
		
		exit( "Arquivos NÃO graváveis. Por favor, verifique as instruções acima!" );
		
}

function step3() 
{
	echo '[Info]Conectando com o Banco de Dados...';
	$link = mysqli_connect($_SESSION['install']['database']['host'],$_SESSION['install']['database']['user'],$_SESSION['install']['database']['pass'],NULL,$_SESSION['install']['database']['port']);
	if (!$link) {
		die('<br/>[FALHA]Não foi possível conectar com o Banco de Dados. Por favor, reinicie a instalação. ');
	}
	
	echo '<br/>[Sucesso]Conectado com o Banco de Dados.';
	echo '<br/>[Info]Criando Banco de Dados do Site...';
	
	mysqli_query($link, "CREATE DATABASE IF NOT EXISTS ".mysqli_real_escape_string($link, $_SESSION['install']['database']['webdb']))or die
	('<br/>[FALHA]Não foi possível criar o Banco de Dados do Site. Por favor, reinicie a instalação.');
	
	echo '<br/>[Sucesso]Banco de Dados do Site criado com sucesso';
	echo '<br/>[Info]Conectando com o Banco de Dados do Site';
	
	mysqli_select_db($link, $_SESSION['install']['database']['webdb'])or die
	('<br/>[FALHA]Não foi possível conectar com o Banco de Dados do Site. Por favor, reinicie a instalação.');
	
	echo '<br/>[Sucesso]Conectado com o Banco de Dados do Site';
	echo '<br/>[Info]Criando as tabelas e inserindo os dados no Banco de Dados do Site...';
	
	$f = fopen('sql/CraftedWeb_Base.sql',"r+"); 
    $sqlFile = fread($f,filesize('sql/CraftedWeb_Base.sql')); 
    $sqlArray = explode(';',$sqlFile); 
	
	 foreach ($sqlArray as $stmt) { 
       if (strlen($stmt)>3){ 
            $result = mysqli_query($link, $stmt); 
              if (!$result){ 
                 die('<br/>[FALHA]Não foi possível executar o arquivo SQL no Banco de Dados do Site. Por favor, reinicie a instalação. (' . mysqli_error($link) .')');
              } 
           } 
      } 
	
	echo '<br/>[Sucesso]Arquivo SQL importado com sucesso!';
	echo '<br/>[Info]Importar <i>item_icons</i> para o Banco de Dados do Site.';
	
	$f = fopen('sql/item_icons.sql',"r+"); 
    $sqlFile2 = fread($f,filesize('sql/item_icons.sql')); 
    $sqlArray = explode(';',$sqlFile2); 
	
	 foreach ($sqlArray as $stmt) { 
       if (strlen($stmt)>3){ 
            $result = mysqli_query($link, $stmt); 
              if (!$result){ 
                 $err = 1;
              } 
           } 
      } 
	if(!isset($err))  
		echo '<br/>[Sucesso]Arquivo SQL importado com sucesso!';
	else
		echo '<br/>[Info]<i>item_icons</i> não foi importado. ('.mysqli_error($link).')';	
	
	echo '<br/>[Info]Escrevendo o Arquivo de Configuração...';
	

$config = '<?php
	if(!defined(\'INIT_SITE\'))
		exit();
		
	#############################
	## CONFIG FILE             ##
	## ------------------------##
	## Please note that:       ##
	## true = Enabled          ##
	## false = Disabled        ##
	#############################
	
	/*************************/
	/* General settings      
	/*************************/
	 $useDebug = false; //If you are having problems with your website, set this to "true", if not, set to "false". 
	 //All errors will be logged and visible in "includes/error-log.php". If set to false, error log will be blank. 
	 //This will also enable/disable errors on the Admin- & Staff panel.
	 
	 $maintainance = false; //Maintainance mode, will close the website for everyone. True = enable, false = disable
	 $maintainance_allowIPs = array(\'herp.derp.13.37\'); //Allow specific IP addresses to view the website even though you have maintainance mode enabled.
	 //Example: \'123.456.678\', \'987.654.321\'
	 
	 $website_title = \''.$_SESSION['install']['database']['title'].'\'; //The title of your website, shown in the users browser.
	 
	 $default_email = \''.$_SESSION['install']['database']['email'].'\'; //The default email address from wich Emails will be sent.

	 $website_domain = \''.$_SESSION['install']['database']['domain'].'\'; //Provide the domain name AND PATH to your website.
	 //Example: http://yourserver.com/
	 //If you have your website in a sub-directory, include that aswell. Ex: http://yourserver.com/cataclysm/
	 
	 $showLoadTime = true; 
	 //Shows the page load time in the footer.
	 
	 $footer_text = \'Copyright &copy; '.$_SESSION['install']['database']['title'].' 2013<br/>
	 All rights reserved\'; //Set the footer text, displayed at the bottom.
	 //Tips: &copy; = Copyright symbol. <br/> = line break.
	 
	 $timezone = \'Europe/Belgrade\'; //Set the time zone for your website. Default: Europe/Belgrade (GMT +1)
	 //Full list of supported timezones can be found here: http://php.net/manual/en/timezones.php
	 
	 $core_expansion = '.$_SESSION['install']['database']['exp'].'; //The expansion of your server.
	 // 0 = Vanilla
	 // 1 = The Burning Crusade
	 // 2 = Wrath of The Lich King
	 // 3 = Cataclysm
	 
	 $adminPanel_enable = true; //Enable or disable the Administrator Panel. 
	 $staffPanel_enable = true; //Enable or disable the Staff Panel. 
	 
	 $adminPanel_minlvl = 4; //Minimum gm level of which accounts are able to log in to the Admin Panel. Default: 4
	 $staffPanel_minlvl = 3; //Minimum gm level of which accounts are able to log in to the Staff Panel. Default: 3
	 
	 $staffPanel_permissions[\'Pages\'] = false;
	 $staffPanel_permissions[\'News\'] = false;
	 $staffPanel_permissions[\'Shop\'] = false;
	 $staffPanel_permissions[\'Donations\'] = false;
	 $staffPanel_permissions[\'Logs\'] = true;
	 $staffPanel_permissions[\'Interface\'] = false;
	 $staffPanel_permissions[\'Users\'] = true;
	 $staffPanel_permissions[\'Realms\'] = false;
	 $staffPanel_permissions[\'Services\'] = false;
	 $staffPanel_permissions[\'Tools->Tickets\'] = true;
	 $staffPanel_permissions[\'Tools->Account Access\'] = false;
	 $staffPanel_permissions[\'editNewsComments\'] = true;
	 $staffPanel_permissions[\'editShopItems\'] = false;
	 
	 //Pages = Disable/Enable pages & Create custom pages.
	 //News = Edit/Delete/Post news.
	 //Shop = Add/Edit/Remove shop items.
	 //Donations = View donations overview & log.
	 //Logs = View vote & donation shop logs.
	 //Interface = Edit the menu, template & slideshow.
	 //Users = View & edit user data.
	 //Realms = Edit/Delete/Add realms.
	 //Services = Edit voting links & character services.
	 //Tools->Tickets = View/Lock/Delete tickets.
	 //Tools->Account Access = Edit/Remove/Add account access.
	 //editNewsComments = Edit/Remove news comments.
	 //editShopItems = Edit/Remove shop items.
	 
	$enablePlugins = true; //Enable or disable the use of plugins. Plugins May slow down your site a bit.
	 
	/*************************/
	/* Slideshow settings 
	/*************************/
	$enableSlideShow = true; //Enable or Disable the slideshow. This will only be shown at the home page. 
	
	/*************************/
	/* Website compression settings    
	/*************************/
	
	$compression[\'gzip\'] = true; //This is very hard to explain, but it may boost your website speed drastically.
	$compression[\'sanitize_output\'] = true; //This will strip all the whitespaces on the HTML code written. This should increase the website speed slightly. 
	//And "copycats" will have a hard time stealing your HTML code :>
	
	$useCache = false; //Enable / Disable the use of caching. It\'s in early developement and is currently only applied to very few things in the core at the moment.
	//You will probably not notice any difference when enabling this, unless you have alot of visitors. Who knows, I havent tried.
	
	
	/*************************/
	/* News settings   
	/*************************/
	$news[\'enable\'] = true; // Enable/Disable the use of the news system at the homepage. 
	$news[\'maxShown\'] = 2; //Maximum amount of news posts that will be shown on the home page.
							 //People can still view all posts by clicking the "All news" button.
	$news[\'enableComments\'] = true; //Make people able to comment on your news posts.
	$news[\'limitHomeCharacters\'] = false; //This will limit the characters shown in the news post. People will have to click the "Leia mais..." button
	//to read the whole news post. 
	
	
	/***** Server status ******/
	$serverStatus[\'enable\'] = true; //This will enable/disable the server status box.
	$serverStatus[\'nextArenaFlush\'] = false; //This will display the next arena flush for your realm(s).
	$serverStatus[\'uptime\'] = true; //This will display the uptime of your realm(s).
	$serverStatus[\'playersOnline\'] = true; //This will show current players online
	$serverStatus[\'factionBar\'] = true; //This will show the players online faction bar.
	
	
	/*************************/
	/* mySQL connection settings
	/*************************/
	
	$connection[\'host\'] = \''.$_SESSION['install']['database']['host'].':'.$_SESSION['install']['database']['port'].'\';
	$connection[\'user\'] = \''.$_SESSION['install']['database']['user'].'\';
	$connection[\'password\'] = \''.$_SESSION['install']['database']['pass'].'\';
	$connection[\'logondb\'] = \''.$_SESSION['install']['database']['logondb'].'\';
	$connection[\'webdb\'] = \''.$_SESSION['install']['database']['webdb'].'\';
	$connection[\'worlddb\'] = \''.$_SESSION['install']['database']['worlddb'].'\';
	$connection[\'realmlist\'] = \''.$_SESSION['install']['database']['realmlist'].'\';
	
	// host = Either an IP address or a DNS address
	// user = A mySQL user with access to view/write the entire database.
	// password = The password for the user you specified
	// logondb = The name of your "auth" or "realmdb" database name. Default: auth
	// webdb = The name of the database with CraftedWeb data. Default: craftedweb
	// worlddb = The name of your world database. Default: world
	// realmlist = This could be your server IP or DNS. Ex: logon.yourserver.com
	
	/*************************/
	/* Registration settings
	/*************************/
	$registration[\'userMaxLength\'] = 16;
	$registration[\'userMinLength\'] = 3;
	$registration[\'passMaxLength\'] = 22;
	$registration[\'passMinLength\'] = 5;
	$registration[\'validateEmail\'] = true;
	$registration[\'captcha\'] = true;
	
	//userMaxLength = Maximum length of usernames
	//userMinLength = Minimum length of usernames
	//passMaxLength = Maximum length of passwords
	//passMinLength = Minimum length of passwords
	//validateEmail = Validates if the email address is a correct email address. May not work on some PHP versions.
	//captcha = Enables/Disables the use of the captcha (Anti-bot) 
	
	/*************************/
	/* Voting settings
	/*************************/
	$vote[\'timer\'] = 43200;
	$vote[\'type\'] = \'instant\';
	$vote[\'multiplier\'] = 1;
	
	// timer = Timer between every vote on each link in seconds. Default: 43200 (12 hours)
	// type = Voting system type. 
	//         \'instant\' = Give vote points instantly when the user clicks the Vote button.
	//         \'confirm\' = Give Vote Points when the user has returned to your website. (Hopefully through clicking on your banner on the topsite)
	// multiplier = Multiply amount of Vote Points given for every vote. Useful for special holidays etc.
	
	/*************************/
	/* Donation settings
	/*************************/
	$donation[\'paypal_email\'] = \''.$_SESSION['install']['database']['paypal'].'\';
	$donation[\'coins_name\'] = \'Moedas de Doação\';
	$donation[\'currency\'] = \'USD\';
	$donation[\'emailResponse\'] = true;
	$donation[\'sendResponseCopy\'] = false;
	$donation[\'copyTo\'] = \''.$_SESSION['install']['database']['email'].'\';
	$donation[\'responseSubject\'] = \'Obrigado por nos apoiar!\';
	$donation[\'donationType\'] = 2;
	
	// paypal_email = The PayPal email address of wich payment will be sent to.
	// coins_name = The name of the donation coins that the user will buy.
	// currency = The name of the currency that you want the user to pay with. Default: USD
	// emailResponse = Enabling this will make the donator to recieve a validation email after their donation, containing the donation information. 
	// sendResponseCopy = Set this to "true" if you wish to recieve a copy of the email response mentioned above. 
	// copyTo = Enable the sendResponseCopy to activate this function. Enter the email address of wich the payment copy will be sent to. 
	// responseSubject =  Enable the sendResponseCopy to activate this function. The subject of the email response sent to the donator.
	// donationType = How the user will donate. 1 = They can enter how many coins they wish to buy, and the value can be increased with the multiplier.
	// 2 = A list of options will be shown, you may set the list below.
	
	/*  EDITING THIS IS ONLY NECESSARY IF YOU HAVE \'donationType\' SET TO 2     */
	/* Just follow the template and enter your custom values */
	/* array(\'NAME/TITLE\', COINS TO ADD, PRICE) */
	$donationList = array(
			array(\'10 Moedas de Doação - 5$\', 10, 5),
			array(\'20 Moedas de Doação - 8$\', 20, 8),
			array(\'50 Moedas de Doação - 20$\', 50, 20),
			array(\'100 Moedas de Doação - 35$\', 100, 35 ),
			array(\'200 Moedas de Doação - 70$\', 200, 70 )
	);
	
	/*************************/
	/* Vote & Donation shop settings
	/*************************/
	$voteShop[\'enableShop\'] = true;
	$voteShop[\'enableAdvancedSearch\'] = true;
	$voteShop[\'shopType\'] = 1;
	
	// enableShop = Enables/disables the use of the Vote Shop. "true" = enable, "false" = disable.
	// enableAdvancedSearch = Enabled/disables the use of the advanced search feature. "true" = enable, "false" = disable.
	// shopType = The type of shop you wish to use. 1 = "Search". 2 = List all items available.
	
	
	/*************************/
	$donateShop[\'enableShop\'] = true;
	$donateShop[\'enableAdvancedSearch\'] = true;
	$donateShop[\'shopType\'] = 1;
	
	// Explanations can be found above.
	
	/*************************/
	/* Social plugins settings
	/*************************/
	$social[\'enableFacebookModule\'] = false;
	$social[\'facebookGroupURL\'] = \'http://www.facebook.com/YourServer\';
	
	// enableFacebookModule = This will create a Facebook box to the left, below the server status. "true" = enable, "false" = disable.
	// facebookGroupURL = The full URL to your facebook group.
	// NOTE! This feature might be a little buggy due to the width of some themes. I wish you good luck though.
	
	/*************************/
	/* Forum settings
	/*************************/
	$forum[\'type\'] = \'phpbb\';
	$forum[\'autoAccountCreate\'] = false;
	$forum[\'forum_path\'] = \'/forum/\';
	$forum[\'forum_db\'] = \'phpbb\';
	
	// type = the type of forum you are using. (phpbb,vbulletin)
	// autoAccountCreate = this function creates a forum account when the user register at the website. 
	// forum_path = The path to the forum. Example: If you have it in YOURSITE.COM/forum/, then put "/forum/". (Without "")
	// forum_db = The database name of the forum. If you have the forum database on the same location as your logon database, 
	// 			  this will enable \'Latest Forum Activity\' on your Admin Panel. 
	######NOTE#######
	// autoAccountCreate is only supported for phpBB, vBulletin will be supported in near future.
	
	/************************/
	/* Advanced settings, mostly used for further developement.
	/* DO NOT TOUCH THESE CONFIGS unless you know what you are doing! */
	/************************/
	
	$core_pages = array(\'Painel de Conta\' => \'account.php\',\'Carrinho de Compras\' => \'cart.php\',
	\'Alterar Senha\' => \'changepass.php\',\'Doar\' => \'donate.php\',\'Loja de Doação\' => \'donateshop.php\',
	\'Esqueceu sua Senha\' => \'forgotpw.php\',\'Início\' => \'home.php\',\'Sair\' => \'logout.php\',
	\'Notícias\' => \'news.php\',\'Convide um Amigo\' => \'raf.php\',\'Registrar\' => \'register.php\',
	\'Reviver Personagem\' => \'revive.php\',\'Alterar E-mail\' => \'settings.php\',\'Suporte\' => \'support.php\',
	\'Teleportar Personagem\' => \'teleport.php\',\'Unstuck Personagem\' => \'unstuck.php\',\'Votar\' => \'vote.php\',
	\'Loja de Votação\' => \'voteshop.php\',\'Confirmar Serviço\' => \'confirmservice.php\');
	
	###LOAD MAXIMUM ITEM LEVEL DEPENDING ON EXPANSION###
	switch($GLOBALS[\'core_expansion\']) 
	{
		case(0):
		$maxItemLevel = 100;
		break;
		case(1):
		$maxItemLevel = 175;
		break;
		default:
		case(2):
		$maxItemLevel = 284;
		break;
		case(3):
		$maxItemLevel = 416;
		break;
	}
	
	if($GLOBALS[\'core_expansion\']>2) 
		$tooltip_href = \'www.wowhead.com/\';
	else
		$tooltip_href = \'www.openwow.com/?\';
	
	//Set the timezone.
	date_default_timezone_set($GLOBALS[\'timezone\']);
	
	//Set the error handling.
	if(file_exists(\'includes/classes/error.php\'))
		require(\'includes/classes/error.php\');
		
	elseif(file_exists(\'../classes/error.php\'))
		require(\'../classes/error.php\');
		
	elseif(file_exists(\'../includes/classes/error.php\'))
		require(\'../includes/classes/error.php\');
	
	elseif(file_exists(\'../../includes/classes/error.php\'))
		require(\'../../includes/classes/error.php\');
	
	elseif(file_exists(\'../../../includes/classes/error.php\'))
		require(\'../../../includes/classes/error.php\');
	
	loadCustomErrors(); //Load custom errors
?>';

$fp = fopen('../includes/configuration.php', 'w');
fwrite($fp, $config)or die('<br/>[FALHA]Não foi possível escrever no Arquivo de Configuração. Por favor, reinicie a instalação.');
fclose($fp);

echo '<br/>[Sucesso]Arquivo de Configuração escrito!';

echo '<hr/>Processo de instalação finalizado. <a href="?st=4">Clique aqui para continuar</a>';
	  
}

function step4()
{
	$files = scandir('sql/updates/');
	
	echo '[Info]Conectando com o Banco de Dados...';
	$link = mysqli_connect($_SESSION['install']['database']['host'],$_SESSION['install']['database']['user'],$_SESSION['install']['database']['pass'],NULL,$_SESSION['install']['database']['port']);
	if (!$link) {
		die('<br/>[FALHA]Não foi possível conectar com o Banco de Dados. Reinicie a instalação. ');
	}
	
	echo '<br/>[Sucesso]Conectado com o Banco de Dados.';
	echo '<br/>[Info]Conectando com o Banco de Dados do Site';
	
	mysqli_select_db($link, $_SESSION['install']['database']['webdb'])or die
	('<br/>[FALHA]Não foi possível conectar com o Banco de Dados do Site. Por favor, reinicie a instalação.');
	
	echo '<br/>[Sucesso]Conectado com o Banco de Dados do Site';
	echo '<br/>[Info]Aplicando atualizações...';
	
	foreach($files as $value) {
		if(substr($value,-3,3)=='sql')
		{
			echo '<br>[Info]Aplicando '.$value.'...';
			$f = fopen('sql/updates/'.$value,"r+")or die
			('<br/>[FALHA]Não foi possível abrir o arquivo SQL. Por favor, defina o CHMOD para 777 e tente novamente.'); 
			$sqlFile = fread($f,filesize('sql/updates/'.$value)); 
			$sqlArray = explode(';',$sqlFile); 
			
			 foreach ($sqlArray as $stmt) { 
			   if (strlen($stmt)>3){ 
					$result = mysqli_query($link, $stmt); 
					  if (!$result){ 
						 die('<br/>[FALHA]Não foi possível executar o arquivo SQL no Banco de Dados do Site. (' . mysqli_error($link) .')');
					  } 
				   } 
			  } 
		}
	}
	
	echo '<br/>[Sucesso]Atualização Completa. <a href="?st=5">Clique aqui para continuar</a>';
}

function step5($rid,$name,$port,$host,$m_host,$m_user,$m_pass,$a_user,$a_pass,$desc,$sendtype,$chardb,$raport,$soapport)
{
	$link = mysqli_connect($_SESSION['install']['database']['host'],$_SESSION['install']['database']['user'],$_SESSION['install']['database']['pass'],NULL,$_SESSION['install']['database']['port']);
	mysqli_select_db($link, $_SESSION['install']['database']['webdb']);
	
	$rid = (int)$rid;
	$name = mysqli_real_escape_string($link, $name);
	$port = (int)$port;
	$host = mysqli_real_escape_string($link, $host);
	$m_host = mysqli_real_escape_string($link, $m_host);
	$m_user = mysqli_real_escape_string($link, $m_user);
	$m_pass = mysqli_real_escape_string($link, $m_pass);
	$a_user = mysqli_real_escape_string($link, $a_user);
	$a_pass = mysqli_real_escape_string($link, $a_pass);
	$desc = mysqli_real_escape_string($link, $desc);
	$sendtype = mysqli_real_escape_string($link, $sendtype);
	$chardb = mysqli_real_escape_string($link, $chardb);
	$raport = mysqli_real_escape_string($link, $raport);
	$soapport = mysqli_real_escape_string($link, $soapport);
	
	if(empty($rid) || empty($name) || empty($port) || empty($host) || empty($m_host) || empty($m_user) || empty($a_user)
	|| empty($a_pass) ||  empty($sendtype) || empty($chardb))
		exit('Por favor, insira todos os campos.');
	
	mysqli_query($link, "INSERT INTO realms VALUES('".$rid."','".$name."','".$desc."','".$chardb."','".$port."','".$a_user."','".$a_pass."','".$raport."','".$soapport."',
	'".$host."','".$sendtype."','".$m_host."','".$m_user."','".$m_pass."')")or die
	('Não foi possível inserir o reino no Banco de Dados. ('.mysqli_error($link).')');
	
	echo 'Reino criado com sucesso. <a href="?st=6">Clique aqui para continuar</a>';
}

?>