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

//Check if trigger is set correctly
$file_headers = @get_headers($GLOBALS['website_domain'].'includes/misc/paypal_trigger.php');
if($file_headers[0] == 'HTTP/1.1 404 Não encontrada') 
{
    echo 'Esta página não está disponível, uma vez que o paypal não está definido.';
}
else
{
?>
<div class='box_two_title'>Doar</div>
Insira o valor de doação desejado e, em seguida, clique no botão de doação.<br/><hr/>
<table align="center">
       <tr>
           <td align="center"><img src="styles/global/images/paypal.png"></td>
       </tr>
       <tr>
           <td>
               <?php
			   if($GLOBALS['donation']['donationType']==1)
			   {
			   ?>
               	<input type="text" onKeyUp="changeAmount(this,'open')" value="Insira o número de moedas que deseja comprar..." onclick="this.value=''">
               <?php } 
			   elseif($GLOBALS['donation']['donationType']==2)
			   {
				   echo '<select onchange="changeAmount(this,\'list\')">';
				   for ($row = 0; $row < count($GLOBALS['donationList']); $row++)
					{
							echo "<option value='".$GLOBALS['donationList'][$row][1]."'>".$GLOBALS['donationList'][$row][0]."</option>";
					}
					echo '</select>'; 
			   }
			   ?>
           </td>
      </tr>
      <tr><td>
<center>
<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
          <input id="submit" type="image" src="styles/<?php echo $GLOBALS['template']['path']; ?>/images/donate.png" 
         		 border="0" name="submit" alt="Fazer pagamentos com PayPal - é rápido, grátis e seguro!" />
          <input type="hidden" name="notify_url" value="<?php echo $GLOBALS['website_domain']; ?>includes/misc/paypal_trigger.php" />
          <input type="hidden" name="add" value="1" />
          <input type="hidden" name="cmd" value="_xclick" />
          <input type="hidden" name="business" value="<?php echo $GLOBALS['donation']['paypal_email']; ?>" />
          <input type="hidden" id="item_name" name="item_name" value="<?php echo $GLOBALS['donation']['coins_name']; ?>" />
          <input type="hidden" id="item_number" name="item_number" value="" />
          <!-- ATENÇÃO HACKERS: Não tente mudar nada aqui, não vai funcionar, você não receberá uma recompensa e iremos guardar seu dinheiro. -->
          <input type="hidden" id="amount" name="amount" value="<?php
          if($GLOBALS['donation']['donationType']==2) 
		     echo $GLOBALS['donationList'][0][2]; 
		  else
		    echo 1;	 
		  ?>" />
          <input type="hidden" name="no_shipping" value="1" />
          <input type="hidden" name="no_note" value="1" />
          <input type="hidden" name="currency_code" value="<?php echo $GLOBALS['donation']['currency']; ?>" />
          <input type="hidden" name="lc" value="US" />
          <input type="hidden" name="bn" value="PP-ShopCartBF" />
          <input type="hidden" name="custom" value="<?php echo account::getAccountID($_SESSION['cw_user']); ?>">
         </form>
         </td>
     </tr>
     <?php 
	 	include("documents/refundpolicy.php"); 
		if($rp_enable == true)
		{
	 	?>
     <tr>
         <td align="center">
         	<br/>
         	Por favor, leia nossa <a href="#refundpolicy" onclick="viewRefundPolicy()">Política de Reembolso</a> antes de doar.
         <td>
     </tr>
     <?php } ?>
  </table>
</center>
<?php } ?>