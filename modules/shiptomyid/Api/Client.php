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

/**
 * Class Client
 *
 * @author  Jonathan SAHM <j.sahm@newquest.fr>
 * @package NewQuest\Webservice\Framework
 */
class Client extends RestClient
{
	public static $url = array (
		'base' => '',
	);

	/**
	 * @param null|array $options
	 * @return bool|mixed
	 */
	public function sessionStart(array $options = null)
	{
		$options = !is_array($options)?array():$options;
	}

	/**
	 * @param $type
	 * @param $url
	 * @param array $data
	 * @param array $headers
	 * @return bool|mixed
	 */
	public function request($type, $url, array $data = null, array $headers = array (), $content_type = null)
	{
		$url = trim($this->getRequestUrl($url), '/');

		if ($response = parent::request($type, $url, $data, $headers, $content_type))
			return $response;

		return false;
	}
}
