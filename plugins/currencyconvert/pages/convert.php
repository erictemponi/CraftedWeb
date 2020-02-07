<?php
/*
              _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
$divide = 40;
##############


account::isNotLoggedIn();
?>

<h2>Conversor de Moedas</h2>
<?php echo $GLOBALS['website_title']; ?> permite converter os seus Pontos de Votação em <?php echo $GLOBALS['donation']['coins_name']; ?>!<br/>
A cada <?php echo $divide; ?> Pontos de Votação, você receberá 1 Ponto de Doação! <br/>
Você tem <b><?php echo account::loadVP($_SESSION['cw_user']); ?></b> Pontos de Votação, que lhe dariam <b><?php echo floor(account::loadVP($_SESSION['cw_user'])/$divide); ?></b> <?php echo $GLOBALS['donation']['coins_name']; ?>.

<hr/>

<form action="?p=convert" method="post">
<table>
	<tr>
    	<td>
        	Pontos de Votação:
        </td>
        <td>
        	 <select name="conv_vp" onchange="calcConvert(<?php echo $divide; ?>)" id="conv_vp">
                  <option value="40">40</option>
                  <option value="80">80</option>
                  <option value="120">120</option>
                  <option value="160">160</option>
                  <option value="200">200</option>
          	</select>
        </td>
   </tr>
   <tr>
   		<td>
        <?php echo $GLOBALS['donation']['coins_name']; ?>: 
        </td>
        <td>
        	<input type="text" id="conv_dp" style="width: 70px;" value="1" readonly/>
        </td>
   </tr>
    <tr>
   		<td>
        </td>
        <td>
        	<hr/>
        </td>
   </tr>
   <tr>
   		<td>
        </td>
        <td>
        	<input type="submit" value="Converter" name="convert" />
        </td>
   </tr>
</table>   	     
</form>
<?php
if(isset($_POST['convert'])) {
	$vp = round((int)$_POST['conv_vp']);
	
	if(account::hasVP($_SESSION['cw_user'],$vp)==FALSE) 
		echo "<span class='alert'>Você não tem um número suficiente de Pontos de Votação!</span>";
	else {
		$dp = floor($vp / $divide);
		
		account::deductVP(account::getAccountID($_SESSION['cw_user']),$vp);
		account::addDP(account::getAccountID($_SESSION['cw_user']),$dp);	
		
		account::logThis("Convertido ".$vp." Pontos de Votação para ".$dp." ".$GLOBALS['donation']['coins_name'],"currencyconvert",NULL);
		
		header("Location: ?p=convert");
        exit;
	}
}
?>