<?php
/**
 * 2007-2015 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
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
 * @copyright 2007-2015 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

class Customer extends CustomerCore
{
	/**
	 * Return customer addresses
	 * Override method with default Prestashop Method, To don't show the Receiver address to Custommer/ Sender
	 * @param integer $id_lang Language ID
	 * @param bool $ship2myid_flag flag to show the address
	 * @return array Addresses
	 */
	public function getAddresses($id_lang, $ship2myid_flag = true)
	{
		$share_order = (bool)Context::getContext()->shop->getGroup()->share_order;
		$cache_id = 'Customer::getAddresses'.(int)$this->id.'-'.(int)$id_lang.'-'.$share_order;
		if (!Cache::isStored($cache_id))
		{
			$sql = 'SELECT DISTINCT a.*, cl.`name` AS country, s.name AS state, s.iso_code AS state_iso
					FROM `'._DB_PREFIX_.'address` a
					LEFT JOIN `'._DB_PREFIX_.'country` c ON (a.`id_country` = c.`id_country`)
					LEFT JOIN `'._DB_PREFIX_.'country_lang` cl ON (c.`id_country` = cl.`id_country`)
					LEFT JOIN `'._DB_PREFIX_.'state` s ON (s.`id_state` = a.`id_state`)
					'.($share_order ? '' : Shop::addSqlAssociation('country', 'c')).' 
					WHERE `id_lang` = '.(int)$id_lang.' AND `id_customer` = '.(int)$this->id.' AND a.`deleted` = 0';
			//echo $ship2myid_flag.'hii';
			if ($ship2myid_flag)
				$sql .= ' AND ( ( LOWER(alias ) NOT LIKE "ship2myid-%") AND (LOWER(alias) NOT LIKE "shiptomyid-%" ) ) ';
			$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
			Cache::store($cache_id, $result);
		}
		return Cache::retrieve($cache_id);
	}

}
