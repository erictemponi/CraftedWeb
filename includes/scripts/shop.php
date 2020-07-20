<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */

session_start();
define('INIT_SITE', TRUE);
require('../configuration.php');
require('../misc/connect.php');
require('../classes/account.php');
require('../classes/character.php');
require('../classes/shop.php');

connect::connectToDB();


if($_POST['action'] == 'removeFromCart')
{
	unset($_SESSION[$_POST['cart']][$_POST['entry']]);
	return;
}

if($_POST['action'] == 'addShopitem')
{
   $entry = (int)preg_replace("/[^0-9]/", "", $_POST['entry']);
   $shop =  mysql_real_escape_string($_POST['shop']);

   if(isset($_SESSION[$_POST['cart']][$entry]))
		$_SESSION[$_POST['cart']][$entry]['quantity']++;
   else
   {
	connect::selectDB('webdb');

	$result = mysql_query('SELECT entry, price FROM shopitems WHERE entry="'.$entry.'" AND in_shop="'.$shop.'"');
	if(mysql_num_rows($result) != 0)
	{
		$row = mysql_fetch_array($result);
		$_SESSION[$_POST['cart']][$row['entry']] = array('quantity' => 1, 'price' => $row['price']);
	}
  }
  return;
}

if($_POST['action'] == 'clear')
{
	unset($_SESSION['donateCart']);
	unset($_SESSION['voteCart']);
    return;
}

if($_POST['action'] == 'getMinicart')
{
    $curr = ($_POST['cart'] == 'donateCart' ? $GLOBALS['donation']['coins_name'] : 'Pontos de Votação');

	if(!isset($_SESSION[$_POST['cart']]))
	{
		echo "<b>Mostrar Carrinho:</b> 0 Itens (0 ".$curr.")";
		exit;
	}

    $entrys = array_keys($_SESSION[$_POST['cart']]);
    if (count($entrys) <= 0)
    {
        echo "<b>Mostrar Carrinho:</b> 0 Itens (0 ".$curr.")";
        exit;
    }

    $num        = 0;
    $totalPrice = 0;
    connect::selectDB('webdb');
    $shop_filt = mysql_real_escape_string(substr($_POST['cart'], 0, -4));

    // Generate List
    $query = "SELECT entry, price FROM shopitems WHERE in_shop = '{$shop_filt}' AND entry IN (";
    $query .= implode(', ', $entrys);
    $query .= ")";

    if ($result = mysql_query($query))
    {
        while($row = mysql_fetch_assoc($result))
        {
            $item = $_SESSION[$_POST['cart']][$row['entry']];
            if ($item)
            {
                $num = $num + $item['quantity'];
                $totalPrice = $totalPrice + ($item['quantity'] * $row['price']);
                unset($item);
            }
        }
    }

    echo "<b>Mostrar Carrinho:</b> {$num} Itens ({$totalPrice} {$curr})";
    return;
}

if($_POST['action'] == 'saveQuantity')
{
    // Prevent sql injection by only allowing numbers
    $qty = (int)preg_replace("/[^0-9]/", "", $_POST['quantity']);
	if($qty <= 0)
		unset($_SESSION[$_POST['cart']][$_POST['entry']]);
	else
	    $_SESSION[$_POST['cart']][$_POST['entry']]['quantity'] = $qty;
    return;
}


function process_cart($cart, $charaID, $character, $accountID, $realm)
{
    if (!isset($_SESSION[$cart.'Cart']))
        return;
    $host      = $GLOBALS['realms'][$realm]['host'];
    $rank_user = $GLOBALS['realms'][$realm]['rank_user'];
    $rank_pass = $GLOBALS['realms'][$realm]['rank_pass'];
    $ra_port   = $GLOBALS['realms'][$realm]['ra_port'];

    $totalPrice = 0;
    $entrys = array_keys($_SESSION[$cart.'Cart']);
    if (count($entrys) > 0)
    {
        // Array of valid items
        $items = array();

        // Generate List
        $query = "SELECT entry, price FROM shopitems WHERE in_shop = '{$cart}' AND entry IN (";
        $query .= implode(', ', $entrys);
        $query .= ")";
        if ($result = mysql_query($query))
        {
            while($row = mysql_fetch_assoc($result))
            {
                $item = $_SESSION[$cart.'Cart'][$row['entry']];
                if ($item)
                {
                    // Update Price
                    $item['price'] = $row['price'];
                    $item['totalPrice'] = $row['price'] * $item['quantity'];
                    $totalPrice = $totalPrice + $item['totalPrice'];

                    // Valid Item!
                    $items[$row['entry']] = $item;
                    unset($item);
                }
            }
        }
        if($cart == 'donate' And account::hasDP($_SESSION['cw_user'], $totalPrice) == FALSE)
            die("Você não tem {$GLOBALS['donation']['coins_name']} suficientes!");
        else if($cart == 'vote' And account::hasVP($_SESSION['cw_user'], $totalPrice) == FALSE)
            die("Você não tem Pontos de Votação suficientes!");

        foreach ($items as $entry => $info)
        {
            $num = $info['quantity'];
            while ($num > 0)
            {
                $qty = $num > 12 ? 12 : $num;
                $command = "send items ".$character." \"Sua recompensa\" \"Aqui está a recompensa pela sua compra na loja do nosso site, aproveite-a!\" ".$entry.":".$qty." ";

                if ($error = sendRA($command, $rank_user, $rank_pass, $host, $ra_port))
                {
                    echo 'Problemas de conexão...Abortando | Erro: '.$error;
                    exit;
                }
                else
                {
                    shop::logItem($cart, $entry, $charaID, $accountID, $realm, $qty);
                    if ($cart == 'donate')
                        account::deductDP($accountID, $info['price'] * $qty);
                    else
                        account::deductVP($accountID, $info['price'] * $qty);

                    // Update quantity incase of errors on the next loop
                    $_SESSION[$cart.'Cart'][$entry]['quantity'] -= $qty;
                }

                $num = $num - $qty;
            }
            // All $entry have been sent
            unset($_SESSION[$cart.'Cart'][$entry]);
        }
    }
    // Empty Cart
    unset($_SESSION[$cart.'Cart']);
}

if($_POST['action']=='checkout')
{
	$values = explode('*', $_POST['values']);
    $realm = $values[1];
    $character = character::getCharname($values[0], $realm);
    $accountID = account::getAccountID($_SESSION['cw_user']);

    connect::selectDB('webdb');
    require('../misc/ra.php');
    process_cart('donate', $values[0], $character, $accountID, $realm);
    process_cart('vote', $values[0], $character, $accountID, $realm);
    echo TRUE;
}

if($_POST['action'] == 'removeItem')
{
	if(account::isGM($_SESSION['cw_user']) == FALSE)
    	exit;

	$entry = (int)preg_replace("/[^0-9]/", "", $_POST['entry']);
	$shop = mysql_real_escape_string($_POST['shop']);

	connect::selectDB('webdb');
	mysql_query("DELETE FROM shopitems WHERE entry='".$entry."' AND in_shop='".$shop."'");
    return;
}

if($_POST['action'] == 'editItem')
{
	if(account::isGM($_SESSION['cw_user'])==FALSE)
    	exit();

	$entry = (int)preg_replace("/[^0-9]/", "", $_POST['entry']);
	$shop  = mysql_real_escape_string($_POST['shop']);
	$price = (int)preg_replace("/[^0-9]/", "", $_POST['price']);

	connect::selectDB('webdb');

	if($price >= 0)
		mysql_query("UPDATE shopitems SET price='".$price."' WHERE entry='".$entry."' AND in_shop='".$shop."'");
    return;
}
?>