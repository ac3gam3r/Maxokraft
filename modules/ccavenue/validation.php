<?php
/*
Please Do not edit or add any code in this file without permission of bluezeal.in.
@copyright bluezeal.in

Prestashop version 1.6.0.9
CCAvenue MCPG Version 1.1
August 2014

**/
 
	include(dirname(__FILE__).'/../../config/config.inc.php');
	include(dirname(__FILE__).'/../../header.php');
	include(dirname(__FILE__).'/ccavenue.php');
	
	$errors = '';
	$result = false;
	global $cookie;
	$ccavenue = new ccavenue();	
	$errors = array();
	
	$cookie->__set("ccavenue_validate_error_message",'');
	
	$requiredFields = array('OrderId', 'Amount', 'merchant_id', 'order_status');
	foreach ($requiredFields AS $field)
	if (!isset($_POST[$field]))
	$errors[] = 'Missing field '.$field;
	
	$encResponse ='';
	$encResponse=$_POST["encResp"];
	$encryption_key  = trim(Configuration::get('CCAVENUE_ENCRYPTION_KEY'));
	$rcvdString =$ccavenue->decrypt($encResponse,$encryption_key);
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	$response_array		= array();
	
	for($i = 0; $i < count($decryptValues); $i++) 
	{
		$information	= explode('=',$decryptValues[$i]);
		if(count($information)==2)
		{
			$response_array[$information[0]] = urldecode($information[1]);
		}
		  
	}
	$merchant_param1		= '';
	$merchant_param2		= '';
	$merchant_param3		= '';
	$order_status		= '';
	$order_id    		= '';
	$tracking_id		= '';
	$bank_ref_no 		= '';
	$failure_message 	= '';
	$payment_mode 		= '';
	$card_name    		= '';
	$status_code  		= '';
	$status_message 	= '';
	$currency       	= '';
	$amount				= '';
	
	if(isset($response_array['order_id'])) $order_id 				= $response_array['order_id'];
	if(isset($response_array['tracking_id'])) $tracking_id 			= $response_array['tracking_id'];
	if(isset($response_array['bank_ref_no'])) $bank_ref_no 			= $response_array['bank_ref_no'];
	if(isset($response_array['order_status'])) $order_status 		= $response_array['order_status'];
	if(isset($response_array['failure_message'])) $failure_message = $response_array['failure_message'];
	if(isset($response_array['payment_mode'])) $payment_mode 		= $response_array['payment_mode'];
	if(isset($response_array['card_name'])) $card_name 				= $response_array['card_name'];
	if(isset($response_array['status_code'])) $status_code 			= $response_array['status_code'];
	if(isset($response_array['status_message'])) $status_message 	= $response_array['status_message'];
	if(isset($response_array['currency'])) $currency 				= $response_array['currency'];
	if(isset($response_array['amount'])) $amount 					= $response_array['amount']; 
	if(isset($response_array['merchant_param1'])) $merchant_param1 	= $response_array['merchant_param1'];
	if(isset($response_array['merchant_param2'])) $merchant_param2 	= $response_array['merchant_param2'];
	if(isset($response_array['merchant_param3'])) $merchant_param3 	= $response_array['merchant_param3'];

	$id_cart = $merchant_param1;
	if (_PS_VERSION_ >= 1.5)
		Context::getContext()->cart = new Cart((int)$id_cart);
	if($merchant_param3 == '') $merchant_param3 = 'KO';
	
	session_start();	
	$message = '';
	$status  = '';
	if($order_status	== "Success")
	{
		$message = "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
		$payment_status='SUCCESSFUL';
		
	}
	else if($order_status	== "Aborted")
	{
		$message = "<br>CCAvenue MCPG payment order cancelled and the transaction has been Aborted.";
		$payment_status='PENDING';
		
	}
	else if($order_status	== "Failure")
	{
		$message = "<br>CCAvenue MCPG payment order cancelled and the transaction has been Declined.";
		$payment_status='DECLINED';
		
	}
	else
	{
		$message = "<br>Security Error. Illegal access detected";
		$payment_status='ERROR';
	}
	
	switch ($payment_status)
	{		
		case 'SUCCESSFUL':
		
			$ccavenue->validateOrder((int)$merchant_param1, Configuration::get('PS_OS_PAYMENT'), (float)($amount), $ccavenue->displayName, $message, array('tracking_id' => $response_array['tracking_id'], 'payment_status' => $payment_status), NULL, false, $merchant_param3);
			$status='ok';
			break;
		case 'PENDING':	
		
			$ccavenue->validateOrder((int)$merchant_param1, Configuration::get('PS_OS_CANCELED'), (float)$amount, $ccavenue->displayName, $message, array('tracking_id' => $response_array['tracking_id'], 'payment_status' => $payment_status), NULL, false, $merchant_param3);
			break;
			
		default:
			$cart = new Cart((int)$id_cart);
			$_SESSION['cart_currency'] = 'INR';
			$_SESSION['params1']['cart'] = $cart;
			$cookie->__set("ccavenue_validate_error_message",$message);
			break;
	}
	if(	$payment_status=='SUCCESSFUL' or $payment_status=='PENDING' )
	{
		$order = new Order($ccavenue->currentOrder);
		Tools::redirect(__PS_BASE_URI__.'order-confirmation.php?id_cart='.$cart->id.'&id_module='.$ccavenue->id.'&id_order='.$ccavenue->currentOrder.'&key='.$ccavenue->seccode());		
	}
	
	else
	{
		Tools::redirect(__PS_BASE_URI__.'order.php?step=3');	
	}
 
	 
?>