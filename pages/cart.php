<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
?>
<div class='box_two_title'>Carrinho de Compras</div>
<?php
echo '<span class="currency">Pontos de Votação: '.account::loadVP($_SESSION['cw_user']).'<br/>
'.$GLOBALS['donation']['coins_name'].': '.account::loadDP($_SESSION['cw_user']).'
</span>';

if(isset($_GET['return']) && $_GET['return']=="true")
	echo "<span class='accept'>Os itens foram enviados para o personagem selecionado!</span>";
elseif(isset($_GET['return']) && $_GET['return']!="true")
	echo "<span class='alert'>".$_GET['return']."</span>";

account::isNotLoggedIn();
connect::selectDB('webdb');

$counter = 0;
$totalDP = 0;
$totalVP = 0;

if(isset($_SESSION['donateCart']) && !empty($_SESSION['donateCart'])) 
{
	$counter = 1;
	
	echo '<h3>Loja de Doação</h3>';
	
	$sql = "SELECT * FROM shopitems WHERE entry IN(";
	foreach($_SESSION['donateCart'] as $entry => $value) {
		if($_SESSION['donateCart'][$entry]['quantity']!=0) {
		  $sql .= $entry. ',';
		  
		  connect::selectDB($GLOBALS['connection']['worlddb']);
		  $result = mysql_query("SELECT maxcount FROM item_template WHERE entry='".$entry."' AND maxcount>0");
		  if(mysql_result($result,0)!=0)
			  $_SESSION['donateCart'][$entry]['quantity']=1;
		  
		   connect::selectDB($GLOBALS['connection']['webdb']);
		}
	  }
	  
	  $sql = substr($sql,0,-1) . ") AND in_shop='donate' ORDER BY `itemlevel` ASC";

      $query = mysql_query($sql);
?>
<table width="100%" >
<tr id="cartHead">
  <th>Nome</th>
  <th>Quantidade</th>
  <th>Preço</th>
  <th>Ações</th></tr>
<?php
while($row = mysql_fetch_array($query)) 
{
	?><tr align="center">
        <td><a href="http://<?php echo $GLOBALS['tooltip_href']; ?>item=<?php echo $row['entry']; ?>"><?php echo $row['name']; ?></a></td>
        <td><input type="text" value="<?php echo $_SESSION['donateCart'][$row['entry']]['quantity']; ?>" style="width: 30px; text-align: center;"
        onFocus="$(this).next('.quantitySave').fadeIn()" id="donateCartQuantity-<?php echo $row['entry']; ?>" />
        <div class="quantitySave" style="display:none;">
        <a href="#" onclick="saveItemQuantityInCart('donateCart',<?php echo $row['entry']; ?>)">Salvar</a>
        </div>
        </td>
        <td><?php echo $_SESSION['donateCart'][$row['entry']]['quantity'] * $row['price']; ?> 
		<?php echo $GLOBALS['donation']['coins_name']; ?></td>
        <td><a href="#" onclick="removeItemFromCart('donateCart',<?php echo $row['entry']; ?>)">Remover</a></td>
    </tr>
    <?php
	$totalDP = $totalDP + ( $_SESSION['donateCart'][$row['entry']]['quantity'] * $row['price'] );
}
?>
</table>
<?php 
} 
if(isset($_SESSION['voteCart']) && !empty($_SESSION['voteCart'])) 
{
	$counter = 1;

	 echo '<h3>Loja de Votação</h3>';
	$sql = "SELECT * FROM shopitems WHERE entry IN(";
	foreach($_SESSION['voteCart'] as $entry => $value) {
		if($_SESSION['voteCart'][$entry]['quantity']!=0) {
		  $sql .= $entry. ',';
		  connect::selectDB($GLOBALS['connection']['worlddb']);
		  $result = mysql_query("SELECT maxcount FROM item_template WHERE entry='".$entry."' AND maxcount>0");
		  if(mysql_result($result,0)!=0)
			  $_SESSION['voteCart'][$entry]['quantity']=1;

		   connect::selectDB($GLOBALS['connection']['webdb']);
		}
	  }
	  
	  $sql = substr($sql,0,-1) . ") AND in_shop='vote' ORDER BY `itemlevel` ASC";

$query = mysql_query($sql);
?>
<table width="100%" >
<tr id="cartHead">
	<th>Nome</th>
	<th>Quantidade</th>
	<th>Preço</th>
	<th>Ações</th></tr>
<?php
while($row = mysql_fetch_array($query)) {
	?><tr align="center">
        <td><a href="http://<?php echo $GLOBALS['tooltip_href']; ?>item=<?php echo $row['entry']; ?>"><?php echo $row['name']; ?></a></td>
        <td><input type="text" value="<?php echo $_SESSION['voteCart'][$row['entry']]['quantity']; ?>" style="width: 30px; text-align: center;"
        onFocus="$(this).next('.quantitySave').fadeIn()" id="voteCartQuantity-<?php echo $row['entry']; ?>" />
        <div class="quantitySave" style="display:none;">
        <a href="#" onclick="saveItemQuantityInCart('voteCart',<?php echo $row['entry']; ?>)">Salvar</a>
        </div>
        </td>
        <td><?php echo $_SESSION['voteCart'][$row['entry']]['quantity'] * $row['price']; ?> Pontos de Votação</td>
        <td><a href="#" onclick="removeItemFromCart('voteCart',<?php echo $row['entry']; ?>)">Remover</a></td>
    </tr>
    <?php
	$totalVP = $totalVP + ( $_SESSION['voteCart'][$row['entry']]['quantity'] * $row['price'] );
}
?>
</table>
<?php
}
?>
<br/>
Custo total: <?php echo $totalVP; ?> Pontos de Votação, <?php echo $totalDP.' '.$GLOBALS['donation']['coins_name']; ?>
<hr/>

<?php
if(isset($_SESSION['donateCart']) && !empty($_SESSION['donateCart']) || isset($_SESSION['voteCart']) 
&& !empty($_SESSION['voteCart'])) 
{	?>
	<input type='submit' value='Limpar Carrinho' onclick='clearCart()'>
     <div style='position: absolute; right: 15px; bottom: 5px;'>
     <table>
     <tr><td>
	 <select id="checkout_values">
     <?php
	     account::getCharactersForShop($_SESSION['cw_user']);
	 ?>
     </select>
     </td><td><input type='submit' value='Finalizar'  onclick='checkout()'></td>
     </tr>
     </table>
     </div>
     
	<?php
}

if($counter==0)
	echo "<span class='attention'>Seu carrinho está vazio!</span>";

?>