<?php
/**
 * 2007-2014 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2014 PrestaShop SA
 * @license   http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

include (dirname(__FILE__) . '/../../config/config.inc.php');
include_once (_PS_CLASS_DIR_ . '/../classes/Customer.php');
include (dirname(__FILE__) . '/sendinblue.php');

$token = Tools::getValue('token');
$ps_shop_name = Configuration::get('PS_SHOP_NAME');
$ps_shop_name_enc = Tools::encrypt($ps_shop_name);
if ($token != $ps_shop_name_enc) {
    die('Error: Invalid Token');
}

$id_shop_group = Tools::getValue('id_shop_group', 'NULL');
$id_shop = Tools::getValue('id_shop', 'NULL');
$sendin = new Sendinblue();
$sendin_order_track_status = Configuration::get('Sendin_order_tracking_Status', '', $id_shop_group, $id_shop);
if ($sendin_order_track_status == 0) {
    $handle = fopen(_PS_MODULE_DIR_ . 'sendinblue/csv/ImportOldOrdersToSendinblue.csv', 'w+');
    $key_value = array();
    $key_value[] = 'EMAIL,ORDER_ID,ORDER_PRICE,ORDER_DATE';
    
    foreach ($key_value as $linedata) {
        fwrite($handle, $linedata . "\n");
    }
    $customer_detail = $sendin->getAllCustomers($id_shop_group, $id_shop);
    foreach ($customer_detail as $customer_value) {
        $orders = Order::getCustomerOrders($customer_value['id_customer']);
        if (count($orders) > 0) {
            $data = array();
            $data['key'] = Configuration::get('Sendin_Api_Key', '', $id_shop_group, $id_shop);
            $data['webaction'] = 'USERS-STATUS';
            $data['email'] = $customer_value['email'];
            $sendin->curlRequest($data);
            $user_status = Tools::jsonDecode($sendin->curlRequest($data), true);
            
            if ($user_status['result'] != '') {
                foreach ($orders as $orders_data) {
                    if (version_compare(_PS_VERSION_, '1.5', '>=')) {
                        $order_id = $orders_data['reference'];
                    } else {
                        $order_id = $orders_data['id_order'];
                    }
                    $order_price = Tools::safeOutput($orders_data['total_paid']);
                    $date_value = $sendin->getApiConfigValue($id_shop_group, $id_shop);
                    
                    if ($date_value->date_format == 'dd-mm-yyyy') {
                        $date = date('d-m-Y', strtotime($orders_data['date_add']));
                    } else {
                        $date = date('m-d-Y', strtotime($orders_data['date_add']));
                    }
                    $order_data = array();
                    $order_data[] = array($customer_value['email'], $order_id, $order_price, $date);
                    
                    foreach ($order_data as $line) {
                        fputcsv($handle, $line);
                    }
                }
            }
        }
    }
    fclose($handle);
    $list = str_replace('|', ',', Configuration::get('Sendin_Selected_List_Data', '', $id_shop_group, $id_shop));
    if (preg_match('/^[0-9,]+$/', $list)) {
        $list = $list;
    } else {
        $list = '';
    }
    $import_data = array();
    $import_data['webaction'] = 'IMPORTUSERS';
    $import_data['key'] = Configuration::get('Sendin_Api_Key', '', $id_shop_group, $id_shop);
    $import_data['url'] = $sendin->local_path . $sendin->name . '/csv/ImportOldOrdersToSendinblue.csv';
    $import_data['listids'] = $list;
    $import_data['notify_url'] = $sendin->local_path . 'sendinblue/EmptyImportOldOrdersFile.php?token=' . Tools::getValue('token');
    
    /**
     * List id should be optional
     */
    $sendin->curlRequestAsyc($import_data);
    
    Configuration::updateValue('Sendin_order_tracking_Status', 1, '', $id_shop_group, $id_shop);
    exit;
}
