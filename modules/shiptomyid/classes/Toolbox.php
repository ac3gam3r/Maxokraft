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

class Toolbox
{
	public static function cleanName($name)
	{
		return preg_replace(Tools::cleanNonUnicodeSupport('/[0-9!<>,;?=+()@#"°{}_$%:]*/'), '', $name);
	}

	public static function cleanPhone($number)
	{
		return preg_replace('/[^+0-9. ()-]*/', '', $number);
	}

	public static function cleanPostCode($value)
	{
		return preg_replace('/[^a-zA-Z 0-9-]*/', '', $value);
	}


}