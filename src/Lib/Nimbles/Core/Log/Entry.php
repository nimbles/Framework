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

namespace Nimbles\Core\Log;

use Nimbles\Core\Mixin\MixinAbstract,
    Nimbles\Core\DateTime;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\MixinAbstract
 * @uses       \Nimbles\Core\Log\Config\Options
 * @uses       \Nimbles\Core\DateTime
 * @uses       \Nimbles\Core\Log\Exception\MissingMessage
 */
class Entry extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    protected static function _getImplements() {
        return array('Nimbles\Core\Config\Options');
    }

    /**
     * Class construct
     * @param string|array $entry
     * @return void
     * @throws \Nimbles\Core\Log\Exception\MissingMessage
     */
    public function __construct($entry) {
        $options = array();
        if (is_string($entry)) {
            $options = array(
                'timestamp' => new DateTime(),
                'pid' => getmypid(),
                'level' => LOG_INFO,
                'category' => null,
                'message' => $entry
            );
        } else if (is_array($entry)) {
            if (!array_key_exists('message', $entry)) {
                throw new Exception\MissingMessage('Log entry must contain a message');
            }

            $options = array(
                'timestamp' => array_key_exists('timestamp', $entry) ? $entry['timestamp'] : new DateTime(),
                'pid' =>  array_key_exists('pid', $entry) ? $entry['pid'] : getmypid(),
                'level' =>  array_key_exists('level', $entry) ? $entry['level'] : LOG_INFO,
                'category' =>  array_key_exists('category', $entry) ? $entry['category'] : null
            );

            // copy over message and remaining meta data
            foreach ($entry as $key => $value) {
                if (!array_key_exists($key, $options)) {
                    $options[$key] = $value;
                }
            }
        }

        $this->setOptions($options);
    }
}
