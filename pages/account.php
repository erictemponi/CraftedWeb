<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
?>
<?php 
account::isNotLoggedIn();
?>
<div class='box_two_title'>Minha Conta</div>
<table style="width: 100%; margin-top: -15px;">
<tr>
<td><span class='blue_text'>Nome da conta</span></td><td> <?php echo ucfirst(strtolower($_SESSION['cw_user']));?></td>
<?php $date = date_create(account::getJoindate($_SESSION['cw_user'])); ?>
<td><span class='blue_text'>Registrado em</span></td><td><?php echo date_format($date, "d/m/Y à\s H:i:s"); ?></td>
</tr>
<tr>
    <td><span class='blue_text'>Endereço de e-mail</span></td><td><?php echo account::getEmail($_SESSION['cw_user']);?></td>
    <td><span class='blue_text'>Pontos de Votação</span></td><td><?php echo account::loadVP($_SESSION['cw_user']); ?></td>
</tr>
<tr>
    <td><span class='blue_text'>Situação da conta</span></td><td><?php echo account::checkBanStatus($_SESSION['cw_user']);?></td>
    <td><span class='blue_text'><?php echo $GLOBALS['donation']['coins_name']; ?></span></td><td><?php echo account::loadDP($_SESSION['cw_user']); ?></td>
</tr>
<br/>
</table>
 </div>
<div class='box_two'>      
      <div class='box_two_title'>Serviços</div>
     <div id="account_func_placeholder">
			  <div class='account_func' onclick="acct_services('character')">Serviços do Personagem</div>
			  <div class='account_func' onclick="acct_services('account')">Serviços da Conta</div>        
			  <div class='account_func' onclick="acct_services('settings')">Configurações</div>
              
			  <div class='hidden_content' id='character'>
                 <?php if($GLOBALS['service']['unstuck']['status']=='TRUE') { ?>
                     <div class='service' onclick='redirect("?p=unstuck")'>
                     <div class='service_icon'><img src='styles/global/images/icons/character_migration.png'></div>
                     <h3>Destravar</h3>
                     <div class='service_desc'>Destrave seu personagem.</div>
                     </div>
                 <?php } ?>
                 
                 <?php if($GLOBALS['service']['revive']['status']=='TRUE') { ?>
                     <div class='service' onclick='redirect("?p=revive")'>
                     <div class='service_icon'><img src='styles/global/images/icons/revive.png'></div>
                     <h3>Reviver</h3>
                     <div class='service_desc'>Reviva seu personagem</div> 
                     </div>
                 <?php } ?>
                 
                 <?php if($GLOBALS['service']['teleport']['status']=='TRUE') { ?>
                     <div class='service' onclick='redirect("?p=teleport")'>
                     <div class='service_icon'><img src='styles/global/images/icons/transfer.png'></div>
                     <h3>Teleportar</h3>
                     <div class='service_desc'>Teleporte seu personagem</div> 
                     </div>
                 <?php } ?>
                 
                 <?php if($GLOBALS['service']['appearance']['status']=='TRUE') { ?>
                     <div class='service' onclick='redirect("?p=service&s=appearance")'>
                     <div class='service_icon'><img src='styles/global/images/icons/appearance.png'></div>
                     <h3>Alterar a Aparência</h3>
                     <div class='service_desc'>Personalize a aparência de seu personagem (mudança de nome opcional inclusa)</div> 
                     </div>
                 <?php } ?>
                 
                 <?php if($GLOBALS['service']['race']['status']=='TRUE') { ?>
                     <div class='service' onclick='redirect("?p=service&s=race")'>
                     <div class='service_icon'><img src='styles/global/images/icons/race_change.png'></div>
                     <h3>Alterar Raça</h3>
                     <div class='service_desc'>Alterar a raça de seu personagem (dentro da facção atual)</div> 
                     </div>
                 <?php } ?>
                 
                 <?php if($GLOBALS['service']['name']['status']=='TRUE') { ?>
                     <div class='service' onclick='redirect("?p=service&s=name")'>
                     <div class='service_icon'><img src='styles/global/images/icons/name_change.png'></div>
                     <h3>Alterar Nome</h3>
                     <div class='service_desc'>Alterar o nome de seu personagem</div> 
                     </div>
                 <?php } ?>
                 
                 <?php if($GLOBALS['service']['faction']['status']=='TRUE') { ?>
                     <div class='service' onclick='redirect("?p=service&s=faction")'>
                     <div class='service_icon'><img src='styles/global/images/icons/factions.png'></div>
                     <h3>Alterar Facção</h3>
                     <div class='service_desc'>Altere a facção de seu personagem (De Horda para Aliança e de Aliança para Horda)</div> 
                     </div>
                 <?php } ?>
              </div>
              <div class='hidden_content' id='account'>
              
                     <div class='service' onclick='redirect("?p=vote")'>
                     <div class='service_icon'><img src='styles/global/images/icons/character_migration.png'></div>
                     <h3>Votar</h3>
                     <div class='service_desc'>Votar e receber recompensas</div> 
                     </div>
                 
                     <div class='service' onclick='redirect("?p=donate")'>
                     <div class='service_icon'><img src='styles/global/images/icons/visa.png'></div>
                     <h3>Doar</h3>
                     <div class='service_desc'>Doar e receber recompensas</div> 
                     </div>
                 
                     <div class='service' onclick='redirect("?p=voteshop")'>
                     <div class='service_icon'><img src='styles/global/images/icons/raf.png'></div>
                     <h3>Loja de Votação</h3>
                     <div class='service_desc'>Peça a sua recompensa!</div> 
                     </div>
                 
                     <div class='service' onclick='redirect("?p=donateshop")'>
                     <div class='service_icon'><img src='styles/global/images/icons/raf.png'></div>
                     <h3>Loja de Doação</h3>
                     <div class='service_desc'>Peça a sua recompensa!</div> 
                     </div>
              
              </div>
              
              <div class='hidden_content' id='settings'>
              
                     <div class='service' onclick='redirect("?p=changepass")'>
                     <div class='service_icon'><img src='styles/global/images/icons/arena.png'></div>
                     <h3>Alterar Senha</h3>
                     <div class='service_desc'>Altere a senha de sua conta</div>
                     </div>
                 
                     <div class='service' onclick='redirect("?p=settings")'>
                     <div class='service_icon'><img src='styles/global/images/icons/ptr.png'></div>
                     <h3>Alterar E-mail</h3>
                     <div class='service_desc'>Altere o endereço de e-mail associado à sua conta</div> 
                     </div>
              
              </div>
      </div>