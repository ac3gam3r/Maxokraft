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

class ShiptomyidFrontModuleFrontController extends ModuleFrontController
{

	public function init()
	{
		parent::init();

		$this->display_column_left = false;
	}

	public function setMedia()
	{
		parent::setMedia();

		// Add CSS files //
		$this->addCSS(_THEME_CSS_DIR_.'addresses.css');
		if (class_exists('Tools') && method_exists('Tools', 'version_compare') && Tools::version_compare(_PS_VERSION_, '1.6', '>=') === true)
			$this->addCSS(__PS_BASE_URI__.'modules/'.$this->module->name.'/views/css/shiptomyid-16.css', 'all');
		else
			$this->addCSS(__PS_BASE_URI__.'modules/'.$this->module->name.'/views/css/shiptomyid.css', 'all');

		// Add JS files //
		$this->addJS(_THEME_JS_DIR_.'tools.js');
		if (class_exists('Tools') && method_exists('Tools', 'version_compare') && Tools::version_compare(_PS_VERSION_, '1.6', '>=') === true)
			$this->addJS(__PS_BASE_URI__.'modules/'.$this->module->name.'/views/js/shipto-address-16.js');
		else
			$this->addJS(__PS_BASE_URI__.'modules/'.$this->module->name.'/views/js/shipto-address.js');
	}

	public function initContent()
	{
		parent::initContent();

		$customer = $this->context->customer;

		/*
		 * Get delivery address and data.
		 */
		if ((int)$this->context->cart->id_address_delivery)
		{
			$shipto_delivery_address = new Address((int)$this->context->cart->id_address_delivery);

			$country_name = Db::getInstance()->getValue('SELECT name FROM '._DB_PREFIX_.'country_lang
		WHERE id_country = '.(int)Configuration::get('SHIPTOMYID_DEFAULT_ADDR_COUNTRY').' ');

			$state_name = Db::getInstance()->getValue('SELECT name FROM '._DB_PREFIX_.'state
		WHERE id_state = '.(int)Configuration::get('SHIPTOMYID_DEFAULT_ADDR_STATE').' ');

			$default_delivery_address = array(
				'address1' => Configuration::get('SHIPTOMYID_DEFAULT_ADDR_ADDRESS'),
				'address2' => Configuration::get('SHIPTOMYID_DEFAULT_ADDR_ADDRESS2'),
				'city' => Configuration::get('SHIPTOMYID_DEFAULT_ADDR_CITY'),
				'zip' => Configuration::get('SHIPTOMYID_DEFAULT_ADDR_POSTCODE'),
				'phone' => Configuration::get('SHIPTOMYID_DEFAULT_ADDR_PHONE'),
				'alise' => Configuration::get('SHIPTOMYID_DEFAULT_ADDR_ALIAS'),
				'country' => $country_name,
				'state' => $state_name
			);

			$this->context->smarty->assign(array(
				'shipto_delivery_address' => $shipto_delivery_address,
				'shipto_default_delivery_address' => $default_delivery_address
			));
		}

		/*
		 * Get addresses.
		 */
		$customer_addresses = $customer->getAddresses($this->context->language->id, false);

		// On supprime de la liste les addresse shipto
		foreach ($customer_addresses as $key => $address)
			if (strpos(Tools::strtolower($address['alias']), 'ship2myid') !== false)
				$customer_addresses[$key]['shipto_addr'] = 1;

		// Getting a list of formated address fields with associated values
		$formated_address_fields_values_list = array();

		foreach ($customer_addresses as $i => $address)
		{
			if (!Address::isCountryActiveById((int)$address['id_address']))
				unset($customer_addresses[$i]);
			$tmp_address = new Address($address['id_address']);
			$formated_address_fields_values_list[$address['id_address']]['ordered_fields'] = AddressFormat::getOrderedAddressFields($address['id_country']);
			$formated_address_fields_values_list[$address['id_address']]['formated_fields_values'] = AddressFormat::getFormattedAddressFieldsValues(
				$tmp_address, $formated_address_fields_values_list[$address['id_address']]['ordered_fields']);

			unset($tmp_address);
		}
		if (key($customer_addresses) != 0)
			$customer_addresses = array_values($customer_addresses);
		$this->context->smarty->assign(array(
			'addresses' => $customer_addresses,
			'formatedAddressFieldsValuesList' => $formated_address_fields_values_list
		));

		if (class_exists('Tools') && method_exists('Tools', 'version_compare') && Tools::version_compare(_PS_VERSION_, '1.6', '>=') === true)
			$this->setTemplate('front-16.tpl');
		else
			$this->setTemplate('front.tpl');
	}
}