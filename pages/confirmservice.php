<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
$service = $_GET['s'];
$guid = (int)$_GET['guid'];
$realm_id = (int)$_GET['rid'];

$service_title = ucfirst($service." Alterar");

$service_desc = array(
	'race' 
	=> 
	'<ul>
		<li>Você pode selecionar uma nova raça para o seu personagem somente da mesma facção, e a raça precisa ser compatível com a classe de seu personagem.</li>
		<li>As reputações, magias raciais e a cidade natal serão alteradas de acordo com a nova raça que você escolher.</li>
		<li>A alteração de reino não está incluída na alteração de raça.</li>
	</ul>'
,
	'name' 
	=> 
	'<ul>
		<li>A alteração do nome não pode ser revertida, a não ser que uma nova alteração de nome seja solicitada (sujeita aos mesmos custos e limitações).</li>
	</ul>'
,
	'appearance' 
	=> 
	'<ul>
		<li>Este serviço permite que você altere o sexo de seu personagem, rosto, cabelo, cor da pele, penteado, nome e outras características determinadas pela combinação de sexo e raça. No entanto, você não pode alterar a raça ou a classe de seu personagem.</li>
		<li>Se você alterar o nome do personagem durante este processo, o nome que você escolher estará disponível no reino em que o personagem foi criado.</li>
		<li>A alteração na aparência não pode ser revertida, uma vez que concluída, a não ser que uma nova alteração na aparência seja solicitada (sujeita aos mesmos custos e limitações).</li>
	</ul>'
,
	'faction' 
	=> 
	'<ul>
		<li>Dutante este processo, você deverá selecionar uma raça da facção oposta à anterior. Você não pode alterar a classe de seu personagem.</li>
		<li>A alteração de reino não está inclusa na alteração de facção.</li>
	</ul>'
			
);

if($GLOBALS['service'][$service]['status']!="TRUE") 
	echo "Está página está indisponível.";
else
{
?>
<div class="box_two_title">Confirmar <?php echo $service_title; ?></div>
<?php
if($GLOBALS['service'][$service]['price']==0) 
      	echo '<span class="attention">'.$service_title.' é gratuito.</span>';
else
{ ?>
<span class="attention"><?php echo $service_title; ?> custos 
<?php 
echo $GLOBALS['service'][$service]['price'].' '.website::convertCurrency($GLOBALS['service'][$service]['currency']); ?></span>
<?php 
if($GLOBALS['service'][$service]['currency']=="vp")
	echo "<span class='currency'>Pontos de Votação: ".account::loadVP($_SESSION['cw_user'])."</span>";
elseif($GLOBALS['service'][$service]['currency']=="dp")
	echo "<span class='currency'>".$GLOBALS['donation']['coins_name'].": ".account::loadDP($_SESSION['cw_user'])."</span>";
} 

	account::isNotLoggedIn();
	
	connect::selectDB('webdb');
	$result = mysql_query("SELECT name FROM realms WHERE id='".$realm_id."'");
	$row = mysql_fetch_assoc($result);
	$realm = $row['name'];
	
	connect::connectToRealmDB($realm_id);
				
	$result = mysql_query("SELECT name,guid,gender,class,race,level,online FROM characters WHERE guid='".$guid."'");
	$row = mysql_fetch_assoc($result)
	?>
    <h4>Personagem selecionado:</h4>
    <div class='charBox'>
    <table width="100%">
	        <tr>
                <td width="73">
                <?php if(!file_exists('styles/global/images/portraits/'.$row['gender'].'-'.$row['race'].'-'.$row['class'].'.gif'))
				       echo '<img src="styles/'.$GLOBALS['template']['path'].'/images/unknown.png" />';
					   else 
					   { ?>
                <img src="styles/global/images/portraits/<?php echo $row['gender'].'-'.$row['race'].'-'.$row['class']; ?>.gif" border="none">
                    <?php } ?>
                </td>
                
                <td width="160"><h3><?php echo $row['name']; ?></h3>
					<?php echo $row['level']." ".character::getRace($row['race'])." ".character::getGender($row['gender']).
                    " ".character::getClass($row['class']); ?>
                </td>
                
                <td>Reino: <?php echo $realm; ?>
					<?php if($row['online']==1)
                   echo "<br/><span class='red_text'>Por favor, deslogue antes de aplicar este serviço.</span>";?>
                </td>
            </tr>                         
	</table>
    </div> 
    <p/>&nbsp;
    <h4>Condições e Isenções de Responsabilidade</h4>
    <?php
	echo $service_desc[$service];
	?>
       <input type="submit" value="Aceitar e Continuar" 
       <?php if($row['online']==0) { ?> 
       onclick='confirmService(<?php echo $row['guid']; ?>,<?php echo $realm_id; ?>,"<?php echo $service; ?>","<?php echo $service_title; ?>"
       ,"<?php echo $row['name']; ?>")' <?php }
       else { echo 'disabled="disabled"'; } ?>>
    <?php
}
?>
