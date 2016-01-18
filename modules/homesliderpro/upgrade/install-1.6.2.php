<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_6_2($module)
{
	$module->updateConfigs();
	
	return true;
}