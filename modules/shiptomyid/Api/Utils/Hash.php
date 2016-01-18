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
 * Library of array functions for manipulating and extracting data
 * from arrays or 'sets' of data.
 *
 * `Hash` provides an improved interface, more consistent and
 * predictable set of features over `Set`. While it lacks the spotty
 * support for pseudo Xpath, its more fully featured dot notation provides
 * similar features in a more consistent implementation.
 */
class Hash
{

	/**
	 * This function can be thought of as a hybrid between PHP's `array_merge` and `array_merge_recursive`.
	 *
	 * The difference between this method and the built-in ones, is that if an array key contains another array, then
	 * Hash::merge() will behave in a recursive fashion (unlike `array_merge`). But it will not act recursively for
	 * keys that contain scalar values (unlike `array_merge_recursive`).
	 *
	 * Note: This function will work with an unlimited amount of arguments and typecasts non-array parameters into arrays.
	 *
	 * @param array $data Array to be merged
	 * @param mixed $merge Array to merge with. The argument and all trailing arguments will be array cast when merged
	 *
	 * @return array Merged array
	 * @link http://book.cakephp.org/2.0/en/core-utility-libraries/hash.html#Hash::merge
	 */
	public static function merge(array $data, $merge)
	{
		$args = func_get_args();
		$return = current($args);
		$data = !is_array($data)?array():$data;
		$merge = !empty($merge)?$merge:null;

		while (($arg = next($args)) !== false)
			foreach ((array)$arg as $key => $val)
			{
				if (!empty($return[$key]) && is_array($return[$key]) && is_array($val))
					$return[$key] = self::merge($return[$key], $val);
				elseif (is_int($key) && isset($return[$key]))
					$return[] = $val;
				else
					$return[$key] = $val;
			}

		return $return;
	}


}