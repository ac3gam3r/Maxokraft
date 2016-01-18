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

if (Tools::getValue('token') != Tools::encrypt(Configuration::get('PS_SHOP_NAME'))) {
    die('Error: Invalid Token');
}

$data = Tools::getValue('response');
$res_value = Tools::jsonDecode($data, true);

if (empty($res_value['errMsg'])) {
    foreach ($res_value['result'] as $value) {
        $result = Db::getInstance()->Execute('UPDATE  `' . _DB_PREFIX_ . 'customer`
			SET newsletter="' . pSQL($value['s']) . '",
			newsletter_date_add = "' . pSQL($value['m']) . '"
			WHERE email = "' . pSQL($value['e']) . '" ');
        $result = Db::getInstance()->Execute('UPDATE  `' . _DB_PREFIX_ . 'sendin_newsletter`
			SET active="' . pSQL($value['s']) . '",
			newsletter_date_add = "' . pSQL($value['m']) . '"
			WHERE email = "' . pSQL($value['e']) . '" ');
    }
    
    $handle = fopen(_PS_MODULE_DIR_ . 'sendinblue/csv/SyncToSendinblue.csv', 'w');
    $key_value = array();
    $key_value[] = '';
    fputcsv($handle, $key_value, '');
    fclose($handle);
}

echo 'done';
exit;
