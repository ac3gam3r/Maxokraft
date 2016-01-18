<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_6_33($module)
{
	$res = (bool)Db::getInstance()->execute('
		CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'sesliders_slideconf` (
			`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			`id_shop` int(10) unsigned NOT NULL,
			`id_hook` varchar(255) NULL,
			`conf` text NULL,
			PRIMARY KEY (`id`, `id_hook`)
		) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
	');
	
	$oldConfig =Configuration::get('HOMESLIDERPRO_CONFIG');
	
	if(!empty($oldConfig))
		$module->updateConfigs(unserialize($oldConfig));
	
	if ( $res && move_config($module)) {
		if (Configuration::deleteByName('HOMESLIDERPRO_CONFIG'))
			return true;
	}
}

function move_config($module){
	$config = Configuration::get('HOMESLIDERPRO_CONFIG');
	if (!empty($config)){
		$config = unserialize($config);
		foreach ($config as $hook => $conf) {
			if (!Db::getInstance()->getValue('SELECT id_hook FROM '._DB_PREFIX_.'sesliders_slideconf WHERE id_hook = "'.$hook.'"') ){
				$id_shop = $module->getShopId();
				if ( is_array($conf) ){
					Db::getInstance()->insert('sesliders_slideconf', array(
						'id_hook' => pSQL($hook),
						'id_shop' => (int)$id_shop,
						'conf' => serialize($conf),
						)
					);
				}
			}
		}
	}
	return true;
}