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
 * Interface RestClientInterface
 *
 * @author Jonathan SAHM <j.sahm@newquest.fr>
 * @package NewQuest\Client\Rest
 */
interface RestClientInterface
{
	/**
	 * @param null|array $options
	 * @return bool|mixed
	 */
	public function sessionStart(array $options = null);
}
