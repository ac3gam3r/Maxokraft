<?php
/**
 * This file is part of a NewQuest Project
 *
 * (c) NewQuest <contact@newquest.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    NewQuest
 * @copyright NewQuest
 * @license   NewQuest
 */

if (!defined('_PS_VERSION_'))
	exit;

require_once _PS_MODULE_DIR_.'shiptomyid/classes/Toolbox.php';
require_once _PS_MODULE_DIR_.'shiptomyid/classes/ShiptomyidLog.php';
require_once _PS_MODULE_DIR_.'shiptomyid/classes/ShiptomyidOrder.php';
require_once _PS_MODULE_DIR_.'shiptomyid/classes/ShiptomyidCart.php';
require_once _PS_MODULE_DIR_.'shiptomyid/classes/ShiptoAPI.php';
class Shiptomyid extends Module
{
	private $errors = array();
	private $html = '';
	private $on_process = false;

	public $api;

	public static $os_waiting;
	public static $os_ready;
	public static $os_error;
	public static $os_cancel;
	public static $os_ps_canceled;
	public static $os_ps_delivered;

	public function __construct()
	{
		$this->name = 'shiptomyid';
		$this->tab = 'smart_shopping';
		$this->author = 'NewQuest';
		$this->version = '1.0.1';
		$this->module_key = '473d95eea00946df7f84cbb445f94240';

		if (class_exists('Tools') && method_exists('Tools', 'version_compare') && Tools::version_compare(_PS_VERSION_, '1.6', '>=') === true) // For PS_1.6
			$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Ship2MyId');
		$this->description = $this->l('Send real gifts and packages to an email, 
		mobile phone or social account, Increase your online transactions, Increasing your customer base.');

		// Configuration vars //
		self::$os_waiting = Configuration::get('SHIPTOMYID_OS_WAITING');
		self::$os_ready = Configuration::get('SHIPTOMYID_OS_READY');
		self::$os_error = Configuration::get('SHIPTOMYID_OS_ERROR');
		self::$os_cancel = Configuration::get('SHIPTOMYID_CANCEL_ORDER_STATE');

		self::$os_ps_canceled = Configuration::get('PS_OS_CANCELED');
		self::$os_ps_delivered = Configuration::get('PS_OS_DELIVERED');

		// Instanciate API //
		$this->api = new ShiptoAPI();

	}

	/**
	 * Installation du module.
	 */
	public function install()
	{
		if (!parent::install() || !$this->registerHook('displayHeader') || !$this->registerHook('actionValidateOrder')
		|| !$this->registerHook('actionObjectOrderHistoryAddAfter') || !$this->registerHook('actionObjectOrderUpdateAfter')
		|| !$this->registerHook('displayAdminOrder') || !$this->installSQL() || !$this->installExternalOrderState())
			return false;

		Configuration::updateValue('SHIPTOMYID_CRON_TOKEN', Tools::passwdGen(16));
		Configuration::updateValue('SHIPTOMYID_ENABLE', 0);
		Configuration::updateValue('SHIPTOMYID_BASE64_MODE', 0);
		Configuration::updateValue('SHIPTOMYID_USERNAME', '');
		Configuration::updateValue('SHIPTOMYID_PASSWORD', '');
		Configuration::updateValue('SHIPTOMYID_WEBSERVICE_URL', Configuration::get('PS_SSL_ENABLED')
		?'https://hotfix-app.mapmyid.com/ship2myid/rest/':'http://hotfix-app.mapmyid.com/ship2myid/rest/');
		Configuration::updateValue('SHIPTOMYID_TERMS_URL', 'http://www.ship2myid.com/terms-of-use');
		Configuration::updateValue('SHIPTOMYID_PRIVACY_URL', 'http://www.ship2myid.com/privacy');
		Configuration::updateValue('SHIPTOMYID_VIDEO_LINK', 'http://www.youtube.com/watch?v=_4yvWDuyCis');
		Configuration::updateValue('SHIPTOMYID_DEFAULT_ADDR_ADDRESS', 'The shipping address is protected by Ship2MyID.');
		Configuration::updateValue('SHIPTOMYID_DEFAULT_ADDR_ADDRESS2', 'X');
		Configuration::updateValue('SHIPTOMYID_DEFAULT_ADDR_CITY', 'XX');
		Configuration::updateValue('SHIPTOMYID_DEFAULT_ADDR_POSTCODE', 'XXX');
		Configuration::updateValue('SHIPTOMYID_DEFAULT_ADDR_PHONE', 'XXXX');
		Configuration::updateValue('SHIPTOMYID_DEFAULT_ADDR_ALIAS', 'Ship2MyId');
		Configuration::updateValue('SHIPTOMYID_DEFAULT_ADDR_COUNTRY', Configuration::get('PS_COUNTRY_DEFAULT'));
		Configuration::updateValue('SHIPTOMYID_DEFAULT_ADDR_STATE', 0);
		Configuration::updateValue('SHIPTOMYID_POPUP_URL', Configuration::get('PS_SSL_ENABLED')
		?'https://hotfix-app.mapmyid.com/ship2myid/shopping_cart_popup/index.jsp?plateform=prestashop'
		:'http://hotfix-app.mapmyid.com/ship2myid/shopping_cart_popup/index.jsp?plateform=prestashop');
		Configuration::updateValue('SHIPTOMYID_POPUP_WIDTH', '634');
		Configuration::updateValue('SHIPTOMYID_POPUP_HEIGHT', '774');
		Configuration::updateValue('SHIPTOMYID_CANCEL_ORDER_STATE', Configuration::get('PS_OS_CANCELED'));
		return true;
	}

	private function installSQL()
	{
		$sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'shiptomyid_cart` (
		  `id_shipto_cart` int(11) NOT NULL AUTO_INCREMENT,
		  `id_cart` int(11) NOT NULL,
		  `receiver_email` varchar(128) DEFAULT NULL,
		  `receiver_lastname` varchar(128) DEFAULT NULL,
		  `receiver_firstname` varchar(128) DEFAULT NULL,
		  `receiver_postcode` varchar(128) DEFAULT NULL,
		  `receiver_city` varchar(128) DEFAULT NULL,
		  `receiver_id_country` int(11) DEFAULT NULL,
		  `receiver_id_state` int(11) DEFAULT NULL,
		  `receiver_phone` varchar(32) DEFAULT NULL,
		  `receiver_type` varchar(32) DEFAULT NULL,
		  `receiver_linkedin_id` varchar(128) DEFAULT NULL,
		  `receiver_facebook_id` varchar(128) DEFAULT NULL,
		  PRIMARY KEY (`id_shipto_cart`)
		) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';
		$table_1 = Db::getInstance()->Execute($sql);

		$sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'shiptomyid_log` (
		  `id_log` int(11) NOT NULL AUTO_INCREMENT,
		  `type` tinyint(1) NOT NULL,
		  `message` varchar(255) DEFAULT NULL,
		  `date_add` datetime DEFAULT NULL,
		  PRIMARY KEY (`id_log`)
		) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';
		$table_2 = Db::getInstance()->Execute($sql);

		$sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'shiptomyid_order` (
		  `id_shipto_order` int(11) NOT NULL AUTO_INCREMENT,
		  `id_order` int(11) NOT NULL,
		  `id_shiptomyid` int(11) NOT NULL,
		  `lastname` varchar(128) DEFAULT NULL,
		  `firstname` varchar(128) DEFAULT NULL,
		  `address1` varchar(128) DEFAULT NULL,
		  `address2` varchar(128) DEFAULT NULL,
		  `postcode` varchar(10) DEFAULT NULL,
		  `city` varchar(128) DEFAULT NULL,
		  `id_country` int(11) DEFAULT NULL,
		  `id_state` int(11) DEFAULT NULL,
		  `phone` varchar(32) DEFAULT NULL,
		  `state_send` tinyint(1) NOT NULL DEFAULT "0",
		  `state_address` tinyint(1) NOT NULL DEFAULT "0",
		  `date_add` datetime DEFAULT NULL,
		  `date_upd` datetime DEFAULT NULL,
		  PRIMARY KEY (`id_shipto_order`)
		) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';
		$table_3 = Db::getInstance()->Execute($sql);

		if (!$table_1 || !$table_2 || !$table_3)
			return false;

		return true;
	}

	/**
	 * Install specific order state for shiptomyid order.
	 * @return bool
	 */
	private function installExternalOrderState()
	{
		$languages = Language::getLanguages();

		$os_add_object = new OrderState();
		foreach ($languages as $lang)
			$os_add_object->name[$lang['id_lang']] = 'Waiting address';
		$os_add_object->delivery = 0;
		$os_add_object->invoice = 1;
		$os_add_object->shipped = 0;
		$os_add_object->paid = 0;
		$os_add_object->logable = 1;
		$os_add_object->color = '#e0ff52';
		$os_add_object->add();
		Configuration::updateValue('SHIPTOMYID_OS_WAITING', (int)$os_add_object->id);

		$os_add_object = new OrderState();
		foreach ($languages as $lang)
			$os_add_object->name[$lang['id_lang']] = 'Ready to ship';
		$os_add_object->delivery = 0;
		$os_add_object->invoice = 1;
		$os_add_object->shipped = 0;
		$os_add_object->paid = 0;
		$os_add_object->logable = 1;
		$os_add_object->color = '#9aff3e';
		$os_add_object->add();
		Configuration::updateValue('SHIPTOMYID_OS_READY', (int)$os_add_object->id);

		$os_add_object = new OrderState();
		foreach ($languages as $lang)
			$os_add_object->name[$lang['id_lang']] = 'Invalid Ship2MyId Response';
		$os_add_object->delivery = 0;
		$os_add_object->invoice = 1;
		$os_add_object->shipped = 0;
		$os_add_object->paid = 0;
		$os_add_object->logable = 0;
		$os_add_object->color = '#d1003c';
		$os_add_object->add();
		Configuration::updateValue('SHIPTOMYID_OS_ERROR', (int)$os_add_object->id);

		return true;
	}

	public function isAvailable()
	{
		if (!$this->active)
			return false;

		if (!Configuration::get('SHIPTOMYID_ENABLE') || !Configuration::get('SHIPTOMYID_POPUP_URL')
		|| !Configuration::get('SHIPTOMYID_USERNAME') || !Configuration::get('SHIPTOMYID_PASSWORD'))
			return false;

		if (!$this->checkCurl())
			return false;

		return true;
	}

	private function checkCurl()
	{
		if (!function_exists('curl_exec'))
			return false;

		if (!in_array ('curl', get_loaded_extensions()))
			return false;

		return true;
	}

	public function hookDisplayHeader()
	{
		if (!$this->isAvailable())
			return;

		if (empty($this->context->controller->php_self) || $this->context->controller->php_self != 'order')
			return;

		$current_step = (int)Tools::getValue('step', 0);

		// Clean des anciennes adresses Shiptomyid du panier en cours //
		if (in_array($current_step, array(0, 1)) && !Tools::getIsset('ajax'))
		{
			$ids_address = Db::getInstance()->ExecuteS('SELECT a.id_address FROM '._DB_PREFIX_.'address a
				WHERE a.id_address NOT IN 
				(SELECT DISTINCT o.id_address_delivery FROM '._DB_PREFIX_.'orders o WHERE id_customer = '.(int)$this->context->customer->id.')
				AND a.id_customer = '.(int)$this->context->customer->id.' AND a.alias LIKE "SHIP2MYID%"
			');

			if ($ids_address)
				foreach ($ids_address as $id_address)
					Db::getInstance()->execute('DELETE FROM '._DB_PREFIX_.'address WHERE id_address = '.(int)$id_address['id_address']);

			$this->context->cart->id_address_delivery = 0;
			$this->context->cart->update();
		}

		if ($current_step != 1)
			return;

		$youtube_link = Configuration::get('SHIPTOMYID_VIDEO_LINK');
		$match = array();
		if (preg_match('/(.+www\.youtube\.com)\/watch\?v=([_0-9a-zA-Z]+)/', $youtube_link, $match))
			$youtube_link = $match[1].'/embed/'.$match[2];

		if (class_exists('Tools') && method_exists('Tools', 'version_compare') && Tools::version_compare(_PS_VERSION_, '1.6', '>=') === true)
			$button_class = 'button button-small btn btn-default';
		else
			$button_class = 'button_large';

		$key = md5($this->context->cart->id.'_'.$this->context->cart->secure_key);

		// Chargement de la popup Shiptomyid //
		$this->context->controller->addjqueryPlugin('fancybox');
		$this->context->smarty->assign(array(
			'popup_url' => Configuration::get('SHIPTOMYID_POPUP_URL'),
			'video_url' => $youtube_link,
			'button_class' => $button_class,
			'popup_width' => Configuration::get('SHIPTOMYID_POPUP_WIDTH'),
			'popup_height' => Configuration::get('SHIPTOMYID_POPUP_HEIGHT'),
			'callback_url' => Tools::getShopDomain(true).__PS_BASE_URI__.'modules/'.$this->name.'/postdata.php?data='.$this->context->cart->id.'&key='.$key
		));

		return $this->display(__FILE__, 'load-popup.tpl');
	}

	/**
	 * Action lors de la validation d'une nouvelle commande client.
	 * @param $params
	 */
	public function hookActionValidateOrder($params)
	{
		if (!$this->isAvailable())
			return;

		$order = $params['order'];

		if (!$this->hasShiptomyidOption($order->id))
			return;

		ShiptomyidOrder::disableUsesAddress($order);
	}


	/**
	 * Action lors du changement du statut d'une commande.
	 * @param $params
	 */
	public function hookActionObjectOrderHistoryAddAfter($params)
	{
		if (!$this->isAvailable())
			return;

		if ($this->on_process)
			return;

		$new_order_history = $params['object'];
		$id_order = (int)$new_order_history->id_order;

		if (!$this->hasShiptomyidOption($id_order))
			return;

		$new_order_state = new OrderState($new_order_history->id_order_state);
		if (!Validate::isLoadedObject($new_order_state))
			ShiptomyidLog::addLog('invalid order_state object', $id_order);

		if (!$this->on_process)
		{
			$shipto_order = ShiptomyidOrder::getByIdOrder($id_order);

			if (!$shipto_order || (int)$shipto_order->state_send == 0)
			{
				if ($new_order_state->logable)
				{
					$order = new Order($id_order);

					if (Validate::isLoadedObject($order))
					{
						$this->sendOrderToAPI($order);

						$this->api->closeSession();
					}
					else
						ShiptomyidLog::addLog('invalid order object', $id_order);
				}
			}
			else
			{
				// Check canceled and complete state on order and send it to shiptomyid
				if ($new_order_state->id == self::$os_ps_canceled)
				{
					$this->api->cancelOrder($shipto_order->id_shiptomyid);

					ShiptomyidOrder::addMessageToOrder($shipto_order->id_order, $this->l('Order Canceled send to ship2myid.'));

					$this->api->closeSession();
				}
				elseif ($new_order_state->id == self::$os_ps_delivered)
				{

					$this->api->completeOrder($shipto_order->id_shiptomyid);

					ShiptomyidOrder::addMessageToOrder($shipto_order->id_order, $this->l('Order Complete send to ship2myid.'));

					$this->api->closeSession();
				}
			}
		}
	}

	public function hookActionObjectOrderUpdateAfter($params)
	{
		$order = $params['object'];

		if (!$this->hasShiptomyidOption($order->id))
			return;

		$last_order_state = (int)Db::getInstance()->getValue('SELECT id_order_state FROM '._DB_PREFIX_.'order_history
			WHERE id_order = '.(int)$order->id.' ORDER BY id_order_history DESC');

		if ($last_order_state != (int)$order->current_state)
		{
			$order->current_state = $last_order_state;
			$order->update();
		}

		return true;
	}

	public function hookDisplayAdminOrder($params)
	{
		if (!$this->hasShiptomyidOption($params['id_order']))
			return;

		$shipto_order = ShiptomyidOrder::getByIdOrder($params['id_order']);
		if (!Validate::isLoadedObject($shipto_order))
			return false;

		$order = new Order($shipto_order->id_order);
		if ($order->current_state == self::$os_ps_canceled || $order->current_state == self::$os_cancel)
			return false;

		$shipto_order->country_name = Country::getNameById($this->context->language->id, $shipto_order->id_country);
		$shipto_order->state_name = State::getNameById($shipto_order->id_state);

		$this->context->smarty->assign(array(
			'shipto_order' => $shipto_order
		));

		return $this->display($this->_path, 'admin-order.tpl');
	}

	/**
	 * Send order to shiptomyid.
	 */
	public function sendOrderToAPI($order)
	{
		$this->on_process = true;

		$delivery_address = new Address((int)$order->id_address_delivery);
		$invoice_address = new Address((int)$order->id_address_invoice);
		$customer = new Customer((int)$order->id_customer);
		$shipto_cart = ShiptomyidCart::getByIdCart((int)$order->id_cart);

		if (!Validate::isLoadedObject($delivery_address) || !Validate::isLoadedObject($invoice_address)
			|| !Validate::isLoadedObject($customer) || !Validate::isLoadedObject($shipto_cart))
		{

			ShiptomyidLog::addLog('invalid order object or address object in order', $order->id);
			return false;
		}

		$gift_msg = !empty($order->gift_message)?$order->gift_message:'Brought to you by Ship2MyID';

		$data_to_send = array(
		//--------------------
		// General data
		'vendor_order_id' => $order->id,
		//--------------------
		// Sender data
		'sender_email_address' => $customer->email,
		'sender_first_name' => $invoice_address->firstname,
		'sender_last_name' => $invoice_address->lastname,
		'sender_message' => $gift_msg,
		//  Receiver data //
		'receiver_email_address' => $shipto_cart->receiver_email,
		'receiver_first_name' => $shipto_cart->receiver_firstname,
		'receiver_last_name' => $shipto_cart->receiver_lastname,
		'receiver_telephone' => $shipto_cart->receiver_phone,
		'receiver_type' => $shipto_cart->receiver_type,
		'receiver_linkedin_id' => '',
		'receiver_facebook_id' => '',
		//------ Marketplace Order Data
		'marketplace_order_data' => $this->getOrderData($order)
		);

		switch ($shipto_cart->receiver_type)
		{

			case 'facebook':
				$data_to_send['receiver_facebook_id'] = $shipto_cart->receiver_facebook_id;
				break;
			case 'linkedin':
				$data_to_send['receiver_linkedin_id'] = $shipto_cart->receiver_linkedin_id;
				break;
		}

		$result = $this->api->sendOrder(array('ExternalOrder' => $data_to_send));

		if (isset($result['ExternalOrder']))
		{
			$result_data = $result['ExternalOrder'];
			$new_shipto_order = new ShiptomyidOrder();
			$new_shipto_order->id_order = $order->id;
			$new_shipto_order->id_shiptomyid = $result_data['id'];
			$new_shipto_order->state_send = 1;
			if ($new_shipto_order->add())
			{
				ShiptomyidOrder::changeOrderStatus($order->id, self::$os_waiting);

				ShiptomyidOrder::addMessageToOrder($order->id, $this->l('Add order in Ship2MyId : #'.$new_shipto_order->id_shiptomyid));

				$this->checkOrderStatus($new_shipto_order->id_order, $result);

				return true;
			}

			ShiptomyidLog::addLog('Error in save shiptotmyid_order object.', $order->id, $new_shipto_order->id_shiptomyid);
		}
		else
		{
			ShiptomyidOrder::changeOrderStatus($order->id, self::$os_error);

			ShiptomyidOrder::addMessageToOrder($order->id, ShiptoAPI::getErrorMessage($result));
		}

		return false;
	}

	public function getOrderData($order)
	{
		$xml = new DOMDocument('1.0', 'utf-8');
		$xml_root = $xml->createElement('OrderDetails');
		$xml->appendChild($xml_root);

		$cart = Cart::getCartByOrderId((int)$order->id);
		$products = $cart->getProducts();
		if (count($products))
		{
			foreach ($products as $product)
			{
				$item_id = $product['id_product'];
				$order_id = (int)$order->id;
				//$product_id = $product['id_product'];
				$product_sku = $product['name'].'_'.$product['id_product'];
				$product_name = $product['name'];
				$qty = $product['cart_quantity'];
				$price = $product['price'];
				$subtotal = '0';
				$taxtotal = '0';
				$grandtotal = '0';

				$xml_item = $xml->createElement('Item');
				$xml_item->appendChild($xml->createTextNode($product_name));
				$dom_attribute = $xml->createAttribute('MerchentOrderRecordRef');
				$dom_attribute->value = $order_id;
				$xml_item->appendChild($dom_attribute);
				$dom_attribute = $xml->createAttribute('MerchentOrderRecordLineRef');
				$dom_attribute->value = $item_id;
				$xml_item->appendChild($dom_attribute);
				$dom_attribute = $xml->createAttribute('Sku');
				$dom_attribute->value = $product_sku;
				$xml_item->appendChild($dom_attribute);
				$dom_attribute = $xml->createAttribute('Qty');
				$dom_attribute->value = $qty;
				$xml_item->appendChild($dom_attribute);
				$dom_attribute = $xml->createAttribute('Price');
				$dom_attribute->value = $price;
				$xml_item->appendChild($dom_attribute);
				$dom_attribute = $xml->createAttribute('LineSubTotal');
				$dom_attribute->value = $subtotal;
				$xml_item->appendChild($dom_attribute);
				$dom_attribute = $xml->createAttribute('LineTaxesTotal');
				$dom_attribute->value = $taxtotal;
				$xml_item->appendChild($dom_attribute);
				$dom_attribute = $xml->createAttribute('LineTotal');
				$dom_attribute->value = $grandtotal;
				$xml_item->appendChild($dom_attribute);
				$xml_root->appendChild($xml_item);
			}
		}

		$xml_order_details = $xml->saveXML();
		return $xml_order_details;
	}

	public function finalizeSendErrorOrder($id_order, $id_shipto_order)
	{
		$check = ShiptomyidOrder::getByIdOrder($id_order);
		if (Validate::isLoadedObject($check))
			return true;

		$new_shipto_order = new ShiptomyidOrder();
		$new_shipto_order->id_order = $id_order;
		$new_shipto_order->id_shiptomyid = $id_shipto_order;
		$new_shipto_order->state_send = 1;
		if ($new_shipto_order->add())
		{
			ShiptomyidOrder::changeOrderStatus($id_order, self::$os_waiting);

			ShiptomyidOrder::addMessageToOrder($id_order, $this->l('Add order in Ship2MyId : #'.$new_shipto_order->id_shiptomyid));
		}

		return true;
	}


	/**
	 * Check Shiptotmyid status for an specific order.
	 */
	public function checkOrderStatus($id_order, $result = null)
	{
		$shipto_order = ShiptomyidOrder::getByIdOrder($id_order);
		if (!Validate::isLoadedObject($shipto_order))
		{
			ShiptomyidLog::addLog('invalid shiptomyid_order object', $id_order);
			return false;
		}

		if ($result === null)
			$result = $this->api->getOrder($shipto_order->id_shiptomyid);

		if (isset($result['ExternalOrder']))
		{
			if ($result['ExternalOrder']['is_order_accepted'] == 'true')
			{
				$result_data = $result['ExternalOrder'];

				$id_country = (int)Country::getByIso($result_data['countryCode']);
				$id_state = (int)State::getIdByIso($result_data['stateCode']);
				if (!$id_state)
					$id_state = (int)StateCore::getIdByName($result_data['stateName']);

				$data = array(
					'firstname' => $result_data['receiver_first_name'],
					'lastname' => $result_data['receiver_last_name'],
					'address1' => $result_data['address_1'],
					'postcode' => $result_data['zipcode'],
					'city' => $result_data['city'],
					'id_country' => $id_country,
					'id_state' => $id_state,
					'phone' => $result_data['phoneNumber'],
				);
				$shipto_order->setDeliveryAddress($data);

				$order_state = new OrderState(self::$os_ready);
				if (Validate::isLoadedObject($order_state))
				{
					ShiptomyidOrder::changeOrderStatus($id_order, self::$os_ready);

					ShiptomyidOrder::addMessageToOrder($id_order, $this->l('Order is ready to delivery.').'<br/><pre>'.print_r($data, true).'</pre>');
				}
			}
			elseif ($result['ExternalOrder']['is_order_rejected'] == 'true')
			{
				$result_data = $result['ExternalOrder'];

				$order_state = new OrderState(self::$os_cancel);
				if (Validate::isLoadedObject($order_state))
				{
					ShiptomyidOrder::changeOrderStatus($id_order, self::$os_cancel);

					ShiptomyidOrder::addMessageToOrder($id_order, $this->l('Order is rejected : ').$result_data['receiver_rejected_note']);
				}
			}
		}
		elseif (isset($result['Error']))
		{
			ShiptomyidLog::addLog('Check order status error in cron task : '.$result['Error']['message'].' ['.$result['Error']['status'].']', $id_order);
			return false;
		}

		return true;
	}

	public function hasShiptomyidOption($id_order)
	{
		$result = Db::getInstance()->ExecuteS('SELECT a.id_address FROM '._DB_PREFIX_.'orders o
			JOIN '._DB_PREFIX_.'address a ON a.id_address = o.id_address_delivery
			WHERE o.id_order = '.(int)$id_order.' AND a.alias LIKE "SHIP2MYID%"'
		);

		if ($result)
			return true;

		return false;
	}

	public function getContent()
	{
		$this->html = '';

		if (Tools::isSubmit('secureKey'))
		{
			if (!count($this->errors))
			{
				$password = Tools::getValue('SHIPTOMYID_PASSWORD', '');
				$username = Tools::getValue('SHIPTOMYID_USERNAME', '');

				if (!empty($username))
					Configuration::updateValue('SHIPTOMYID_USERNAME', $username);
				if (!empty($password))
					Configuration::updateValue('SHIPTOMYID_PASSWORD', $password);

				Configuration::updateValue('SHIPTOMYID_ENABLE', Tools::getValue('SHIPTOMYID_ENABLE'));

				Configuration::updateValue('SHIPTOMYID_WEBSERVICE_URL', Tools::getValue('SHIPTOMYID_WEBSERVICE_URL'));
				Configuration::updateValue('SHIPTOMYID_TERMS_URL', Tools::getValue('SHIPTOMYID_TERMS_URL'));
				Configuration::updateValue('SHIPTOMYID_PRIVACY_URL', Tools::getValue('SHIPTOMYID_PRIVACY_URL'));
				Configuration::updateValue('SHIPTOMYID_VIDEO_LINK', Tools::getValue('SHIPTOMYID_VIDEO_LINK'));

				Configuration::updateValue('SHIPTOMYID_DEFAULT_ADDR_ADDRESS', Tools::getValue('SHIPTOMYID_DEFAULT_ADDR_ADDRESS'));
				Configuration::updateValue('SHIPTOMYID_DEFAULT_ADDR_ADDRESS2', Tools::getValue('SHIPTOMYID_DEFAULT_ADDR_ADDRESS2'));
				Configuration::updateValue('SHIPTOMYID_DEFAULT_ADDR_CITY', Tools::getValue('SHIPTOMYID_DEFAULT_ADDR_CITY'));
				Configuration::updateValue('SHIPTOMYID_DEFAULT_ADDR_POSTCODE', Tools::getValue('SHIPTOMYID_DEFAULT_ADDR_POSTCODE'));
				Configuration::updateValue('SHIPTOMYID_DEFAULT_ADDR_PHONE', Tools::getValue('SHIPTOMYID_DEFAULT_ADDR_PHONE'));
				Configuration::updateValue('SHIPTOMYID_DEFAULT_ADDR_ALIAS', Tools::getValue('SHIPTOMYID_DEFAULT_ADDR_ALIAS'));
				Configuration::updateValue('SHIPTOMYID_DEFAULT_ADDR_STATE', Tools::getValue('SHIPTOMYID_DEFAULT_ADDR_STATE'));
				Configuration::updateValue('SHIPTOMYID_DEFAULT_ADDR_COUNTRY', Tools::getValue('SHIPTOMYID_DEFAULT_ADDR_COUNTRY'));

				Configuration::updateValue('SHIPTOMYID_POPUP_URL', Tools::getValue('SHIPTOMYID_POPUP_URL'));
				Configuration::updateValue('SHIPTOMYID_POPUP_WIDTH', Tools::getValue('SHIPTOMYID_POPUP_WIDTH'));
				Configuration::updateValue('SHIPTOMYID_POPUP_HEIGHT', Tools::getValue('SHIPTOMYID_POPUP_HEIGHT'));

				Configuration::updateValue('SHIPTOMYID_CANCEL_ORDER_STATE', Tools::getValue('SHIPTOMYID_CANCEL_ORDER_STATE'));

				$this->html .= $this->displayConfirmation($this->l('Settings updated'));
			}
			else
			{
				foreach ($this->errors as $err)
					$this->html .= $this->displayError($err);
			}
		}

		if (!$this->checkCurl())
			$this->html .= $this->displayError('ERROR : cUrl don\'t find on your server.');

		$this->html .= $this->renderForm();

		return $this->html;
	}

	public function renderForm()
	{
		$enable_values = array(
			array('id' => 0, 'name' => 'No'),
			array('id' => 1, 'name' => 'Yes'),
		);

		$countries = CountryCore::getCountries($this->context->language->id);
		$all_states = StateCore::getStates($this->context->language->id);
		$states = array();
		foreach ($all_states as $row)
			$states[$row['id_country']][] = $row;
		$empty_states = array(array('id_state' => 0, 'name' => '-'));
		$order_state = OrderState::getOrderStates($this->context->language->id);

		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Contact details'),
					'icon' => 'icon-envelope'
				),
				'input' => array(
					array(
						'type' => 'hidden',
						'name' => 'secureKey',
					),
					//-----------------------
					//  Enable module
					array(
						'type' => 'select',
						'label' => $this->l('Enable'),
						'name' => 'SHIPTOMYID_ENABLE',
						'options' => array(
							'query' => $enable_values,
							'id' => 'id',
							'name' => 'name',
						)
					),
					//-----------------------
					//  Account and url config
					array(
						'type' => 'text',
						'label' => $this->l('Ship2MyId username'),
						'name' => 'SHIPTOMYID_USERNAME',
						'size' => 64
					),
					array(
						'type' => 'password',
						'label' => $this->l('Ship2MyId password'),
						'name' => 'SHIPTOMYID_PASSWORD',
						'size' => 64
					),
					array(
						'type' => 'text',
						'label' => $this->l('Webservice URL'),
						'name' => 'SHIPTOMYID_WEBSERVICE_URL',
						'size' => 64
					),
					array(
						'type' => 'text',
						'label' => $this->l('Terms URL'),
						'name' => 'SHIPTOMYID_TERMS_URL',
						'size' => 64
					),
					array(
						'type' => 'text',
						'label' => $this->l('Privacy policy URL'),
						'name' => 'SHIPTOMYID_PRIVACY_URL',
						'size' => 64
					),
					array(
						'type' => 'text',
						'label' => $this->l('Ship2MyId video link'),
						'name' => 'SHIPTOMYID_VIDEO_LINK',
						'size' => 64
					),
					//-----------------------
					//  Default address
					array(
						'type' => 'text',
						'label' => $this->l('Default street address'),
						'name' => 'SHIPTOMYID_DEFAULT_ADDR_ADDRESS',
						'size' => 64
					),
					array(
						'type' => 'text',
						'label' => $this->l('Default stree address (line 2)'),
						'name' => 'SHIPTOMYID_DEFAULT_ADDR_ADDRESS2',
						'size' => 64
					),
					array(
						'type' => 'text',
						'label' => $this->l('Default City'),
						'name' => 'SHIPTOMYID_DEFAULT_ADDR_CITY',
						'size' => 64
					),
					array(
						'type' => 'select',
						'label' => $this->l('Default region/state'),
						'name' => 'SHIPTOMYID_DEFAULT_ADDR_STATE',
						'options' => array(
							'query' => $empty_states,
							'id' => 'id_state',
							'name' => 'name',
						)
					),
					array(
						'type' => 'text',
						'label' => $this->l('Default zip/postal code'),
						'name' => 'SHIPTOMYID_DEFAULT_ADDR_POSTCODE',
						'size' => 64
					),
					array(
						'type' => 'select',
						'label' => $this->l('Default Country'),
						'name' => 'SHIPTOMYID_DEFAULT_ADDR_COUNTRY',
						'options' => array(
							'query' => $countries,
							'id' => 'id_country',
							'name' => 'name',
						)
					),
					array(
						'type' => 'text',
						'label' => $this->l('Default phone number'),
						'name' => 'SHIPTOMYID_DEFAULT_ADDR_PHONE',
						'size' => 64
					),
					array(
						'type' => 'text',
						'label' => $this->l('Ship2MyId label'),
						'name' => 'SHIPTOMYID_DEFAULT_ADDR_ALIAS',
						'size' => 64
					),
					//-----------------------
					//  Popup config
					array(
						'type' => 'text',
						'label' => $this->l('Webservice popup URL'),
						'name' => 'SHIPTOMYID_POPUP_URL',
						'size' => 64
					),
					array(
						'type' => 'text',
						'label' => $this->l('Webservice popup width'),
						'name' => 'SHIPTOMYID_POPUP_WIDTH',
						'size' => 64
					),
					array(
						'type' => 'text',
						'label' => $this->l('Webservice popup height'),
						'name' => 'SHIPTOMYID_POPUP_HEIGHT',
						'size' => 64
					),
					//-----------------------
					//  Order state config
					array(
						'type' => 'select',
						'label' => $this->l('Rejected order status'),
						'name' => 'SHIPTOMYID_CANCEL_ORDER_STATE',
						'options' => array(
							'query' => $order_state,
							'id' => 'id_order_state',
							'name' => 'name',
						)
					),
					//-----------------------
					//  Other information
					array(
						'type' => 'free',
						'label' => $this->l('Check order cron URL'),
						'name' => 'cron_link'
					),
					array(
						'type' => 'free',
						'name' => 'js_data'
					),
				),
				'submit' => array(
					'title' => $this->l('Save'),
				)
			),
		);

		$helper = new HelperForm();

		$helper->submit_action = 'btnSubmit';
		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues($states),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
		);
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name
		.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');

		return $helper->generateForm(array($fields_form));
	}

	private function getConfigFieldsValues($states)
	{
		return array(
			'secureKey' => 1,
			'SHIPTOMYID_ENABLE' => Tools::getValue('SHIPTOMYID_ENABLE', Configuration::get('SHIPTOMYID_ENABLE')),

			'SHIPTOMYID_USERNAME' => Tools::getValue('SHIPTOMYID_USERNAME', Configuration::get('SHIPTOMYID_USERNAME')),
			'SHIPTOMYID_PASSWORD' => Tools::getValue('SHIPTOMYID_PASSWORD', Configuration::get('SHIPTOMYID_PASSWORD')),

			'SHIPTOMYID_WEBSERVICE_URL' => Tools::getValue('SHIPTOMYID_WEBSERVICE_URL', Configuration::get('SHIPTOMYID_WEBSERVICE_URL')),
			'SHIPTOMYID_TERMS_URL' => Tools::getValue('SHIPTOMYID_TERMS_URL', Configuration::get('SHIPTOMYID_TERMS_URL')),
			'SHIPTOMYID_PRIVACY_URL' => Tools::getValue('SHIPTOMYID_PRIVACY_URL', Configuration::get('SHIPTOMYID_PRIVACY_URL')),
			'SHIPTOMYID_VIDEO_LINK' => Tools::getValue('SHIPTOMYID_VIDEO_LINK', Configuration::get('SHIPTOMYID_VIDEO_LINK')),

			'SHIPTOMYID_DEFAULT_ADDR_ADDRESS' => Tools::getValue('SHIPTOMYID_DEFAULT_ADDR_ADDRESS', Configuration::get('SHIPTOMYID_DEFAULT_ADDR_ADDRESS')),
			'SHIPTOMYID_DEFAULT_ADDR_ADDRESS2' => Tools::getValue('SHIPTOMYID_DEFAULT_ADDR_ADDRESS2', Configuration::get('SHIPTOMYID_DEFAULT_ADDR_ADDRESS2')),
			'SHIPTOMYID_DEFAULT_ADDR_CITY' => Tools::getValue('SHIPTOMYID_DEFAULT_ADDR_CITY', Configuration::get('SHIPTOMYID_DEFAULT_ADDR_CITY')),
			'SHIPTOMYID_DEFAULT_ADDR_POSTCODE' => Tools::getValue('SHIPTOMYID_DEFAULT_ADDR_POSTCODE', Configuration::get('SHIPTOMYID_DEFAULT_ADDR_POSTCODE')),
			'SHIPTOMYID_DEFAULT_ADDR_PHONE' => Tools::getValue('SHIPTOMYID_DEFAULT_ADDR_PHONE', Configuration::get('SHIPTOMYID_DEFAULT_ADDR_PHONE')),
			'SHIPTOMYID_DEFAULT_ADDR_ALIAS' => Tools::getValue('SHIPTOMYID_DEFAULT_ADDR_ALIAS', Configuration::get('SHIPTOMYID_DEFAULT_ADDR_ALIAS')),
			'SHIPTOMYID_DEFAULT_ADDR_COUNTRY' => Tools::getValue('SHIPTOMYID_DEFAULT_ADDR_COUNTRY', Configuration::get('SHIPTOMYID_DEFAULT_ADDR_COUNTRY')),
			'SHIPTOMYID_DEFAULT_ADDR_STATE' => Tools::getValue('SHIPTOMYID_DEFAULT_ADDR_STATE', Configuration::get('SHIPTOMYID_DEFAULT_ADDR_STATE')),

			'SHIPTOMYID_POPUP_URL' => Tools::getValue('SHIPTOMYID_POPUP_URL', Configuration::get('SHIPTOMYID_POPUP_URL')),
			'SHIPTOMYID_POPUP_WIDTH' => Tools::getValue('SHIPTOMYID_POPUP_WIDTH', Configuration::get('SHIPTOMYID_POPUP_WIDTH')),
			'SHIPTOMYID_POPUP_HEIGHT' => Tools::getValue('SHIPTOMYID_POPUP_HEIGHT', Configuration::get('SHIPTOMYID_POPUP_HEIGHT')),

			'SHIPTOMYID_CANCEL_ORDER_STATE' => Tools::getValue('SHIPTOMYID_CANCEL_ORDER_STATE', Configuration::get('SHIPTOMYID_CANCEL_ORDER_STATE')),

			'cron_link' => '<div style="padding-top:5px"><a target="_blank" class="button" 
			href="'.__PS_BASE_URI__.'modules/'.$this->name.'/crons/check_orders.php?token='.Configuration::get('SHIPTOMYID_CRON_TOKEN').'">'.
			$this->l('Start cron check order process').'</a></div>',

			'js_data' => '<script type="text/javascript">$(function(){
			var states_tab = '.Tools::jsonEncode($states).';
			var current_state = '.(int)Tools::getValue('SHIPTOMYID_DEFAULT_ADDR_STATE', Configuration::get('SHIPTOMYID_DEFAULT_ADDR_STATE')).';
			$("#SHIPTOMYID_DEFAULT_ADDR_COUNTRY").change(function(){
				console.log("change country");
				change_state_select($(this).val());
			});
			change_state_select($("#SHIPTOMYID_DEFAULT_ADDR_COUNTRY").val());
			function change_state_select(current_country){
				console.log("chnage_state to "+current_country);
				var default_state_select = $("#SHIPTOMYID_DEFAULT_ADDR_STATE");
				default_state_select.empty();
				default_state_select.append(\'<option value="0">---</option>\');
				if (typeof states_tab[current_country] != "undefined") {
					for (var i in states_tab[current_country]) {
						default_state_select.append(\'<option value="\'+states_tab[current_country][i][\'id_state\']+\'">\'
						+states_tab[current_country][i][\'name\']+\'</option>\');
					}
				}
				default_state_select.val(current_state);
			}
			console.log("State js load");
			});</script>',
		);
	}
}