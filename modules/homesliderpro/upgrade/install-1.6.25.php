<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_6_25($module)
{
	$checkVersion = version_compare(_PS_VERSION_, '1.6');
	if ($checkVersion >= 0){
		$module->registerHook('displayBanner');
	}
	return true;
}