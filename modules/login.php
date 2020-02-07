<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
  if (!isset($_SESSION['cw_user'])) 
	  { 
		  if (isset($_POST['login'])) 
			account::logIn($_POST['login_username'],$_POST['login_password'],$_SERVER['REQUEST_URI'],$_POST['login_remember']);
?>
     <div class="box_one">
	 <div class="box_one_title">Gerenciamento de Conta</div> 
         <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
         <fieldset style="border: none; margin: 0; padding: 0;">
             <input type="text" placeholder="Nome de Usuário..." name="login_username" class="login_input" /><br/>
             <input type="password" placeholder="Senha..." name="login_password" class="login_input" style="margin-top: -1px;" /><br/>
             <input type="submit" value="Entrar" name="login" style="margin-top: 4px;" /> 
             <input type="checkbox" name="login_remember" checked="checked"/> 
             Lembrar de mim
         </fieldset>    
         </form> 
     <br/>
     <table width="100%">
            <tr>
                <td><a href="?p=register">Criar uma Conta</a></td>
                <td align="right"><a href="?p=forgotpw">Esqueceu sua Senha?</a></td>
            </tr>
     </table>
     </div>
<?php } ?>
