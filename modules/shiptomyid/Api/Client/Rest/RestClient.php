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
 * Class RestClient
 *
 * @author Jonathan SAHM <j.sahm@newquest.fr>
 * @package NewQuest\Client\Rest
 */
abstract class RestClient implements RestClientInterface
{
	protected $public_key;
	protected $private_key;
	protected $token;
	protected $token_refresh;
	protected $options;
	protected $request;

	protected $request_type = CurlClient::CONTENT_TYPE_FORM;
	protected $response_type = CurlClient::CONTENT_TYPE_JSON;

	public static $url = array (
		'base' => null,
		'token' => null
	);

	/**
	 * @param string $public_key
	 * @param string $private_key
	 * @param null|string $token
	 * @param null|string $token_refresh
	 * @param array $options
	 */
	public function __construct($public_key, $private_key, $token = null, $token_refresh = null, array $options = null)
	{
		$this->public_key = $public_key;
		$this->private_key = $private_key;
		$this->token = $token;
		$this->token_refresh = $token_refresh;
		$this->options = $options;

		$this->request = new CurlClient($this->request_type, $this->response_type);
	}

	public static function getUrl($name, array $args = null, array $options = null)
	{
		$url = null;

		if (isset(static::$url[$name]))
		{
			$url = static::$url[$name];

			if (!is_null($options))
				$url = preg_replace('#\{([a-z0-9_]+)\}#e', 'isset($options["$1"]) ? $options["$1"] : null', $url);

			if (!is_null($args))
			{
				$parse_url = parse_url($url);

				if (!empty($parse_url['query']))
				{
					$queries = explode('&', $parse_url['query']);
					$parse_url['query'] = array ();

					foreach ($queries as $query)
					{
						$name = $query;
						$value = null;

						if (strstr($query, '='))
							list($name, $value) = explode('=', $query, 2);

						$parse_url['query'][$name] = $value;
					}

				}
				else
					$parse_url['query'] = array ();

				$url = $parse_url['scheme'].'://'.$parse_url['host'].$parse_url['path'].'?'.http_build_query(Hash::merge($parse_url['query'], $args));
			}
		}

		return $url;
	}

	/**
	 * @return mixed
	 */
	public function getToken()
	{
		return $this->token;
	}

	/**
	 * @return mixed
	 */
	public function getTokenRefresh()
	{
		return $this->token_refresh;
	}

	/**
	 * @param $type
	 * @param $url
	 * @param array $data
	 * @param array $headers
	 * @param null $content_type
	 * @return mixed
	 */
	public function request($type, $url, array $data = null, array $headers = array (), $content_type = null)
	{
		$this->request->{$type}($this->getRequestUrl($url), $data, $headers, $content_type);

		return $this->request->getResponse();
	}

	/**
	 * @param $url
	 * @param array $args
	 * @param array $options
	 * @return string
	 */
	protected function getRequestUrl($url, array $args = null, array $options = null)
	{
		if (preg_match('#^//([a-z0-9_]+)/?(.*)$#', $url, $match))
			$url = static::getUrl($match[1], $args, $options).(!empty($match[2]) ? $match[2] : '');

		return $url;
	}
}
