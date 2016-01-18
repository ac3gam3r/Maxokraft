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

class ShiptomyidCart extends ObjectModel
{
	public $id_cart;

	public $receiver_email;
	public $receiver_lastname;
	public $receiver_firstname;
	public $receiver_postcode;
	public $receiver_city;
	public $receiver_id_country = 0;
	public $receiver_id_state = 0;

	public $receiver_phone;
	public $receiver_type;
	public $receiver_linkedin_id = null;
	public $receiver_facebook_id = null;

	public static $definition = array(
		'table' => 'shiptomyid_cart',
		'primary' => 'id_shipto_cart',
		'fields' => array(
			'id_cart'       => array('type' => self::TYPE_INT, 'validate' => 'isInt'),

			'receiver_email'        => array('type' => self::TYPE_STRING, 'validate' => 'isEmail'),
			'receiver_lastname'     => array('type' => self::TYPE_STRING, 'validate' => 'isName'),
			'receiver_firstname'    => array('type' => self::TYPE_STRING, 'validate' => 'isName'),
			'receiver_postcode'     => array('type' => self::TYPE_STRING, 'validate' => 'isPostCode'),
			'receiver_city'         => array('type' => self::TYPE_STRING, 'validate' => 'isCityName'),
			'receiver_id_country'   => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
			'receiver_id_state'     => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
			'receiver_phone'        => array('type' => self::TYPE_STRING, 'validate' => 'isPhoneNumber'),
			'receiver_type'         => array('type' => self::TYPE_STRING, 'validate' => 'isName'),
			'receiver_linkedin_id'  => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
			'receiver_facebook_id'  => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
		),
	);

	/**
	 * Get ShiptomyidOrder object for a specific Prestashop id_order.
	 * @param $id_cart
	 * @return ShiptomyidCart
	 */
	public static function getByIdCart($id_cart)
	{
		$index = (int)Db::getInstance()->getValue('SELECT '.self::$definition['primary'].'
			FROM '._DB_PREFIX_.self::$definition['table'].' WHERE id_cart = '.(int)$id_cart);

		if ($index)
			return new ShiptomyidCart($index);

		return false;
	}
}