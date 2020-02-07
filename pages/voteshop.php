<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
 account::isNotLoggedIn();

 /* Declare some general variables */ 
 $shopPage = mysql_real_escape_string($_GET['p']);
 $shopVar = "vote";
 $shopCurrency = "Pontos de Votação";
 
 $selected = 'selected="selected"';
 ///////////////////////////////
 ?>
<div class='box_two_title'>Loja de Votação

<div id='cartHolder' onclick='window.location="?p=cart"'>Carregando o Carrinho...</div> 
        <div id='cartArrow'>
        <img src='styles/default/images/arrow.png' border='none'/></div>
</div>

<?php
if($GLOBALS[$shopVar.'Shop']['enableShop']==FALSE)
	echo "<span class='attention'><b>Atenção! </b>A loja está fechada. Por favor, volte mais tarde.</span>";
else 
{
?>

<span class='currency'><?php echo $shopCurrency; ?>: 
<?php echo account::loadVP($_SESSION['cw_user']); ?></span>
<?php if (!isset($_GET['search'])) { $inputValue = "Procurar por um item..."; } else { $inputValue = $_GET['search_value']; } 

if($GLOBALS[$shopVar.'Shop']['shopType']==1)
{
	//Search enabled.
?>
<center>
        <form action="?p=<?php echo $shopPage; ?>" method="get">
        <input type="hidden" name="p" value="<?php echo $shopPage; ?>">
        <table> <tr valign="middle">
            <td><input type="text" onclick="this.value=''" value="<?php echo $inputValue; ?>" name="search_value"></td>          
            <td><input type="submit" value="Procurar" name="search"></td>
            <tr>
        </table>
        <?php if($GLOBALS[$shopVar.'Shop']['enableAdvancedSearch']==TRUE) { ?> <br/>
        Procura Avançada<br/>
		<table width="56%">
		                   <tr>	<td>	
                            <select name="q" style="width: 100%">
                                <option>--Qualidade--</option>
                                <option value="0" <?php if(isset($_GET['q']) && $_GET['q']==0 && $_GET['q']!="--Qualidade--" 
								&& isset($_GET['q'])) 
								{ echo $selected; } ?>>
                                Ruim</option>
                                <option value="1" <?php if(isset($_GET['q']) && $_GET['q']==1) { echo $selected; } ?>>Comun</option>
                                <option value="2" <?php if(isset($_GET['q']) && $_GET['q']==2) { echo $selected; } ?>>Incomun</option>
                                <option value="3" <?php if(isset($_GET['q']) && $_GET['q']==3) { echo $selected; } ?>>Raro</option>
                                <option value="4" <?php if(isset($_GET['q']) && $_GET['q']==4) { echo $selected; } ?>>Épico</option>
                                <option value="5" <?php if(isset($_GET['q']) && $_GET['q']==5) { echo $selected; } ?>>Legendário</option>
                                <option value="7" <?php if(isset($_GET['q']) && $_GET['q']==7) { echo $selected; } ?>>Relíquia</option>
                            </select>	
                           </td>
                           <td>	<select name="r" style="width: 100%">
                                    <option>--Resultados--</option>
                                    <option value="50" <?php if(isset($_GET['r']) && $_GET['r']==50) { echo $selected; }?>>50</option>
                                    <option value="100" <?php if(isset($_GET['r']) && $_GET['r']==100) { echo $selected; }?>>100</option>
                                    <option value="150" <?php if(isset($_GET['r']) && $_GET['r']==150) { echo $selected; }?>>150</option>
                                    <option value="200" <?php if(isset($_GET['r']) && $_GET['r']==200) { echo $selected; }?>>200</option>
                            </select>	
                        
                            </td>
                           	</tr>
                            <tr>	
                            <td>	
								<select name="t" style="width: 100%">
                                <option>--Tipo--</option>
                                <option value="0" <?php if(isset($_GET['t']) && $_GET['t']==0 && $_GET['t']!="--Tipo--"
								&& isset($_GET['q'])) 
								{ echo $selected; } ?>>Consumível</option>
                                <option value="1" <?php if(isset($_GET['t']) && $_GET['t']==1) { echo $selected; } ?>>Recipiente</option>
                                <option value="2" <?php if(isset($_GET['t']) && $_GET['t']==2) { echo $selected; } ?>>Armas</option>
                                <option value="3" <?php if(isset($_GET['t']) && $_GET['t']==3) { echo $selected; } ?>>Jóias</option>
                                <option value="4" <?php if(isset($_GET['t']) && $_GET['t']==4) { echo $selected; } ?>>Armadura</option>
                                <option value="15" <?php if(isset($_GET['t']) && $_GET['t']==15) { echo $selected; } ?>>Diversos</option>
                                <option value="16"<?php if(isset($_GET['t']) && $_GET['t']==16) { echo $selected; } ?>>Glyph</option>
                                <option value="15-5" <?php if(isset($_GET['t']) && $_GET['t']=="15-5") { echo $selected; } ?>>Montaria</option>
                                <option value="15-2" <?php if(isset($_GET['t']) && $_GET['t']=="15-2") { echo $selected; } ?>>Animal de Estimação</option>
                                </select>	
                           </td> 
                           <td>	 
                                <input type="checkbox" name="st"  value="8"/> Heroico
                            </td>
                           	</tr>
                            <tr>
                                <td>
                                <select name="f" style="width: 100%">
                                    <option>--Facção--</option>
                                    <option value="1" <?php if(isset($_GET['f']) && $_GET['f']==1) { echo $selected; }?>>Somente Horda</option>
                                    <option value="2" <?php if(isset($_GET['f']) && $_GET['f']==2) { echo $selected; }?>>Somente Aliança</option>
                                </select>
                                </td>
                                <td>
                                <select name="c" style="width: 100%">
                                    <option>--Classe--</option>
                                    <option value="1" <?php if(isset($_GET['c']) && $_GET['c']==1) { echo $selected; }?>>Somente Guerreiros</option>
                                    <option value="2" <?php if(isset($_GET['c']) && $_GET['c']==2) { echo $selected; }?>>Somente Paladinos</option>
                                    <option value="4" <?php if(isset($_GET['c']) && $_GET['c']==4) { echo $selected; }?>>Somente Caçadores</option>
                                    <option value="8" <?php if(isset($_GET['c']) && $_GET['c']==8) { echo $selected; }?>>Somente Ladinos</option>
                                    <option value="16" <?php if(isset($_GET['c']) && $_GET['c']==16) { echo $selected; }?>>Somente Sacerdotes</option>
                                    <option value="32" <?php if(isset($_GET['c']) && $_GET['c']==32) { echo $selected; }?>>Somente Cavaleiros da Morte</option>
                                    <option value="64" <?php if(isset($_GET['c']) && $_GET['c']==64) { echo $selected; }?>>Somente Xamãs</option>
                                    <option value="128" <?php if(isset($_GET['c']) && $_GET['c']==128) { echo $selected; }?>>Somente Magos</option>
                                    <option value="256" <?php if(isset($_GET['c']) && $_GET['c']==256) { echo $selected; }?>>Somente Bruxos</option>
                                    <option value="1024" <?php if(isset($_GET['c']) && $_GET['c']==1024) { echo $selected; }?>>Somente Druidas</option>
                                </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                            <select name="ilfrom" style="width: 100%">
                                            <option>--Nível do item de--</option>
                                            <?php
											    for ($i = 1; $i <= $GLOBALS['maxItemLevel']; $i++) 
												{
													 if($_GET['ilfrom']==$i)
														 echo "<option selected='selected'>";
													 else
														 echo "<option>";

													echo $i."</option>";
												}
											?>
                                    </select>	
                                </td>
                                <td>
                                            <select name="ilto" style="width: 100%">
                                            <option>--Nível do item para--</option>
                                            <?php
											    for ($i = $GLOBALS['maxItemLevel']; $i >= 1; $i--) 
												{
													 if($_GET['ilto']==$i)
														 echo "<option selected='selected'>";
													 else
														 echo "<option>";

													echo $i."</option>";
												}
											?>
                                    </select>	
                                </td>
                            </tr>
        </table>
		<?php } ?>
        </form><br/>
</center> 
<?php 
if (isset($_GET['search'])) {
		shop::search($_GET['search_value'],$shopVar,$_GET['q'],$_GET['t'],$_GET['ilfrom'],$_GET['ilto'],$_GET['r'],$_GET['f'],$_GET['c'],$_GET['st']);
	}
}
elseif($GLOBALS[$shopVar.'Shop']['shopType']==2)
{
	//List all items.
	shop::listAll($shopVar);	
	}
}
?>