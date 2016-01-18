<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_6_4($module)
{
	if (file_exists(_PS_MODULE_DIR_.'/homesliderpro/ajax_homesliderpro.php'))
		unlink(_PS_MODULE_DIR_.'/homesliderpro/ajax_homesliderpro.php');
}