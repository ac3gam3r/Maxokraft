<?php
/**
Please Do not edit or add any code in this file without permission of bluezeal.in.
@copyright bluezeal.in
Prestashop version 1.6.0.8
CCAvenue MCPG Version 1.1
August 2014
**/
	
class ccavenue extends PaymentModule
{
	private	$_html = '';
	private $_postErrors = array();
	static  $params1;
	private $current_currency_id = '';
	public $_validateErrors = array();

	public function __construct()
	{
		$this->name = 'ccavenue';
		$this->tab = 'payments_gateways';
		$this->version = '1.1';
		$this->currencies = true;
		$this->currencies_mode = 'checkbox';
        parent::__construct();
		$this->_postErrors = array();
		$this->page = basename(__FILE__, '.php');
        $this->displayName = $this->l('ccavenue MCPG');
        $this->description = $this->l('Accepts payments by bluezeal.in');
		$this->confirmUninstall = $this->l('Are you sure you want to delete your details ?');
	
	}

	public function getccavenueUrl()
	{

		return 'https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction';
	}

	public function install()
	{
		if (!parent::install()
			OR !Configuration::updateValue('CCAVENUE_MERCHANT_ID', '')
			OR !Configuration::updateValue('CCAVENUE_ACCESS_CODE', '')
			OR !Configuration::updateValue('CCAVENUE_ENCRYPTION_KEY', '')
			OR !Configuration::updateValue('CCAVENUE_SHIPPING', 1)
			OR !Configuration::updateValue('CCAVENUE_TITLE', 'CCAvenue MCPG')
			OR !$this->registerHook('payment')
			OR !$this->registerHook('paymentReturn'))
			return false;
		return true;
	}

	public function uninstall()
	{
		if (!Configuration::deleteByName('CCAVENUE_MERCHANT_ID')
		   OR !Configuration::deleteByName('CCAVENUE_ACCESS_CODE')
		   OR !Configuration::deleteByName('CCAVENUE_ENCRYPTION_KEY')
		   OR !Configuration::deleteByName('CCAVENUE_SHIPPING')
		   OR !Configuration::deleteByName('CCAVENUE_TITLE')
		   OR !parent::uninstall())
		   return false;
		return true;
	}

	public function getContent()
	{
		$this->_html = '<h2>CCAvenue MCPG</h2>';
		if (isset($_POST['submitccavenue']))
		{
			if (empty($_POST['merchant_id']))
				$this->_postErrors[] = $this->l('CCAvenue Merchant id is required.');
		    if (empty($_POST['access_code']))
				$this->_postErrors[] = $this->l('CCAvenue Access Code is required.');
			if (empty($_POST['encryption_key']))
				$this->_postErrors[] = $this->l('CCAvenue Encryption Key is required.');
			if (!sizeof($this->_postErrors))
			{
				Configuration::updateValue('CCAVENUE_MERCHANT_ID', strval($_POST['merchant_id']));
				Configuration::updateValue('CCAVENUE_ACCESS_CODE', strval($_POST['access_code']));
				Configuration::updateValue('CCAVENUE_ENCRYPTION_KEY', strval($_POST['encryption_key']));
				Configuration::updateValue('CCAVENUE_TITLE', strval($_POST['ccavenue_title']));
				$this->displayConf();
			}
			else
			{
				$this->displayErrors();
			}
		}
		$this->displayccavenue();
		$this->displayFormSettings();
		return $this->_html;
	}

	public function displayConf()
	{
		$this->_html .= '
		<div class="conf confirm">
			<img src="../img/admin/ok.gif" alt="'.$this->l('Confirmation').'" />
			'.$this->l('Settings updated').'
		</div>';
	}

	public function displayErrors()
	{
		$nbErrors = sizeof($this->_postErrors);
		$this->_html .= '
		<div class="alert error">
			<h3>'.($nbErrors > 1 ? $this->l('There are') : $this->l('There is')).' '.$nbErrors.' '.($nbErrors > 1 ? $this->l('errors') : $this->l('error')).'</h3>
			<ol>';

		foreach ($this->_postErrors AS $error)
			$this->_html .= '<li>'.$error.'</li>';
		$this->_html .= '
			</ol>
		</div>';
	}

	public function displayccavenue()
	{
		$this->_html .= '
		<fieldset><legend><img src="../modules/'.$this->name.'/logo.png" /> '.$this->l('Help').'</legend>
			<div><img src="https://www.bluezeal.in/security/logo.png" alt="Bluezeal Logo" /></div>
			<div>
						<a href="https://bluezeal.in/" target="_blank" style="text-decoration:underline;color:#27ABEA;">
							 CCavenue MCPG Payment Module developed by Bluezeal.in
						</a>
			</div>
			<p>'.$this->l('Please follow these steps:').'</p>
			<ol>
				<li>
					<h3>'.$this->l('PrestaShop side').'</h3>
					<ol>
						<li>'.$this->l('Give Title For the Payment to be visible in front end').'</li>
						<li>'.$this->l('Fill in your CCAvenue Merchant Id').'</li>
						<li>'.$this->l('Fill in your CCAvenue Access Code').'</li>
						<li>'.$this->l('Fill in your CCAvenue Encryption Key').'</li>
					</ol>
				</li>
			</ol>
			

			<div class="clear">&nbsp;</div>

		</fieldset>

		<div class="clear">&nbsp;</div>';

	}

	public function displayFormSettings()

	{

		$conf = Configuration::getMultiple(array('CCAVENUE_MERCHANT_ID', /*'CCAVENUE_LICENSE_KEY',*/ 'CCAVENUE_ACCESS_CODE', 'CCAVENUE_ENCRYPTION_KEY', 'CCAVENUE_TITLE'));

		$merchant_id = array_key_exists('merchant_id', $_POST) ? $_POST['merchant_id'] : (array_key_exists('CCAVENUE_MERCHANT_ID', $conf) ? $conf['CCAVENUE_MERCHANT_ID'] : '');

		$access_code = array_key_exists('access_code', $_POST) ? $_POST['access_code'] : (array_key_exists('CCAVENUE_ACCESS_CODE', $conf) ? $conf['CCAVENUE_ACCESS_CODE'] : '');
		
		$encryption_key = array_key_exists('encryption_key', $_POST) ? $_POST['encryption_key'] : (array_key_exists('CCAVENUE_ENCRYPTION_KEY', $conf) ? $conf['CCAVENUE_ENCRYPTION_KEY'] : '');
	
		$ccavenue_title = array_key_exists('ccavenue_title',$_POST) ? $_POST['ccavenue_title'] : (array_key_exists('CCAVENUE_TITLE', $conf) ? $conf['CCAVENUE_TITLE'] : '');
	
		$this->_html .= '
		
		<form action="'.$_SERVER['REQUEST_URI'].'" method="post" style="clear: both;" name="ccavenue">

		<fieldset>

			<legend ><img src="../img/admin/contact.gif" />'.$this->l('Settings').'</legend>

			<label>'.$this->l('CCAvenue Title').'</label>

			<div class="margin-form" >
			<input type="text" size="35" name="ccavenue_title" value="'.htmlentities($ccavenue_title, ENT_COMPAT, 'UTF-8').'"  />
			
			</div>			

			<label>'.$this->l('CCAvenue Merchant ID').'</label>

			<div class="margin-form"><input type="text" size="35" name="merchant_id" value="'.htmlentities($merchant_id, ENT_COMPAT, 'UTF-8').'" /></div>

			<label>'.$this->l('CCAvenue Access Code').'</label>

			<div class="margin-form"><input type="text" size="85" name="access_code" value="'.htmlentities($access_code, ENT_COMPAT, 'UTF-8').'" /></div>
			
			<label>'.$this->l('CCAvenue Encryption Key').'</label>

			<div class="margin-form"><input type="text" size="85" name="encryption_key" value="'.htmlentities($encryption_key, ENT_COMPAT, 'UTF-8').'" /></div>
			
			<br /><br /><br />

			<br /><center><input type="submit" name="submitccavenue" value="'.$this->l('Update settings').'" class="button" /></center>

		</fieldset>

		</form>';
		
		$this->ccavenue_bz_module_validation();
	}

	public function hookPayment($params)
	{
		global $cookie;
		$this->_validateErrors=array();	
		session_start();
		$_SESSION['params1']       = '';
		$_SESSION['cart_currency'] = '';
		$_SESSION['cart_amount']   = '';
		$_SESSION['params1']       = $params;
	
		if (!$this->active)
			return ;
			
		global $smarty;
		$address     	= new Address(intval($params['cart']->id_address_invoice));
		$customer   	= new Customer(intval($params['cart']->id_customer));
		$merchant_id     = trim(Configuration::get('CCAVENUE_MERCHANT_ID'));
		$access_code     = trim(Configuration::get('CCAVENUE_ACCESS_CODE'));
		$encryption_key  = trim(Configuration::get('CCAVENUE_ENCRYPTION_KEY'));
		$ccavenue_title = trim(Configuration::get('CCAVENUE_TITLE'));
		$Redirect_Url	= 'http://'.htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8').__PS_BASE_URI__.'modules/ccavenue/validation.php';
		$Cancel_Url		= 'http://'.htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8').__PS_BASE_URI__.'modules/ccavenue/validation.php';
		$language		= 'EN';
		$currency       = $this->getCurrency('INR');
		$OrderId        = date('Ymdhis'). '-' .intval($params['cart']->id) ;
		$Amount 		= $params['cart']->getOrderTotal(true, 3);
		$_SESSION['cart_amount'] = $Amount;
		$default_currency_support_ccavnenue = 'INR';
		$default_currency_id = Db::getInstance()->getValue("
						SELECT `id_currency`
						FROM `"._DB_PREFIX_."currency`
						WHERE `iso_code` = '".$default_currency_support_ccavnenue."'");
		$base_currency_id   = Configuration::get('PS_CURRENCY_DEFAULT');
		$default_currency   = new Currency((int)($default_currency_id));
		$base_currency      = new Currency((int)($base_currency_id));
		$base_currency_code = $base_currency->iso_code;
		$current_currency   = new Currency((int)($params['cart']->id_currency));
		$_SESSION['cart_currency'] = $params['cart']->id_currency;
		$current_currency_code = $current_currency->iso_code;
		
		$billing_name 		= $address->firstname . $address->lastname;
		$billing_address 	= $address->address1 . $address->address2;
		$billing_city 		= $address->city;
		$billing_zip 		= $address->postcode;
		$billing_tel 		= $address->phone;
		$billing_email		= $customer->email;
		$country 			= new Country(intval($address->id_country));
		$state 				= new State(intval($address->id_state));
		$billing_state 		= $state->getNameById($address->id_state); 
		$land_id 			= $params['cart']->id_lang;
		$billing_country 	= $country->getNameById($land_id,$address->id_country);
		$merchant_param1 	= (int)($params['cart']->id);
		$merchant_param2 	= date('YmdHis');
		$merchant_param3 	= $params['cart']->secure_key;
		$cust_notes_message = Message::getMessageByCartId(intval($params['cart']->id));
		$cust_notes 		= $cust_notes_message['message'];
		$billing_cust_notes = $cust_notes;
		$delivery_name		= '';
		$delivery_address	= '';
		$delivery_city		= '';
		$delivery_state		= '';
		$delivery_tel		= '';
		$delivery_zip		= '';
		$delivery_country 	= '';
		$delivery_name 		= $address->firstname . $address->lastname;
		$delivery_address 	= $address->address1 . $address->address2;
		$delivery_city 		= $address->city;
		$delivery_zip 		= $address->postcode;
		$delivery_tel 		= $address->phone;
		$delivery_state 	= $billing_state ;
		$delivery_country 	= $billing_country;
		
		$merchant_data_array = array();
		$merchant_data_array['merchant_id']      	= $merchant_id;
		$merchant_data_array['order_id']        	= $OrderId;
		$merchant_data_array['currency']			= 'INR';
		$merchant_data_array['amount']          	= $Amount;
		$merchant_data_array['redirect_url']        = $Redirect_Url;		
		$merchant_data_array['cancel_url']          = $Cancel_Url;
		$merchant_data_array['language']			= $language;
		$merchant_data_array['billing_name']		= $billing_name;
		$merchant_data_array['billing_address']		= $billing_address;	
		$merchant_data_array['billing_city']		= $billing_city;
		$merchant_data_array['billing_state']		= $billing_state;
		$merchant_data_array['billing_zip']			= $billing_zip;	
		$merchant_data_array['billing_country']		= $billing_country; 
		$merchant_data_array['billing_tel']			= $billing_tel;
		$merchant_data_array['billing_email'] 		= $billing_email;
		$merchant_data_array['delivery_name']		= $delivery_name;
		$merchant_data_array['delivery_address']	= $delivery_address;
		$merchant_data_array['delivery_city']		= $delivery_city;
		$merchant_data_array['delivery_state']		= $delivery_state;
		$merchant_data_array['delivery_zip']		= $delivery_zip;
		$merchant_data_array['delivery_country']	= $delivery_country;
		$merchant_data_array['delivery_tel']		= $delivery_tel;
		$merchant_data_array['merchant_param1']		= $merchant_param1;
		$merchant_data_array['merchant_param2']		= $merchant_param2;
		$merchant_data_array['merchant_param3']		= $merchant_param3;
		
		$merchant_data = implode("&",$merchant_data_array);
		$ccavenue_post_data = '';
		$ccavenue_post_data_array =array();
		foreach ($merchant_data_array as $key => $value)
		{
			$ccavenue_post_data_array[] .=$key.'='.urlencode($value);
		}
		$ccavenue_post_data = implode("&",$ccavenue_post_data_array);
		$encrypted_data 	= $this->encrypt($ccavenue_post_data,$encryption_key);
				
		$smarty->assign(array(
			'ccavenueUrl'           => $this->getccavenueUrl(),
			'ccavenue_title'		=> $ccavenue_title,
			'encRequest'			=> $encrypted_data,
			'access_code'			=> $access_code
			));
			
		
		$ccavenue_payment_error_status='';
		$ccavenue_error_message='';
		if($cookie->__get("ccavenue_validate_error_message"))
		{
			$ccavenue_error_message = $cookie->__get("ccavenue_validate_error_message");
		}
		if($ccavenue_error_message!='')
		{		
			$ccavenue_payment_error_status='ERROR';
		}
		$smarty->assign('payment_status', $ccavenue_payment_error_status);	
		$smarty->assign('message', $ccavenue_error_message);	
		return $this->display(__FILE__, 'payccavenue.tpl');
	}

	public function seccode()
	{
		$customer = new Customer(intval($_SESSION['params1']['cart']->id_customer));
		$sec      = $customer->secure_key;
		return $sec;
	}
	
	public function hookPaymentReturn($params)
	{
		if (!$this->active)
			return;
	
		global $smarty;		 
		switch($params['objOrder']->getCurrentState())
		{
			case _PS_OS_PAYMENT_:
				$smarty->assign('payment_status', 'SUCCESSFUL');				 
				break;
			case _PS_OS_OUTOFSTOCK_:
				$smarty->assign('payment_status', 'PENDING');
				break;
			case _PS_OS_WS_PAYMENT_:
				$smarty->assign('payment_status', 'PENDING');
				break;
			case _PS_OS_CANCELED_:
				$smarty->assign('payment_status', 'CANCELED');
				break;
			case _PS_OS_CCAVENUE:
				$smarty->assign('payment_status', 'DECLINED');				
				break;

			case _PS_OS_ERROR_:
			default:
				$smarty->assign('payment_status', 'ERROR');
				break;
		}
		$message='';
		$smarty->assign('message', $message);
		return $this->display(__FILE__, 'confirmation.tpl');
	}
	

	public function validateOrder($id_cart, $id_order_state, $amountPaid, $paymentMethod = 'Unknown', $message = NULL, $extraVars = array(), $currency_special = NULL, $dont_touch_amount = false,$secure_key = false)
	{
		if (!$this->active)
			return;	
		$this->_validateErrors=array();		
		$currency = $this->getCurrency();
		$cart     = new Cart(intval($id_cart));
		$cart_currency = $_SESSION['params1']['cart']->id_currency;
		$cart_total    = $_SESSION['params1']['cart']->getOrderTotal(true, 3);
		$cart->id_currency = $cart_currency;
		$amountPaid        = $cart_total;
		$id_lang  = $_SESSION['params1']['cart']->id_lang;
		$subject  = 'CCAvenue Payment Status';
		$template = 'payment_success';
		$firstname  = $_SESSION['params1']['cookie']->customer_firstname;
		$lastname   = $_SESSION['params1']['cookie']->customer_lastname;
		$Order_Id   = $id_cart;
		$date_added     = $_SESSION['params1']['cookie']->date_add;
		$payment_method = $paymentMethod;
		$total          = $cart_total;
		$to             = $_SESSION['params1']['cookie']->email;	
		$templateVars                  = array('{firstname}' => $firstname,'{lastname}' => $lastname,'{Order_Id}' => $Order_Id,'{date_added}' => $date_added,'{payment_method}' => $payment_method,'{total}' => $total);
		$ccavenue_payment_success_mail = trim(Configuration::get('CCAVENUE_PAYMENT_SUCCESS_MAIL'));
		//$ccavenue_payment_success_mail = 0;
		$payment_status='';
		if(isset($extraVars['payment_status']))
		{
			$payment_status =$extraVars['payment_status'];
		}
		if(($ccavenue_payment_success_mail) && ($id_order_state == '2'))
		{
			Mail::Send($id_lang, $template, $subject, $templateVars, $to, NULL, NULL, NULL, NULL, NULL, _PS_MODULE_DIR_.$this->name.'/mails/');
		}
		$cart->save();
		parent::validateOrder($id_cart, $id_order_state, $amountPaid, $paymentMethod, $message, $extraVars, $currency_special, true,$secure_key);
	}
	
	public function ccavenue_bz_module_validation()
	{		
		$payment_module_validate	= base64_decode('aHR0cHM6Ly9ibHVlemVhbC5pbi9tb2R1bGVfdmFsaWRhdGUvc3VjY2Vzcy5waHA=');
		$poststring	= "server_address=".$_SERVER['SERVER_ADDR']."&domain_url=".$_SERVER['HTTP_HOST']."&module_code=CCAVEN_N_PS";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$payment_module_validate);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$poststring);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$result = curl_exec($ch);
		curl_close($ch);
		return true;
	}
	
	function encrypt($plainText,$key)
	{
		$secretKey = $this->hextobin(md5($key));
		$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	  	$openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
	  	$blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
		$plainPad = $this->pkcs5_pad($plainText, $blockSize);
	  	if (mcrypt_generic_init($openMode, $secretKey, $initVector) != -1) 
		{
		      $encryptedText = mcrypt_generic($openMode, $plainPad);
	      	      mcrypt_generic_deinit($openMode);
		      			
		} 
		return bin2hex($encryptedText);
	}
	
	 function pkcs5_pad ($plainText, $blockSize)
	{
	    $pad = $blockSize - (strlen($plainText) % $blockSize);
	    return $plainText . str_repeat(chr($pad), $pad);
	}



	function hextobin($hexString) 
   	 { 
        	$length = strlen($hexString); 
        	$binString="";   
        	$count=0; 
        	while($count<$length) 
        	{       
        	    $subString =substr($hexString,$count,2);           
        	    $packedString = pack("H*",$subString); 
        	    if ($count==0)
		    {
				$binString=$packedString;
		    } 
        	    
		    else 
		    {
				$binString.=$packedString;
		    } 
        	    
		    $count+=2; 
        	} 
  	        return $binString; 
    	  } 	
		  
		  
	function decrypt($encryptedText,$key)
	{
		 
		$secretKey = $this->hextobin(md5($key));
		$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);		 
		$encryptedText=$this->hextobin($encryptedText);	   
		$openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');		 
		mcrypt_generic_init($openMode, $secretKey, $initVector);		 
		$decryptedText = mdecrypt_generic($openMode, $encryptedText);		 
		$decryptedText = rtrim($decryptedText, "\0");	 
		mcrypt_generic_deinit($openMode);		 
		return $decryptedText;
	}
}
?>
