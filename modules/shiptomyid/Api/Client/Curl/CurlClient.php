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
 * Class CurlClient
 *
 * @author Jonathan SAHM <j.sahm@newquest.fr>
 * @package NewQuest\Client\Curl
 *
 * @method mixed get($url, array $data = null, array $headers = array ())
 * @method mixed post($url, array $data = null, array $headers = array ())
 * @method mixed put($url, array $data = null, array $headers = array ())
 */
class CurlClient implements CurlClientInterface
{
	const CONTENT_TYPE_TEXT = 'text/plain';
	const CONTENT_TYPE_HTML = 'text/html';
	const CONTENT_TYPE_FORM = 'application/x-www-form-urlencoded';
	const CONTENT_TYPE_JSON = 'application/json';

	protected $response;
	protected $response_type;
	protected $request_type;
	protected $resource;

	/**
	 * @param string $request_type
	 * @param string $response_type
	 * @return CurlClient
	 */
	public function __construct($request_type = self::CONTENT_TYPE_FORM, $response_type = self::CONTENT_TYPE_JSON)
	{
		$this->request_type = $request_type;
		$this->response_type = $response_type;

		$this->resource = curl_init();
	}

	/**
	 * @return void
	 */
	public function __destruct()
	{
		$this->close();
	}


	/**
	 * @param $method
	 * @param array $args
	 * @return $this
	 */
	public function __call($method, array $args = array ())
	{
		array_unshift($args, Tools::strtoupper($method));

		call_user_func_array(array ($this, 'sendRequest'), $args);

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getResponse()
	{
		return $this->response;
	}

	/**
	 * @param $type
	 * @param $url
	 * @param array $data
	 * @param array $headers
	 * @param null $content_type
	 * @throws CurlException
	 */
	protected function sendRequest($type, $url, array $data = null, array $headers = array (), $content_type = null)
	{
		$this->setRequestOption(CURLOPT_HEADER, false);
		$this->setRequestOption(CURLOPT_RETURNTRANSFER, true);
		$this->setRequestOption(CURLOPT_AUTOREFERER, true);
		$this->setRequestOption(CURLOPT_CONNECTTIMEOUT, 5);
		$this->setRequestOption(CURLOPT_TIMEOUT, 300);
		$this->setRequestOption(CURLOPT_USERAGENT, 'Curl');
		//$this->setRequestOption(CURLOPT_FOLLOWLOCATION, true);
		$this->setRequestOption(CURLOPT_SSL_VERIFYHOST, false);
		$this->setRequestOption(CURLOPT_SSL_VERIFYPEER, false);

		// Verbose mode debug //s
		//	    $this->setRequestOption(CURLOPT_VERBOSE, true);
		//	    $fileLog = fopen(dirname(__FILE__).'/errorlog.txt', 'a');
		//	    $this->setRequestOption(CURLOPT_STDERR, $fileLog);

		switch ($type)
		{
			case 'HEAD':

				$this->setRequestOption(CURLOPT_NOBODY, true);
				$this->setRequestOption(CURLOPT_CUSTOMREQUEST, 'HEAD');
				break;

			case 'GET':
				$this->setRequestOption(CURLOPT_CUSTOMREQUEST, 'GET');

				if (!is_null($data))
					$url .= '?'.http_build_query($data);

				$this->setRequestOption(CURLOPT_HTTPGET, true);
				break;

			case 'POST':
				$this->setRequestOption(CURLOPT_CUSTOMREQUEST, 'POST');
				$this->setRequestOption(CURLOPT_POST, true);

				switch ($content_type)
				{
					case 'json':
						if (!is_null($data))
						{
							$data = Tools::jsonEncode($data);

							$headers = Hash::merge(array (
								'Content-Type' => static::CONTENT_TYPE_JSON,
								'Content-Length' => Tools::strlen($data)
							), $headers);

							$this->setRequestOption(CURLOPT_POSTFIELDS, $data);
						}
						break;
					default:
						if (!is_null($data))
						{
							$data = http_build_query($data);

							$headers = Hash::merge(array (
								'Content-Type' => static::CONTENT_TYPE_FORM,
								'Content-Length' => Tools::strlen($data)
							), $headers);

							$this->setRequestOption(CURLOPT_POSTFIELDS, $data);
						}
						break;
				}
				break;

			case 'PUT':

				$this->setRequestOption(CURLOPT_CUSTOMREQUEST, 'PUT');

				if (!is_null($data))
				{
					$data = Tools::jsonEncode($data);

					$headers = Hash::merge(array (
						'Content-Type' => static::CONTENT_TYPE_JSON,
						'Content-Length' => Tools::strlen($data)
					), $headers);

					$this->setRequestOption(CURLOPT_POSTFIELDS, $data);
				}
				break;

			case 'DELETE':

				$this->setRequestOption(CURLOPT_CUSTOMREQUEST, 'DELETE');

				break;
		}

		if (count($headers))
		{
			$header_string = array ();

			foreach ($headers as $name => $value)
				$header_string[] = $name.': '.$value;

			$this->setRequestOption(CURLOPT_HTTPHEADER, $header_string);
		}
		else
			$this->setRequestOption(CURLOPT_HTTPHEADER, array ());

		$this->setRequestOption(CURLOPT_URL, $url);
		$this->response = curl_exec($this->resource);

		if (false === $this->response)
			throw new CurlException(curl_error($this->resource), curl_errno($this->resource));

		switch ($this->response_type)
		{
			case static::CONTENT_TYPE_JSON:

				$tmp = $this->response;
				$this->response = Tools::jsonDecode($this->response, true);

				unset($tmp);
				break;
		}
	}

	/**
	 * @param $name
	 * @param $value
	 */
	protected function setRequestOption($name, $value)
	{
		curl_setopt($this->resource, $name, $value);
	}

	/**
	 * @return void
	 */
	public function close()
	{
		if (is_resource($this->resource))
			curl_close($this->resource);
	}
}
