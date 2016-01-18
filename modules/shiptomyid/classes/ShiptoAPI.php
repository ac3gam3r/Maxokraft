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

require_once dirname(__FILE__).'/../Api/Client/Curl/CurlClientInterface.php';
require_once dirname(__FILE__).'/../Api/Client/Rest/RestClientInterface.php';
require_once dirname(__FILE__).'/../Api/Client/Curl/CurlClient.php';
require_once dirname(__FILE__).'/../Api/Client/Curl/CurlException.php';
require_once dirname(__FILE__).'/../Api/Client/Rest/RestClient.php';
require_once dirname(__FILE__).'/../Api/Client/Rest/RestException.php';
require_once dirname(__FILE__).'/../Api/Utils/Hash.php';
require_once dirname(__FILE__).'/../Api/Client.php';

class ShiptoAPI extends Client
{
	private $access_token = null;

	private $path = '';
	private $method = 'GET';

	public function __construct()
	{
		parent::__construct(null, null);

		self::$url['base'] = Configuration::get('SHIPTOMYID_WEBSERVICE_URL');
	}

	/**
	 * Get access_token for session.
	 */
	public function getSession()
	{
		if (empty($this->access_token))
		{
			$fields = array(
				'username' => Configuration::get('SHIPTOMYID_USERNAME'),
				'password' => Configuration::get('SHIPTOMYID_PASSWORD')
			);

			$this->method = 'GET';
			$this->path = '/session/signin';
			$return = $this->query($fields, null, false);

			if (isset($return['Session']) && isset($return['Session']['access_token']))
			{
				$this->access_token = $return['Session']['access_token'];
				return $this->access_token;
			}

			return false;
		}

		return $this->access_token;
	}


	public function closeSession()
	{
		$this->method = 'DELETE';
		$this->path = '/session';
		$this->query(array());

		return true;
	}


	/**
	 * Send order to shiptomyid.
	 */
	public function sendOrder($data)
	{
		$this->getSession();

		$this->method = 'POST';
		$this->path = '/order/create';
		return $this->query($data, 'json');
	}


	/**
	 * Get current status for an order.
	 */
	public function getOrder($id_order)
	{
		$this->getSession();

		$this->method = 'GET';
		$this->path = '/order/'.$id_order;
		return $this->query(array());
	}


	/**
	 * Get current status for group of order.
	 * @param $data
	 * @return bool|mixed
	 */
	public function getOrdersStatus($data)
	{
		$this->getSession();

		$this->method = 'POST';
		$this->path = '/order/status?status_type=both';
		return $this->query($data, 'json');
	}


	/**
	 * Search for a specific order.
	 * @param $data
	 * @return bool|mixed
	 */
	public function searchOrder($data)
	{
		$this->getSession();

		$this->method = 'GET';
		$this->path = '/order/search_order';
		return $this->query($data);
	}

	/**
	 * Get zip and state address for a registered user.
	 * @param $data
	 * @return bool|mixed
	 */
	public function getZipAndState($data)
	{
		$this->getSession();

		$this->method = 'GET';
		$this->path = '/order/zipcode_state';
		return $this->query($data);
	}

	/**
	 * Mark an order as complete.
	 */
	public function completeOrder($id_order)
	{
		$this->getSession();

		$this->method = 'PUT';
		$this->path = '/order/complete/'.$id_order;
		return $this->query(array(), 'json');
	}


	/**
	 * Mark an order as canceled.
	 */
	public function cancelOrder($id_order)
	{
		$this->getSession();

		$this->method = 'PUT';
		$this->path = '/order/cancel/'.$id_order;
		return $this->query(array(), 'json');
	}


	private function query($params = array(), $content_type = null, $use_token = true)
	{
		if (empty($this->access_token) && $use_token)
			return false;

		$headers = array(
			//'Accept-Language' => 'fr-FR',
		);

		if ($use_token)
		{
			if ($content_type == 'json')
			{
				if (strpos($this->path, '?') !== false)
					$this->path .= '&access_token='.$this->access_token;
				else
					$this->path .= '?access_token='.$this->access_token;
			}
			else
				$params['access_token'] = $this->access_token;
		}

		$response = $this->request($this->method, '//base'.$this->path, $params, $headers, $content_type);

		$return = $response;
		if (!empty($return['Error']['message']))
			ShiptomyidLog::addLog('Error in API query : '.$return['Error']['message']);

		return $return;
	}


	public static function getErrorMessage($response)
	{
		if (isset($response['Error']))
			return $response['Error']['status'].' : '.$response['Error']['message'];

		return 'Unknown APi error.';
	}
}