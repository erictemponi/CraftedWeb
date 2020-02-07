<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
?>
<?php account::isNotLoggedIn(); 
if (isset($_POST['save'])) {
	account::changeEmail($_POST['email'],$_POST['current_pass']);
}
?>
<div class='box_two_title'>Alterar E-mail</div>
<form action="?p=settings" method="post">
<table width="70%">
       <tr>
           <td>Endereço de E-mail:</td> 
           <td><input type="text" name="email" value="<?php echo account::getEmail($_SESSION['cw_user']); ?>"></td>
       </tr>
       <tr>
           <td></td> 
           <td><hr/></td>
       </tr>
       <tr>
           <td>Insira sua senha atual:</td> 
           <td><input type="password" name="current_pass"></td>
       </tr>
       
       <tr>
           <td></td> 
           <td><input type="submit" value="Salvar" name="save"></td>
       </tr>
</table>
</form>