<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
define('INIT_SITE', TRUE);
require('../configuration.php');
require('connect.php');

$send = 'cmd=_notify-validate';

 foreach ($_POST as $key => $value)
 {
     if(get_magic_quotes_gpc() == 1)
         $value = urlencode(stripslashes($value));
     else
         $value = urlencode($value);
		 
     $send .= "&$key=$value";
 }
 
 $head .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
 $head .= "Tipo-de-Conteúdo: application/x-www-form-urlencoded\r\n";
 $head .= 'Corpo-do-Conteúdo: '.strlen($send)."\r\n\r\n";
 $fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
 
 connect::selectDB('webdb');

 if ($fp !== false)
 {
    fwrite($fp, $head.$send);
    $resp = stream_get_contents($fp);
	
    $resp = end(explode("\n", $resp));
	 
	$item_number = mysql_real_escape_string($_POST['item_number']);
	$item_name = mysql_real_escape_string($item_number['0']);
	$mc_gross = mysql_real_escape_string($_POST['mc_gross']);
	$txn_id = mysql_real_escape_string($_POST['txn_id']);
	$payment_date = mysql_real_escape_string($_POST['payment_date']);
	$first_name = mysql_real_escape_string($_POST['first_name']);
	$last_name = mysql_real_escape_string($_POST['last_name']);
	$payment_type = mysql_real_escape_string($_POST['payment_type']);
	$payer_email = mysql_real_escape_string($_POST['payer_email']);
	$address_city = mysql_real_escape_string($_POST['address_city']);
	$address_country = mysql_real_escape_string($_POST['address_country']);
	$custom = mysql_real_escape_string($_POST['custom']);
	$mc_fee = mysql_real_escape_string($_POST['mc_fee']);
	$fecha = date("Y-m-d");
	$payment_status = mysql_real_escape_string($_POST['payment_status']);
	$reciever = mysql_real_escape_string($_POST['receiver_email']);		 
	
if ($resp == 'VERIFIED')
{
	if ($reciever!=$GLOBALS['donation']['paypal_email'])
		exit();
			
	mysql_query("INSERT INTO payments_log(userid,paymentstatus,buyer_email,firstname,lastname,city,country,mc_gross,mc_fee,itemname,paymenttype,
	paymentdate,txnid,pendingreason,reasoncode,datecreation) values ('".$custom."','".$payment_status."','".$payer_email."',
	'".$first_name."','".$last_name."','".$address_city."','".$address_country."','".$mc_gross."',
	'".$mc_fee."','".$item_name."','".$payment_type."','".$payment_date."','".$txn_id."','".$pending_reason."',
	'".$reason_code."','".$fecha."')");
				
	$to = $payer_email;
	$subject = $GLOBALS['donation']['emailResponse'];
	$message = 'Olá '.$first_name.'
	Gostaríamos de informar que o pagamento recente que você fez foi bem sucedido.
	
	Se você precisar de mais ajuda, por favor contacte-nos através do forum.
	------------------------------------------
	E-mail de pagamento: '.$payer_email.'
	Valor do pagamento: '.$mc_gross.'
	Nome do comprador: '.$first_name.' '.$last_name.'
	Data do pagamento: '.$payment_date.'
	ID da Conta: '.$custom.'
	------------------------------------------
	Este pagamento foi salvo em nossos registros.
	
	Obrigado.
	';
	$headers = 'De: '.$GLOBALS['default_email'].'' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
	
	if ($GLOBALS['donation']['emailResponse']==true) 
	{
		mail($to, $subject, $message, $headers); 
		if ($GLOBALS['donation']['sendResponseCopy']==true)
			mail($GLOBALS['donation']['copyTo'], $subject, $message, $headers); 
	}

	$res = fgets ($fp, 1024);
	if($payment_status=="Completo")
	{
		mysql_query("INSERT INTO payments_log(userid,paymentstatus,buyer_email,firstname,lastname,mc_gross,paymentdate,datecreation) 
		 ('".$custom."','".$mc_gross."','".$payer_email."','".$first_name."','".$last_name."','".$mc_gross."','".$payment_date."','".$fecha."')");
		
		if($GLOBALS['donation']['donationType'] == 2)
		{
			for ($row = 0; $row < count($GLOBALS['donationList']); $row++)
			{
				$coins = $mc_gross;
				if($coins == $GLOBALS['donationList'][$row][2])
					mysql_query("UPDATE account_data SET dp=dp + ".$GLOBALS['donationList'][$row][1]." WHERE id='".$custom."'");
			}
		}
		elseif($GLOBALS['donation']['donationType'] == 1)
		{
			$coins = ceil($mc_gross);
			mysql_query("UPDATE account_data SET dp=dp + ".$coins." WHERE id='".$custom."'");
		}
				
 }
}
else if ($resp == 'INVALID')
{
		 mail($GLOBALS['donation']['copyTo'],"Doação Inválida","Pagamento inválido. Confira as informações abaixo: <br/>
		  ID do Usuário : ".$custom."
		  E-mail do comprador: ".$payer_email."
		  Valor: ".$mc_gross." USD
		  Data: ".$payment_date."
		  Primeiro nome: ".$first_name."
		  Último nome: ".$last_name."
		  ","De: ".$GLOBALS['donation']['responseFrom']."");  
		  
		  mail($payer_email,"Olá. Infelizmente, o último pagamento que você fez foi inválido. Entre em contato conosco para mais informações 
		  
		  Atenciosamente
		  Administração");
	
		 mysql_query("INSERT INTO payments_log(userid,paymentstatus,buyer_email,firstname,lastname,mc_gross,paymentdate,datecreation) 
		 VALUES ('".$custom."','".$payment_status." - INVALID','".$payer_email."','".$first_name."','".$last_name."','".$mc_gross."','".$payment_date."','".$fecha."')");
    }
 }

fclose ($fp); 
 
?> 