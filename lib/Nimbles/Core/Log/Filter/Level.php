<?php
/**
 * Nimbles Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://nimbl.es/license/mit
 *
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Core\Log\Filter;

use Nimbles\Core\Log\Entry;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Log\Filter\FilterAbstract
 * @uses       \Nimbles\Core\Config\Options
 * @uses       \Nimbles\Core\Log\Entry
 * @uses       \Nimbles\Core\Log\Filter\Exception\InvalidLevel
 */
class Level extends FilterAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    static protected function _getImplements() {
        return array(
            'Nimbles\Core\Config\Options' => array(
                'type' => self::LEVEL_ABOVE,
                'level' => LOG_NOTICE
            )
        );
    }

    /**
     * level filter types
     */
    const LEVEL_INCLUDE = 0;
    const LEVEL_EXCLUDE    = 1;
    const LEVEL_ABOVE     = 2;
    const LEVEL_BELOW    = 3;

    /**
     * Filters based on level
     * @param \Nimbles\Core\Log\Entry $entry
     * @throws \Nimbles\Core\Log\Filter\Exception\InvalidLevel
     */
    public function apply(Entry $entry) {
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
                } else if ($levels instanceof \ArrayObject) {
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
