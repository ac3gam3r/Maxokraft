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

require_once dirname(__FILE__).'/../../config/config.inc.php';
require_once dirname(__FILE__).'/../../init.php';
/** @var Shiptomyid $module */
$module = Module::getInstanceByName('shiptomyid');
$context = Context::getContext();

/*
 * Get shop data
 */
$current_cart = new Cart((int)Tools::getValue('data'));
if (!Validate::isLoadedObject($current_cart))
	die('<script language="javascript" type="text/javascript">top.location.href = "'.$context->link->getPageLink('order').'?step=1" ;</script>');

if (empty($_POST))
	die('An error occurred...');

/*
 * Check key
 */
$check_key = md5($current_cart->id.'_'.$current_cart->secure_key);
if (!Tools::getValue('key', false) OR Tools::getValue('key') != $check_key)
	die('An error occurred...');

/*
 * Get popup return data
 */
$receiver_type = Tools::getValue('receiver_type');
$receiver_linkedin_id = Tools::getValue('receiver_linkedin_id');
$receiver_facebook_id = Tools::getValue('receiver_facebook_id');
$postcode = Tools::getValue('postcode');
$telephone = Toolbox::cleanPhone(Tools::getValue('telephone'));
$firstname = Toolbox::cleanName(Tools::getValue('firstname'));
$lastname = Toolbox::cleanName(Tools::getValue('lastname'));
$email = Tools::getValue('email');
$country_iso = Tools::getValue('country_id');
$telephone_no = Toolbox::cleanPhone(Tools::getValue('telephone_no'));
$region = Tools::getValue('region');
$city = Tools::getValue('city');

if (!Validate::isEmail($email))
	die('<script language="javascript" type="text/javascript">top.location.href = "'.$context->link->getPageLink('order').'?step=1" ;</script>');

/*
 * Check if address already registered on ship2myid.
 */
/*
 * $sender_email = Db::getInstance()->getValue('SELECT email FROM '._DB_PREFIX_.'customer WHERE id_customer = '.(int)$current_cart->id_customer);
 */
$info = array(
	'email_address' => $email,
);
$results = $module->api->getZipAndState($info);
if (isset($results['Address']))
{
	$postcode = isset($results['Address']['zipcode']) ? $results['Address']['zipcode'] : $postcode;
	$country_iso = isset($results['Address']['country_code']) ? $results['Address']['country_code'] : $country_iso;
	$region = isset($results['Address']['state_name']) ? $results['Address']['state_name'] : $region;
}

/*
 * Find country id
 */
$id_country = (int)Db::getInstance()->getValue('SELECT id_country FROM '._DB_PREFIX_.'country
	WHERE LOWER("'.pSQL($country_iso).'") = LOWER(iso_code)');

/*
 * Find state id if needed
 */
$id_state = 0;
if (!empty($region) && $id_country)
	$id_state = (int)Db::getInstance()->getValue(
		'SELECT id_state FROM '._DB_PREFIX_.'state WHERE LOWER(name) = LOWER("'.pSQL($region).'") AND id_country = '.(int)$id_country
	);

$new_address = new Address();
$new_address->alias = 'SHIP2MYID-'.Tools::passwdGen(6);

$new_address->lastname = $lastname;
$new_address->firstname = $firstname;
$new_address->address1 = 'waiting...';
$new_address->postcode = $postcode;
$new_address->city = $city;
$new_address->phone = $telephone_no;
$new_address->id_country = $id_country;
$new_address->id_state = $id_state;
$new_address->id_customer = (int)$current_cart->id_customer;

$new_address->id_manufacturer = 0;
$new_address->id_supplier = 0;
$new_address->id_warehouse = 0;

if (!$new_address->add())
	die('<script language="javascript" type="text/javascript">top.location.href = "'.$context->link->getPageLink('order').'?step=1" ;</script>');

/*
 * Save shipto data in shipto cart object.
 */
$shipto_cart = ShiptomyidCart::getByIdCart($current_cart->id);
if (!$shipto_cart)
{
	$shipto_cart = new ShiptomyidCart();
	$shipto_cart->id_cart = $current_cart->id;
}

$shipto_cart->receiver_email = $email;
$shipto_cart->receiver_lastname = $lastname;
$shipto_cart->receiver_firstname = $firstname;
$shipto_cart->receiver_city = $city;
$shipto_cart->receiver_postcode = $postcode;
$shipto_cart->receiver_id_country = $id_country;
$shipto_cart->receiver_id_state = $id_state;
$shipto_cart->receiver_phone = $telephone_no;
$shipto_cart->receiver_type = $receiver_type;
$shipto_cart->receiver_linkedin_id = $receiver_linkedin_id;
$shipto_cart->receiver_facebook_id = $receiver_facebook_id;
if (!$shipto_cart->save())
	die('<script language="javascript" type="text/javascript">top.location.href = "'.$context->link->getPageLink('order').'?step=1" ;</script>');


/*
 * Assign this delivery to current cart.
 */
$current_cart->id_address_delivery = (int)$new_address->id;
$current_cart->update();

echo '<script language="javascript" type="text/javascript">top.location.href = "'.$context->link->getModuleLink('shiptomyid', 'front').'" ;</script>';
die('<img src="'.__PS_BASE_URI__.'modules/shiptomyid/views/img/loader.gif" align="center" alt="Loading..." />');