<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
/**
 * 
 * Sample IPN Handler for Item Payments
 * 
 * The purpose of this code is to help you to understand how to process the Instant Payment Notification 
 * variables for a payment received through AlertPay's buttons and integrate it in your PHP site. The following
 * code will ONLY handle ITEM payments. For handling IPNs for SUBSCRIPTIONS, please refer to the appropriate
 * sample code file.
 *	
 * Put this code into the page which you have specified as Alert URL.
 * The variables being read from the $_POST object in the code below are pre-defined IPN variables and the
 * the conditional blocks provide you the logical placeholders to process the IPN variables. It is your responsibility
 * to write appropriate code as per your requirements.
 *	
 * If you have any questions about this script or any suggestions, please visit us at: dev.alertpay.com
 * 
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY
 * OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT
 * LIMITED TO THE IMPLIED WARRANTIES OF FITNESS FOR A PARTICULAR PURPOSE.
 * 
 * @author AlertPay
 * @copyright 2010
 */
 
	//The value is the Security Code generated from the IPN section of your AlertPay account. Please change it to yours.
	define("IPN_SECURITY_CODE", "NY86MQyPXGcUXJ2v");
	define("MY_MERCHANT_EMAIL", "youremail@gmail.com");

	//Setting information about the transaction
	$receivedSecurityCode = $_POST['ap_securitycode'];
	$receivedMerchantEmailAddress = $_POST['ap_merchant'];	
	$transactionStatus = $_POST['ap_status'];
	$testModeStatus = $_POST['ap_test'];	 
	$purchaseType = $_POST['ap_purchasetype'];
	$totalAmountReceived = $_POST['ap_totalamount'];
	$feeAmount = $_POST['ap_feeamount'];
    $netAmount = $_POST['ap_netamount'];
	$transactionReferenceNumber = $_POST['ap_referencenumber'];
	$currency = $_POST['ap_currency']; 	
	$transactionDate= $_POST['ap_transactiondate'];
	$transactionType= $_POST['ap_transactiontype'];
	
	//Setting the customer's information from the IPN post variables
	$customerFirstName = $_POST['ap_custfirstname'];
	$customerLastName = $_POST['ap_custlastname'];
	$customerAddress = $_POST['ap_custaddress'];
	$customerCity = $_POST['ap_custcity'];
	$customerState = $_POST['ap_custstate'];
	$customerCountry = $_POST['ap_custcountry'];
	$customerZipCode = $_POST['ap_custzip'];
	$customerEmailAddress = $_POST['ap_custemailaddress'];
	
	//Setting information about the purchased item from the IPN post variables
	$myItemName = $_POST['ap_itemname'];
	$myItemCode = $_POST['ap_itemcode'];
	$myItemDescription = $_POST['ap_description'];
	$myItemQuantity = $_POST['ap_quantity'];
	$myItemAmount = $_POST['ap_amount'];
	
	//Setting extra information about the purchased item from the IPN post variables
	$additionalCharges = $_POST['ap_additionalcharges'];
	$shippingCharges = $_POST['ap_shippingcharges'];
	$taxAmount = $_POST['ap_taxamount'];
	$discountAmount = $_POST['ap_discountamount'];
	 
	//Setting your customs fields received from the IPN post variables
	$myCustomField_1 = $_POST['apc_1'];
	$myCustomField_2 = $_POST['apc_2'];
	$myCustomField_3 = $_POST['apc_3'];
	$myCustomField_4 = $_POST['apc_4'];
	$myCustomField_5 = $_POST['apc_5'];
	$myCustomField_6 = $_POST['apc_6'];

	if ($receivedMerchantEmailAddress != MY_MERCHANT_EMAIL) {
		// The data was not meant for the business profile under this email address.
		// Take appropriate action 
	}
	else {	
		//Check if the security code matches
		if ($receivedSecurityCode != IPN_SECURITY_CODE) {
			// The data is NOT sent by AlertPay.
			// Take appropriate action.
		}
		else {
			if ($transactionStatus == "Sucesso") {
				if ($testModeStatus == "1") {
					// Since Test Mode is ON, no transaction reference number will be returned.
					// Your site is currently being integrated with AlertPay IPN for TESTING PURPOSES
					// ONLY. Don't store any information in your production database and 
					// DO NOT process this transaction as a real order.
					
					mysql_connect("127.0.0.1","root","ascent");
					mysql_select_db("auth");
					
					mysql_query("INSERT INTO paypal_payment_info(userid,paymentstatus,buyer_email,firstname,lastname) VALUES ('".$myCustomField_1."','".$transactionStatus."','".$customerEmailAddress."','".$customerFirstName."','".$customerLastName."')");
					
				}
				else {
					// This REAL transaction is complete and the amount was paid successfully.
					// Process the order here by cross referencing the received data with your database. 														
					// Check that the total amount paid was the expected amount.
					// Check that the amount paid was for the correct service.
					// Check that the currency is correct.
					// ie: if ($totalAmountReceived == 50) ... etc ...
					// After verification, update your database accordingly.
				}			
			}
			else {
					// Transaction was cancelled or an incorrect status was returned.
					// Take appropriate action.
			}
		}
	}
?>