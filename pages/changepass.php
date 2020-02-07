<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
?>
<div class='box_two_title'>Alterar Senha</div>
<?php
account::isNotLoggedIn();
if (isset($_POST['change_pass']))
	account::changePass($_POST['cur_pass'],$_POST['new_pass'],$_POST['new_pass_repeat']);
?>
<form action="?p=changepass" method="post">
<table width="70%">
       <tr>
           <td>Nova Senha:</td> 
           <td><input type="password" name="new_pass" class="input_text"/></td>
       </tr> 
       <tr>
           <td>Confirmar Nova Senha:</td> 
           <td><input type="password" name="new_pass_repeat" class="input_text"/></td>
       </tr>
        <tr>
           <td></td> 
           <td><hr/></td>
       </tr> 
       <tr>
           <td>Insira a Senha Atual:</td> 
           <td><input type="password" name="cur_pass" class="input_text"/></td>
       </tr>  
       <tr>
           <td></td> 
           <td><input type="submit" value="Alterar Senha" name="change_pass" /></td>
       </tr>                
</table>                 
</form>