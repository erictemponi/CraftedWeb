<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
?>
<div class='box_two_title'>Entrar</div>
Por favor, entre para ver esta página. <hr/>
<?php
if(isset($_POST['x_login']))
	account::logIn($_POST['x_username'],$_POST['x_password'],$_POST['x_redirect'],$_POST['x_remember']);
?>
<form action="?p=login" method="post">
<table>
       <tr>
           <td>Nome de Usuário:</td>
           <td><input type="text" name="x_username"></td>
       </tr>
       <tr>
           <td>Senha:</td>
           <td><input type="password" name="x_password"></td>
       </tr>
       <tr>
           <td></td>
           <td><input type="checkbox" name="x_remember"> Lembrar de Mim</td>
       </tr>
       <tr>
           <td><input type="hidden" value="<?php echo $_GET['r']; ?>" name="x_redirect"></td>
           <td><input type="submit" value="Entrar" name="x_login"></td>
       </tr>
</table>
</form>