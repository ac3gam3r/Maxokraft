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

require_once dirname(__FILE__).'/../../../config/config.inc.php';

$key = Tools::getValue('token', '');
if ($key != Configuration::get('SHIPTOMYID_CRON_TOKEN'))
	exit;

/** @var Shiptomyid $module */
$module = Module::getInstanceByName('shiptomyid');

/** @var ShiptoAPI $api */
$api = new ShiptoAPI();


/*
 * Check waiting address order //
 */
$orders = Db::getInstance()->ExecuteS('SELECT o.id_order, so.id_shiptomyid from '._DB_PREFIX_.'orders o
	LEFT JOIN '._DB_PREFIX_.'order_history oh ON oh.id_order = o.id_order AND oh.id_order_history = (
		SELECT tmp.id_order_history FROM '._DB_PREFIX_.'order_history tmp
		WHERE tmp.id_order = o.id_order ORDER BY id_order_history DESC LIMIT 1
	)
	JOIN '._DB_PREFIX_.'shiptomyid_order so ON so.id_order = o.id_order
	WHERE oh.id_order_state = '.(int)Configuration::get('SHIPTOMYID_OS_WAITING'));

$ids_order = array ();
$t_mapping_order = array ();
foreach ($orders as $order)
{

	$ids_order[] = $order['id_shiptomyid'];

	$t_mapping_order[$order['id_shiptomyid']] = $order['id_order'];
}
$result = $api->getOrdersStatus(array ('order_id_list' => $ids_order));

echo '<br/>ACCEPTED ORDERS<br/>';
if (!empty($result['accepted_order']))
	foreach ($result['accepted_order'] as $id_shipto_order)
		if ($module->checkOrderStatus($t_mapping_order[$id_shipto_order]))
			echo 'Accepted order - '.$t_mapping_order[$id_shipto_order].' ['.$id_shipto_order.']<br/>';

echo '<br/>REJECTED ORDERS<br/>';
if (!empty($result['rejected_order']))
	foreach ($result['rejected_order'] as $shipto_order)
		if ($module->checkOrderStatus($t_mapping_order[$shipto_order['order_id']]))
		{
			$module->api->cancelOrder($shipto_order['order_id']);

			echo '- Rejected order - '.$t_mapping_order[$shipto_order['order_id']].' ['.$shipto_order['order_id'].']<br/>';
		}

/*
 * Check invalid orders //
 */
$orders = Db::getInstance()->ExecuteS('SELECT o.id_order, c.email, sc.* from '._DB_PREFIX_.'orders o
	LEFT JOIN '._DB_PREFIX_.'order_history oh ON oh.id_order = o.id_order AND oh.id_order_history = (
		SELECT tmp.id_order_history FROM '._DB_PREFIX_.'order_history tmp
		WHERE tmp.id_order = o.id_order ORDER BY id_order_history DESC LIMIT 1
	)
	JOIN '._DB_PREFIX_.'shiptomyid_cart sc ON sc.id_cart = o.id_cart
	JOIN '._DB_PREFIX_.'customer c ON c.id_customer = o.id_customer
	WHERE oh.id_order_state = '.(int)Configuration::get('SHIPTOMYID_OS_ERROR'));

echo '<br/>INVALID ORDERS<br/>';
if ($orders)
	foreach ($orders as $order)
	{
		$data = array (
			'sender_email_address' => $order['email'],
			'receiver_email_address' => $order['receiver_email'],
			'vendor_order_id' => $order['id_order']
		);
		$result = $api->searchOrder($data);

		if (isset($result[0]['ExternalOrder']))
		{
			$result = $result[0]['ExternalOrder'];

			$module->finalizeSendErrorOrder($order['id_order'], $result['id']);
			echo '- Find order - '.$order['id_order'].' ['.$result['id'].']<br/>';
		}
		else
		{
			$o_order = new Order($order['id_order']);
			if (Validate::isLoadedObject($o_order))
			{
				$module->sendOrderToAPI($order);
				echo '- Resend order - '.$order['id_order'].' [ - ]<br/>';
			}
			else
				ShiptomyidLog::addLog('invalid order object in resend order process', $order['id_order']);

		}
	}


die('END');