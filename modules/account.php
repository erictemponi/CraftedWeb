<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */

?>
<?php if(isset($_SESSION['cw_user'])) { ?>
<div class="box_one">
<div class="box_one_title">Gerenciamento de Contas</div>
<span style="z-index: 99;">Bem vindo(a) de volta,  <?php echo $_SESSION['cw_user']; ?>
			<?php 
			if (isset($_SESSION['cw_gmlevel']) && $_SESSION['cw_gmlevel']>=$GLOBALS['adminPanel_minlvl'] && $GLOBALS['adminPanel_enable']==true) 
				echo ' <a href="admin/">(Painel do Administrador)</a>';
				
			if (isset($_SESSION['cw_gmlevel']) && $_SESSION['cw_gmlevel']>=$GLOBALS['staffPanel_minlvl'] && $GLOBALS['staffPanel_enable']==true) 
				echo ' <a href="staff/">(Painel da Equipe)</a>';
			?>
            </span>
			<hr/>
            <input type='button' value='Painel da Conta' onclick='window.location="?p=account"' class="leftbtn">
			<input type='button' value='Alterar Senha'  onclick='window.location="?p=changepass"' class="leftbtn">
            <input type='button' value='Loja de Votação' onclick='window.location="?p=voteshop"' class="leftbtn">  
			<input type='button' value='Loja de Doação'  onclick='window.location="?p=donateshop"' class="leftbtn">
            <input type='button' value='Convide um Amigo'  onclick='window.location="?p=raf"' class="leftbtn">
            <input type='button' value='Sair'  
            onclick='window.location="?p=logout&last_page=<?php echo $_SERVER["REQUEST_URI"]; ?>"' class="leftbtn">
</div>
			<?php } ?>
