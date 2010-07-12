<?php
/**
 * Mu Framework
 *
 * LICENSE
 *
 * This shouce file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://mu-framework.com/license/mit
 *
 * @category  Mu\Core
 * @package   Mu\Core\Log\Filter\Level
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Log\Filter;

/**
 * @category  Mu\Core
 * @package   Mu\Core\Log\Filter\Level
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT Licesce
 */
class Level extends FilterAbstract {
	/**
	 * level filter types
	 */
	const LEVEL_INCLUDE = 0;
	const LEVEL_EXCLUDE	= 1;
	const LEVEL_ABOVE 	= 2;
	const LEVEL_BELOW	= 3;

	/**
	 * Mixin implements
	 * @var array
	 */
	protected $_implements = array(
		'Mu\Core\Config\Options' => array(
			'type' => self::LEVEL_ABOVE,
			'level' => LOG_NOTICE
		)
	);

	/**
	 * Filters based on level
	 * @param \Mu\Core\Log\Entry $entry
	 */
	public function apply(\Mu\Core\Log\Entry $entry) {
		$levels = $this->getOption('level');

		switch ($this->getOption('type')) {
			case self::LEVEL_ABOVE :
				if (!is_int($levels) || ($levels < 0) || ($levels > 7)) {
					throw new Exception\InvalidLevel('Level must be a valid level between LOG_DEBUG and LOG_EMERG');
				}

				return $entry->getOption('level') <= $this->getOption('level');
				break;

			case self::LEVEL_BELOW :
				if (!is_int($levels) || ($levels < 0) || ($levels > 7)) {
					throw new Exception\InvalidLevel('Level must be a valid level between LOG_DEBUG and LOG_EMERG');
				}

				return $entry->getOption('level') >= $this->getOption('level');
				break;

			case self::LEVEL_INCLUDE :
			case self::LEVEL_EXCLUDE :
				if (!is_array($levels) && !($levels instanceof \ArrayObject)) {
					$levels = array($levels);
				} else if($levels instanceof \ArrayObject) {
					$levels = $levels->getArrayCopy();
				}

				sort($levels, SORT_NUMERIC);
				if (0 === count($levels)) {
					throw Exception\InvalidLevel('Levels must not be empty');
				} else if (($levels[0] < 0) || ($levels[count($levels) - 1] > 7)) {
					throw new Exception\InvalidLevel('Level must be a valid level between LOG_DEBUG and LOG_EMERG');
				}

				if ((self::LEVEL_INCLUDE === $this->getOption('type')) && in_array($entry->getOption('level'), $levels)) {
					return true;
				}

				if ((self::LEVEL_EXCLUDE === $this->getOption('type')) && !in_array($entry->getOption('level'), $levels)) {
					return true;
				}

				break;
		}

		return false;
	}
}