<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
 require_once "random_compat-2.0.20/lib/random.php";

##############
##  Account functions goes here
##############

class account {

	###############################
	####### Log in method
	###############################
	public static function logIn($username,$password,$last_page,$remember)
	{
		if (!isset($username) || !isset($password) || $username=="Nome de Usuário..." || $password=="Senha...")
			echo '<span class="red_text">Por favor, insira os dois campos.</span>';
		else
		{
			$username = mysql_real_escape_string(trim(strtoupper($username)));
			$password = mysql_real_escape_string(trim(strtoupper($password)));

			connect::selectDB('logondb');
			$checkForAccount = mysql_query("SELECT COUNT(id) FROM account WHERE username='".$username."'");
			if (mysql_result($checkForAccount,0)==0)
				echo '<span class="red_text">Nome de Usuário inválido.</span>';
			else
			{
				if($remember!=835727313)
				{
					$data = mysql_query("SELECT salt, verifier FROM account WHERE username = '".$username."'");
					$data = mysql_fetch_assoc($data);
					$salt = $data['salt'];
					$verifier = $data['verifier'];
				}

				if (!account::verifySRP6($username, $password, $salt, $verifier))
					echo '<span class="red_text">Senha incorreta.</span>';
				else
				{
					if($remember=='on')
						setcookie("cw_rememberMe", $username.' * '.$password, time()+30758400);
						//Set "Lembrar de mim" cookie. Expira em 1 ano.

					$result = mysql_query("SELECT id FROM account WHERE username='".$username."'");
					$id = mysql_fetch_assoc($result);
					$id = $id['id'];

					self::GMLogin($username);
					$_SESSION['cw_user'] = ucfirst(strtolower($username));
					$_SESSION['cw_user_id'] = $id;

					connect::selectDB('webdb');
					$count = mysql_query("SELECT COUNT(*) FROM account_data WHERE id='".$id."'");
					if(mysql_result($count,0)==0)
						mysql_query("INSERT INTO account_data VALUES('".$id."','0','0')");

					if(!empty($last_page))
					   header("Location: ".$last_page);
					else
					   header("Location: index.php");
                    exit;
				}
			}

		}

	}

	public static function loadUserData()
	{
		//Unused function
		$user_info = array();

		connect::selectDB('logondb');
		$account_info = mysql_query("SELECT id, username, email, joindate, locked, last_ip, expansion FROM account
		WHERE username='".$_SESSION['cw_user']."'");
		while($row = mysql_fetch_array($account_info))
		{
			$user_info[] = $row;
		}

	    return $user_info;
	}

	###############################
	####### Log out method
	###############################
	public static function logOut($last_page)
	{
		session_destroy();
		setcookie('cw_rememberMe', '', time()-30758400);
		if (empty($last_page))
		{
			header('Location: ?p=home"');
			exit();
		}
		header('Location: '.$last_page);
		exit();
	}
	
	
	###############################
	####### SRP6 methods
	###############################
	public function calculateSRP6Verifier($username, $password, $salt)
    {
        // algorithm constants
        $g = gmp_init(7);
        $N = gmp_init('894B645E89E1535BBDAD5B8B290650530801B18EBFBF5E8FAB3C82872A3E9BB7', 16);

        // calculate first hash
        $h1 = sha1(strtoupper($username . ':' . $password), TRUE);

        // calculate second hash
        $h2 = sha1($salt.$h1, TRUE);

        // convert to integer (little-endian)
        $h2 = gmp_import($h2, 1, GMP_LSW_FIRST);

        // g^h2 mod N
        $verifier = gmp_powm($g, $h2, $N);

        // convert back to a byte array (little-endian)
        $verifier = gmp_export($verifier, 1, GMP_LSW_FIRST);

        // pad to 32 bytes, remember that zeros go on the end in little-endian!
        $verifier = str_pad($verifier, 32, chr(0), STR_PAD_RIGHT);

        // done!
        return $verifier;
    }

    // Returns SRP6 parameters to register this username/password combination with
    public function getRegistrationData($username, $password)
    {
        // generate a random salt
        $salt = random_bytes(32);

        // calculate verifier using this salt
        $verifier = account::calculateSRP6Verifier($username, $password, $salt);

        // done - this is what you put in the account table!
        return array($salt, $verifier);
    }

    public function verifySRP6($user, $pass, $salt, $verifier)
    {
        $g = gmp_init(7);
        $N = gmp_init('894B645E89E1535BBDAD5B8B290650530801B18EBFBF5E8FAB3C82872A3E9BB7', 16);
        $x = gmp_import(
            sha1($salt . sha1(strtoupper($user . ':' . $pass), TRUE), TRUE),
            1,
            GMP_LSW_FIRST
        );
        $v = gmp_powm($g, $x, $N);
        return ($verifier === str_pad(gmp_export($v, 1, GMP_LSW_FIRST), 32, chr(0), STR_PAD_RIGHT));
    }
	

	###############################
	####### Registration method
	###############################
	public function register($username,$email,$password,$repeat_password,$captcha,$raf)
	{
		$errors = array();

		if (empty($username))
			$errors[] = 'Insira o Nome de Usuário.';

		if (empty($email))
			$errors[] = 'Insira o Endereço de E-mail.';

		if (empty($password))
			$errors[] = 'Insira a Senha.';

		if (empty($repeat_password))
			$errors[] = 'insira a Confirmação da Senha.';

		if($username==$password)
			$errors[] = 'Sua Senha não pode ser seu Nome de Usuário!';

		else
		{
			session_start();
			if($GLOBALS['registration']['captcha']==TRUE)
			{
				if($captcha!=$_SESSION['captcha_numero'])
					$errors[] = 'Código de Segurança incorreto!';
			}

			if (strlen($username)>$GLOBALS['registration']['userMaxLength'] || strlen($username)<$GLOBALS['registration']['userMinLength'])
				$errors[] = 'O Nome de Usuário deve ter entre '.$GLOBALS['registration']['userMinLength'].' e '.$GLOBALS['registration']['userMaxLength'].' letras e/ou números.';

			if (strlen($password)>$GLOBALS['registration']['passMaxLength'] || strlen($password)<$GLOBALS['registration']['passMinLength'])
				$errors[] = 'A senha deve ter entre '.$GLOBALS['registration']['passMinLength'].' e '.$GLOBALS['registration']['passMaxLength'].' letras e/ou números.';

			if ($GLOBALS['registration']['validateEmail']==true)
			{
			    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
				       $errors[] = 'Insira um Endereço de E-mail válido.';
			}

		}
		$username_clean = mysql_real_escape_string(trim($username));
		$password_clean = mysql_real_escape_string(trim($password));
		$username = mysql_real_escape_string(trim(strtoupper(strip_tags($username))));
		$email = mysql_real_escape_string(trim(strip_tags($email)));
		$password = mysql_real_escape_string(trim(strtoupper(strip_tags($password))));
		$repeat_password = trim(strtoupper($repeat_password));
		$raf = (int)$raf;


		connect::selectDB('logondb');
		//Check for existing user
		$result = mysql_query("SELECT COUNT(id) FROM account WHERE username='".$username."'");
		if (mysql_result($result,0)>0)
			$errors[] = 'O Nome de Usuário já existe!';

		if ($password != $repeat_password)
			$errors[] = 'As Senhas não coincidem!';

		if (!empty($errors))
		{
			//errors found.
			echo "<p><h4>Ocorreram os seguintes erros:</h4>";
				foreach($errors as $error)
				{
					echo  "<strong>*", $error ,"</strong><br/>";
				}
			echo "</p>";
			exit();
		}
		else
		{
			$data = account::getRegistrationData($username, $password);
			$salt = $data[0];
			$verifier = $data[1];
			
			mysql_query("INSERT INTO account (username, salt, verifier, email, joindate, expansion, recruiter)
			VALUES('".$username."', '".$salt."', '".$verifier."', '".$email."', '".date("Y-m-d H:i:s")."', '".$GLOBALS['core_expansion']."', '".$raf."') ");

			$getID = mysql_query("SELECT id FROM account WHERE username='".$username."'");
			$row = mysql_fetch_assoc($getID);

			connect::selectDB('webdb');
			mysql_query("INSERT INTO account_data VALUES('".$row['id']."','','')");

			$result = mysql_query("SELECT id FROM account WHERE username='".$username_clean."'");
			$id = mysql_fetch_assoc($result);
			$id = $id['id'];

			self::GMLogin($username_clean);
			$_SESSION['cw_user']=ucfirst(strtolower($username_clean));
			$_SESSION['cw_user_id']=$id;

			account::forumRegister($username_clean,$password_clean,$email);
		}

	}


	public static function forumRegister($username,$password,$email)
	{
	 date_default_timezone_set($GLOBALS['timezone']);

     global $phpbb_root_path, $phpEx, $user, $db, $config, $cache, $template;
	 if($GLOBALS['forum']['type']=='phpbb' && $GLOBALS['forum']['autoAccountCreate']==TRUE)
	 {
		     ////////PHPBB INTEGRATION//////////////
			define('IN_PHPBB', true);
			define('ROOT_PATH', '../..'.$GLOBALS['forum']['forum_path']);

			$phpEx = "php";
			$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : ROOT_PATH;

			if(file_exists($phpbb_root_path . 'common.' . $phpEx) && file_exists($phpbb_root_path . 'includes/functions_user.' . $phpEx))
			{
			include($phpbb_root_path.'common.'.$phpEx);

			include($phpbb_root_path.'includes/functions_user.'.$phpEx);

			$arrTime = getdate();
			$unixTime = strtotime($arrTime['year']."-".$arrTime['mon'].'-'.$arrTime['mday']." ".$arrTime['hours'].":".
								  $arrTime['minutes'].":".$arrTime['seconds']);

			$user_row = array(
				'username'              => $username,
				'user_password'         => phpbb_hash($password),
				'user_email'            => $email,
				'group_id'              => (int) 2,
				'user_timezone'         => (float) 0,
				'user_dst'              => "0",
				'user_lang'             => "en",
				'user_type'             => 0,
				'user_actkey'           => "",
				'user_ip'               => $_SERVER['REMOTE_HOST'],
				'user_regdate'          => $unixTime,
				'user_inactive_reason'  => 0,
				'user_inactive_time'    => 0
			);

			// All the information has been compiled, add the user
			// tables affected: users table, profile_fields_data table, groups table, and config table.
			$user_id = user_add($user_row);
			}
	  	}
	}

	###############################
	####### Check if a user is logged in method.
	###############################
	public static function isLoggedIn()
	{
		if (isset($_SESSION['cw_user']))
        {
			header("Location: ?p=account");
            exit;
        }
	}


	###############################
	####### Check if a user is NOT logged in method.
	###############################
	public static function isNotLoggedIn()
	{
		if (!isset($_SESSION['cw_user']))
        {
	        header("Location: ?p=login&r=".$_SERVER['REQUEST_URI']);
            exit;
        }
	}

	public static function isNotGmLoggedIn()
	{
		if (!isset($_SESSION['cw_gmlevel']))
        {
			header("Location: ?p=home");
            exit;
        }
	}


	###############################
	####### Return ban status method.
	###############################
	public static function checkBanStatus($user)
	{
		connect::selectDB('logondb');
		$acct_id = self::getAccountID($user);

		$result = mysql_query("SELECT bandate,unbandate,banreason FROM account_banned WHERE id='".$acct_id."' AND active=1");
		if (mysql_num_rows($result)>0)
		{
			$row = mysql_fetch_assoc($result);
            if($row['bandate'] >= $row['unbandate'] && $row['unbandate'] < time())
            {
                return '<span class="red_text">Banido<br />
                Motivo: '.$row['banreason'].'<br />
                Tempo restante: Infinito</span>';
            }
			else
			{
                $duration = $row['unbandate'] - time();
                if ($duration > 0)
                {
                    $duration = round(($duration / 60)/60, 2);
                    $duration = $duration.' horas';
                    return '<span class="yellow_text">Banido<br/>
                    Motivo: '.$row['banreason'].'<br/>
                    Tempo restante: '.$duration.'</span>';
                }
            }
		}
        return '<b class="green_text">Ativo</b>';
	}


	###############################
	####### Return account ID method.
	###############################
	public static function getAccountID($user)
	{
		$user = mysql_real_escape_string($user);
		connect::selectDB('logondb');
		$result = mysql_query("SELECT id FROM account WHERE username='".$user."'");
		$row = mysql_fetch_assoc($result);
		return $row['id'];
	}

	public static function getAccountName($id)
	{
		$id = (int)$id;
		connect::selectDB('logondb');
		$result = mysql_query("SELECT username FROM account WHERE id='".$id."'");
		$row = mysql_fetch_assoc($result);
		return $row['username'];
	}


	###############################
	####### "Remember me" method. Loads on page startup.
	###############################
	public function getRemember()
	{
		if (isset($_COOKIE['cw_rememberMe']) && !isset($_SESSION['cw_user'])) {
			$account_data = explode("*", $_COOKIE['cw_rememberMe']);
			$this->logIn($account_data[0],$account_data[1],$_SERVER['REQUEST_URI'],835727313);
		}
	}


	###############################
	####### Return account Vote Points method.
	###############################
	public static function loadVP($account_name)
	{
		$acct_id = self::getAccountID($account_name);
		connect::selectDB('webdb');
		$result = mysql_query("SELECT vp FROM account_data WHERE id=".$acct_id);
		if (mysql_num_rows($result)==0)
			return 0;
		else
		{
			$row = mysql_fetch_assoc($result);
			return $row['vp'];
		}
	}


	public static function loadDP($account_name)
	{
	    $acct_id = self::getAccountID($account_name);
		connect::selectDB('webdb');
		$result = mysql_query("SELECT dp FROM account_data WHERE id=".$acct_id);
		if (mysql_num_rows($result)==0)
			return 0;
		else
		{
			$row = mysql_fetch_assoc($result);
			return $row['dp'];
		}
	}



	###############################
	####### Return email method.
	###############################
	public static function getEmail($account_name)
	{
		$account_name = mysql_real_escape_string($account_name);
		connect::selectDB('logondb');
		$result = mysql_query("SELECT email FROM account WHERE username='".$account_name."'");
		$row = mysql_fetch_assoc($result);
		return $row['email'];
	}


	###############################
	####### Return online status method.
	###############################
	public static function getOnlineStatus($account_name)
	{
		$account_name = mysql_real_escape_string($account_name);
		connect::selectDB('logondb');
		$result = mysql_query("SELECT COUNT(online) FROM account WHERE username='".$account_name."' AND online=1");
		if (mysql_result($result,0)==0)
			return '<b class="red_text">Offline</b>';
		else
			return '<b class="green_text">Online</b>';
	}


	###############################
	####### Return Join date method.
	###############################
	public static function getJoindate($account_name)
	{
		$account_name = mysql_real_escape_string($account_name);
		connect::selectDB('logondb');
		$result = mysql_query("SELECT joindate FROM account WHERE username='".$account_name."'");
		$row = mysql_fetch_assoc($result);
		return $row['joindate'];
	}


	###############################
	####### Returns a GM session if the user is a GM with rank 2 and above.
	###############################
	public static function GMLogin($account_name)
	{
		connect::selectDB('logondb');
		$acct_id = self::getAccountID($account_name);

		$result = mysql_query("SELECT SecurityLevel FROM account_access WHERE SecurityLevel > 2 AND AccountID=".$acct_id);
		if(mysql_num_rows($result)>0)
		{
			$row = mysql_fetch_assoc($result);
			$_SESSION['cw_gmlevel']=$row['SecurityLevel'];
		}

	}

	public static function getCharactersForShop($account_name)
	{
		$acct_id = self::getAccountID($account_name);
		connect::selectDB('webdb');
		$getRealms = mysql_query("SELECT id,name FROM realms");
		while($row = mysql_fetch_assoc($getRealms))
		{
			connect::connectToRealmDB($row['id']);
			$result = mysql_query("SELECT name,guid FROM characters WHERE account='".$acct_id."'");
			if(mysql_num_rows($result)==0 && !isset($x))
			{
				$x = true;
			     echo '<option value="">Nenhum personagem encontrado!</option>';
			}

			while($char = mysql_fetch_assoc($result))
			{
				echo '<option value="'.$char['guid'].'*'.$row['id'].'">'.$char['name'].' - '.$row['name'].'</option>';
			}
		}
	}


	public static function changeEmail($email, $current_pass)
	{
		$errors = array();
		if (empty($current_pass))
			$errors[] = 'Por favor, insira sua Senha atual';
		else
		{
			if (empty($email))
				$errors[] = 'Por favor, insira um Endereço de E-mail.';

			connect::selectDB('logondb');
			$id = $_SESSION['cw_user_id'];
			$username = mysql_real_escape_string(trim(strtoupper($_SESSION['cw_user'])));
			$password = mysql_real_escape_string(trim(strtoupper($current_pass)));

			$data = mysql_query("SELECT salt, verifier FROM account WHERE username = '".$username."'");
			$data = mysql_fetch_assoc($data);
			$salt = $data['salt'];
			$verifier = $data['verifier'];
			
			if (!account::verifySRP6($username, $password, $salt, $verifier))
				$errors[] = 'A Senha atual está incorreta.';


			if ($GLOBALS['registration']['validateEmail']==true)
			{
			    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
				    $errors[] = 'Insira um Endereço de E-mail válido.';
			}

		}
        echo '<div class="news" style="padding: 5px;">';
		if(empty($errors))
        {
            mysql_query("UPDATE account SET email = '".$email."' WHERE username = '".$username."'");
			echo '<h4 class="green_text">A sua Conta foi atualizada com sucesso</h4>';
        }
		else
		{
			echo '
			<h4 class="red_text">Ocorreram os seguintes erros:</h4>';
				   foreach($errors as $error)
				   {
					 echo  '<strong class="yellow_text">*', $error ,'</strong><br/>';
				   }
		}
        echo '</div>';
	}



	//Used for the change password page.
	public static function changePass($old,$new,$new_repeat)
	{
		//Check if all field values has been typed into
		if (!isset($_POST['cur_pass']) || !isset($_POST['new_pass']) || !isset($_POST['new_pass_repeat']))
			echo '<b class="red_text">Por favor, insira todos os campos!</b>';
	    else
		{
            $old = mysql_real_escape_string(trim($old));
            $new = mysql_real_escape_string(trim($new));
            $new_repeat = mysql_real_escape_string(trim($new_repeat));

			//Check if new passwords match?
			if ($new != $new_repeat)
				echo '<b class="red_text">As novas Senhas não coincidem!</b>';
			else
			{
			  if (strlen($new) < $GLOBALS['registration']['passMinLength'] ||
			      strlen($new) > $GLOBALS['registration']['passMaxLength'])
				  echo '<b class="red_text">Sua Senha deve ter entre '.$GLOBALS['registration']['passMinLength'].' e '.$GLOBALS['registration']['passMaxLength'].' letras e/ou números.</b>';
			  else
			  {					
				//Lets check if the old password is correct!
				$username = strtoupper(mysql_real_escape_string(trim($_SESSION['cw_user'])));
				connect::selectDB('logondb');
				$data = mysql_query("SELECT salt, verifier FROM account WHERE username = '".$username."'");
				$data = mysql_fetch_assoc($data);
				$salt = $data['salt'];
				$verifier = $data['verifier'];

				if (!account::verifySRP6($username, $old, $salt, $verifier))
					echo '<b class="red_text">A Senha atual está incorreta!</b>';
				else
				{
					//success, change password
					$data2 = account::getRegistrationData($username, $new);
					$salt2 = $data2[0];
					$verifier2 = $data2[1];
					mysql_query("UPDATE account SET salt = '".$salt2."', verifier = '".$verifier2."' WHERE username = '".$username."'");
					echo 'Sua Senha foi alterada!';
                    if (isset($_COOKIE['cw_rememberMe']))
                        setcookie("cw_rememberMe", $username.' * '.$new, time()+30758400);
				}
			}
		  }
		}
	}

	public static function changePassword($account_name,$password)
	{
			$username = mysql_real_escape_string(strtoupper($account_name));
			$pass = mysql_real_escape_string(strtoupper($password));
			$pass_hash = sha1($username.':'.$pass);

			connect::selectDB('logondb');
			mysql_query("UPDATE `account` SET `sha_pass_hash`='{$pass_hash}', v='0', s='0' WHERE `id`='".$_SESSION['cw_user_id']."'");

			account::logThis("Senha alterada","passwordchange",NULL);
	}

	public static function changeForgottenPassword($account_name,$password)
	{
			connect::selectDB('logondb');
			$username = mysql_real_escape_string(strtoupper($account_name));
			$result = mysql_query("SELECT * FROM account WHERE username='".$username."'");
			$row = mysql_fetch_array($result);

			if($row)
			{
				$password = strtoupper($password);
				$password_hash = mysql_real_escape_string(sha1($username.':'.$password));

				connect::selectDB('logondb');
				mysql_query("UPDATE `account` SET `sha_pass_hash`='".$password_hash."', `v`='0', `s`='0' WHERE `id`='".$row['id']."'");
				account::logThis($account_name." Senha recuperada com sucesso","passwordrecoverd",NULL);
			}
	 }

	public static function forgotPW($account_name, $account_email)
	{
		$account_name = mysql_real_escape_string($account_name);
		$account_email = mysql_real_escape_string($account_email);

		if (empty($account_name) || empty($account_email))
			echo '<b class="red_text">Por favor, insira os dois campos.</b>';
		else
		{
			connect::selectDB('logondb');
			$result = mysql_query("SELECT COUNT('id') FROM account
								   WHERE username='".$account_name."' AND email='".$account_email."'");

			if (mysql_result($result,0)==0)
				echo '<b class="red_text">O Nome de Usuário ou Endereço de E-mail estão incorretos.</b>';
			else
			{
				//Success, lets send an email & add the forgotpw thingy.
				$code = RandomString();
				$emailSent = website::sendEmail($account_email,$GLOBALS['default_email'],'Esqueceu sua senha',"
				Olá. <br/><br/>
				A redefinição de Senha foi solicitada para a Conta ".$account_name." <br/>
				Se você deseja redefinir sua Senha, clique no link abaixo: <br/>
				<a href='".$GLOBALS['website_domain']."?p=forgotpw&code=".$code."&account=".account::getAccountID($account_name)."'>
				".$GLOBALS['website_domain']."?p=forgotpw&code=".$code."&account=".account::getAccountID($account_name)."</a>

				<br/><br/>

				Se você não solicitou isso, basta ignorar e deletar esta mensagem.<br/><br/>
				Atenciosamente, Administração.");
                if ($emailSent)
                {
				    $account_id = self::getAccountID($account_name);
				    connect::selectDB('webdb');

				    mysql_query("DELETE FROM password_reset WHERE account_id='".$account_id."'");
				    mysql_query("INSERT INTO password_reset (code,account_id)
				    VALUES ('".$code."','".$account_id."')");
				    echo "Um e-mail contendo o link para redefinir sua senha foi enviado para o Endereço de E-mail que você especificou.
					      Se você já enviou outros pedidos de Redefinição de Senha antes desse, eles não irão funcionar. <br/>";
                }
                else
                {
                    echo '<h4 class="red_text">Falha ao enviar o e-mail! (Verifique os registros de erro para obter mais detalhes)</h4>';
                }
			}
		}
	}

		public static function hasVP($account_name,$points)
		{
			$points = (int)$points;
			$account_id = self::getAccountID($account_name);
			connect::selectDB('webdb');
			$result = mysql_query("SELECT COUNT('id') FROM account_data WHERE vp >= '".$points."' AND id='".$account_id."'");

			if (mysql_result($result,0)==0)
				return FALSE;
			else
				return TRUE;
		}

		public static function hasDP($account_name,$points)
		{
			$points = (int)$points;
			$account_id = self::getAccountID($account_name);
			connect::selectDB('webdb');
			$result = mysql_query("SELECT COUNT('id') FROM account_data WHERE dp >= '".$points."' AND id='".$account_id."'");

			if (mysql_result($result,0)==0)
				return FALSE;
			else
				return TRUE;
		}


		public static function deductVP($account_id,$points)
		{
			$points = (int)$points;
			$account_id = (int)$account_id;
			connect::selectDB('webdb');

			mysql_query("UPDATE account_data SET vp=vp - ".$points." WHERE id='".$account_id."'");
		}

		public static function deductDP($account_id,$points)
		{
			$points = (int)$points;
			$account_id = (int)$account_id;
			connect::selectDB('webdb');

			mysql_query("UPDATE account_data SET dp=dp - ".$points." WHERE id='".$account_id."'");
		}

		public static function addDP($account_id,$points)
		{
			$account_id = (int)$account_id;
			$points = (int)$points;
			connect::selectDB('webdb');

			mysql_query("UPDATE account_data SET dp=dp + ".$points." WHERE id='".$account_id."'");
		}

		public static function addVP($account_id,$points)
		{
			$account_id = (int)$account_id;
			$points = (int)$points;
			connect::selectDB('webdb');

			mysql_query("UPDATE account_data SET dp=dp + ".$points." WHERE id='".$account_id."'");
		}

		public static function getAccountIDFromCharId($char_id,$realm_id)
		{
			$char_id = (int)$char_id;
			$realm_id = (int)$realm_id;
			connect::selectDB('webdb');
			connect::connectToRealmDB($realm_id);

			$result = mysql_query("SELECT account FROM characters WHERE guid='".$char_id."'");
			$row = mysql_fetch_assoc($result);
			return $row['account'];
		}


		public static function isGM($account_name)
		{
	         $account_id = self::getAccountID($account_name);
			 $result = mysql_query("SELECT COUNT(id) FROM account_access WHERE AccountID='".$account_id."' AND SecurityLevel >= 1");
			 if (mysql_result($result,0)>0)
				 return TRUE;
			 else
				 return FALSE;
		}

		public static function logThis($desc,$service,$realmid)
		{
			$desc = mysql_real_escape_string($desc);
			$realmid = (int)$realmid;
			$service = mysql_real_escape_string($service);
			$account = (int)$_SESSION['cw_user_id'];

			connect::selectDB('webdb');
			mysql_query("INSERT INTO user_log VALUES(NULL,'".$account."','".$service."','".time()."','".$_SERVER['REMOTE_ADDR']."','".$realmid."','".$desc."')");
	}
}