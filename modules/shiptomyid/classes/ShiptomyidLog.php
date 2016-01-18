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

class ShiptomyidLog extends ObjectModel
{
	const TYPE_INFO = 0;
	const TYPE_ERROR = 1;

	public $type;

	public $message;
	public $date_add;

	public static $definition = array(
		'table' => 'shiptomyid_log',
		'primary' => 'id_log',
		'fields' => array(
			'type'      => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
			'message'   => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
			'date_add'  => array('type' => self::TYPE_DATE, 'validade' => 'isDate'),
		),
	);

	/**
	 * Save log in database.
	 * @param $message
	 * @param int $id_order
	 * @param int $id_shipto
	 * @param int $type
	 */
	public static function addLog($message, $id_order = 0, $id_shipto = 0, $type = 1)
	{
		$new_log = new ShiptomyidLog();
		$new_log->message = $message.' [Order: '.(int)$id_order.'] - [Shipto: '.(int)$id_shipto.']';
		$new_log->type = $type;
		$new_log->add();
	}

}