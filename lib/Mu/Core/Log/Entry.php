<?php
/**
 * Mu Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://mu-framework.com/license/mit
 *
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Log;

use Mu\Core\Mixin\MixinAbstract,
    Mu\Core\DateTime;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\MixinAbstract
 * @uses       \Mu\Core\Log\Config\Options
 * @uses       \Mu\Core\DateTime
 * @uses       \Mu\Core\Log\Exception\MissingMessage
 */
class Entry extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    static protected function _getImplements() {
        return array('Mu\Core\Config\Options');
    }

    /**
     * Class construct
     * @param string|array $entry
     * @return void
     * @throws \Mu\Core\Log\Exception\MissingMessage
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
