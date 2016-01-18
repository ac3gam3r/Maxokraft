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

class ShiptomyidOrder extends ObjectModel
{
	public $id_order;
	public $id_shiptomyid = 0;

	public $lastname = '';
	public $firstname = '';
	public $address1 = '';
	public $address2 = '';
	public $postcode = '';
	public $city = '';
	public $id_country = 0;
	public $id_state = 0;
	public $phone = '';

	public $state_send = 0;
	public $state_address = 0;

	public $date_add;
	public $date_upd;

	public static $definition = array(
		'table' => 'shiptomyid_order',
		'primary' => 'id_shipto_order',
		'fields' => array(
			'id_order'      => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
			'id_shiptomyid' => array('type' => self::TYPE_INT, 'validate' => 'isInt'),

			'lastname'      => array('type' => self::TYPE_STRING, 'validate' => 'isName'),
			'firstname'     => array('type' => self::TYPE_STRING, 'validate' => 'isName'),
			'address1'      => array('type' => self::TYPE_STRING, 'validate' => 'isAddress'),
			'address2'      => array('type' => self::TYPE_STRING, 'validate' => 'isAddress'),
			'postcode'      => array('type' => self::TYPE_STRING, 'validate' => 'isPostCode'),
			'city'          => array('type' => self::TYPE_STRING, 'validate' => 'isCityName'),
			'id_country'    => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
			'id_state'      => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
			'phone'         => array('type' => self::TYPE_STRING, 'validate' => 'isString'),

			'state_send'    => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'state_address' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'date_add'      => array('type' => self::TYPE_DATE, 'validade' => 'isDate'),
			'date_upd'      => array('type' => self::TYPE_DATE, 'validade' => 'isDate'),
		),
	);

	/**
	 * Get ShiptomyidOrder object for a specific Prestashop id_order.
	 */
	public static function getByIdOrder($id_order)
	{
		$index = (int)Db::getInstance()->getValue('SELECT '.self::$definition['primary'].'
			FROM '._DB_PREFIX_.self::$definition['table'].' WHERE id_order = '.(int)$id_order);

		if ($index)
			return new ShiptomyidOrder($index);

		return false;
	}

	/**
	 * Set complete delivery address for this order.
	 * @param $data
	 */
	public function setDeliveryAddress($data)
	{
		$this->firstname = Toolbox::cleanName($data['firstname']);
		$this->lastname = Toolbox::cleanName($data['lastname']);
		$this->address1 = $data['address1'];
		$this->postcode = Toolbox::cleanPostCode($data['postcode']);
		$this->city = $data['city'];
		$this->id_country = (int)$data['id_country'];
		$this->id_state = (int)$data['id_state'];
		$this->phone = $data['phone'];

		$this->state_address = 1;
		$this->update();
	}

	public static function changeOrderStatus($id_order, $id_new_state)
	{
		$new_history = new OrderHistory();
		$new_history->id_order = (int)$id_order;
		$new_history->changeIdOrderState((int)$id_new_state, $id_order, true);

		if (!$new_history->addWithemail(true))
			ShiptomyidLog::addLog('Error changing order_state to #'.$id_new_state, $id_order);
	}

	public static function addMessageToOrder($id_order, $message)
	{
		$msg = new Message();
		$msg->message = $message;
		$msg->id_order = (int)$id_order;
		$msg->private = 1;
		$msg->add();
	}

	public static function disableUsesAddress($order)
	{
		if (Validate::isLoadedObject($order))
		{
			$address = new Address((int)$order->id_address_delivery);

			if (Validate::isLoadedObject($address))
			{
				$default_address = Configuration::getMultiple(array(
					'SHIPTOMYID_DEFAULT_ADDR_ADDRESS',
					'SHIPTOMYID_DEFAULT_ADDR_ADDRESS2',
					'SHIPTOMYID_DEFAULT_ADDR_CITY',
					'SHIPTOMYID_DEFAULT_ADDR_POSTCODE',
					'SHIPTOMYID_DEFAULT_ADDR_COUNTRY',
					'SHIPTOMYID_DEFAULT_ADDR_STATE',
					'SHIPTOMYID_DEFAULT_ADDR_PHONE',
					'SHIPTOMYID_DEFAULT_ADDR_ALIAS',
				));

				if (Validate::isAddress($default_address['SHIPTOMYID_DEFAULT_ADDR_ADDRESS']))
					$address->address1 = Tools::substr($default_address['SHIPTOMYID_DEFAULT_ADDR_ADDRESS'], 0, 128);

				if (Validate::isAddress($default_address['SHIPTOMYID_DEFAULT_ADDR_ADDRESS2']))
					$address->address2 = Tools::substr($default_address['SHIPTOMYID_DEFAULT_ADDR_ADDRESS2'], 0, 128);

				if (Validate::isCityName($default_address['SHIPTOMYID_DEFAULT_ADDR_CITY']))
					$address->city = Tools::substr($default_address['SHIPTOMYID_DEFAULT_ADDR_CITY'], 0, 64);

				if (Validate::isPostCode($default_address['SHIPTOMYID_DEFAULT_ADDR_POSTCODE']))
					$address->postcode = Tools::substr($default_address['SHIPTOMYID_DEFAULT_ADDR_POSTCODE'], 0, 12);

				if (Validate::isPhoneNumber($default_address['SHIPTOMYID_DEFAULT_ADDR_PHONE']))
					$address->phone = Tools::substr($default_address['SHIPTOMYID_DEFAULT_ADDR_PHONE'], 0, 32);

				$address->id_country = (int)$default_address['SHIPTOMYID_DEFAULT_ADDR_COUNTRY'];
				$address->id_state = (int)$default_address['SHIPTOMYID_DEFAULT_ADDR_STATE'];
				$address->update();
			}
		}

		Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'address SET deleted = 1 WHERE id_address = '.(int)$order->id_address_delivery);
	}
}