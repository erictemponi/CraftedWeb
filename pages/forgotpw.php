<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
?>
<div class='box_two_title'>Esqueceu sua Senha</div>
<?php 
account::isLoggedIn();
if (isset($_POST['forgotpw'])) 
	account::forgotPW($_POST['forgot_username'],$_POST['forgot_email']);

if(isset($_GET['code']) || isset($_GET['account'])) {
 if (!isset($_GET['code']) || !isset($_GET['account']))
	 echo "<b class='red_text'>Erro no link, um ou mais valores estão faltando.</b>";
 else 
 {
	 connect::selectDB('webdb');
	 $code = mysql_real_escape_string($_GET['code']); $account = mysql_real_escape_string($_GET['account']);
	 $result = mysql_query("SELECT COUNT('id') FROM password_reset WHERE code='".$code."' AND account_id='".$account."'");
	 if (mysql_result($result,0)==0)
		 echo "<b class='red_text'>Os valores especificados não correspondem aos do Banco de Dados.</b>";
	 else 
	 {
		 $newPass = RandomString();
		 echo "<b class='yellow_text'>Sua nova senha é: ".$newPass." <br/><br/>Por favor, entre e altere sua senha.</b>";
		 mysql_query("DELETE FROM password_reset WHERE account_id = '".$account."'");
		 $account_name = account::getAccountName($account);
		 
		 account::changeForgottenPassword($account_name,$newPass);
		 
		 $ignoreForgotForm = true;
	 }
 }
}
if (!isset($ignoreForgotForm)) { ?> 
Para redefinir sua senha, insira o Nome de Usuário e E-mail usados no registro da Conta. Um e-mail será enviado para você, contendo um link para redefinir sua senha. <br/><br/>

<form action="?p=forgotpw" method="post">
<table width="80%">
    <tr>
         <td align="right">Nome de Usuário:</td> 
         <td><input type="text" name="forgot_username" /></td>
    </tr>
    <tr>
         <td align="right">E-mail:</td> 
         <td><input type="text" name="forgot_email" /></td>
    </tr>
    <tr>
         <td></td>
         <td><hr/></td>
    </tr>
    <tr>
         <td></td>
         <td><input type="submit" value="Enviar" name="forgotpw" /></td>
    </tr>
</table>
</form> <?php } ?>