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

namespace Nimbles\Core;

use Nimbles\Core\Mixin\MixinAbstract,
    Nimbles\Core\Log\Entry;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\MixinAbstract
 * @uses       \Nimbles\Core\Plugin\Pluginable
 * @uses       \Nimbles\Core\Log\Entry
 */
class Log extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    static protected function _getImplements() {
        return array(
            'Nimbles\Core\Plugin\Pluginable' => array(
                'types' => array(
                    'writers' => array('abstract' => 'Nimbles\Core\Log\Writer\WriterAbstract')
                )
            )
        );
    }

    /**
     * Instance of Log
     * @var \Nimbles\Core\Log
     */
    static protected $_instance;

    /**
     * Gets an instance of the Log
     * @return \Nimbles\Core\Log
     */
    static public function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new Log();
        }

        return self::$_instance;
    }

    /**
     * Writes a log entry
     * @param string|array|\Nimbles\Core\Log\Entry $entry
     * @return void
     */
    public function write($entry) {
        if (!($entry instanceof Entry)) {
            $entry = new Entry($entry);
        }

        foreach ($this->writers as $writer) {
            $writer->write($entry);
        }
    }
}
