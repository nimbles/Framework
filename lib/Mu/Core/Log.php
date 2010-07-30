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
 * @category  \Mu\Core
 * @package   \Mu\Core\Log
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core;

use \Mu\Core\Mixin\MixinAbstract,
    \Mu\Core\Log\Entry;

/**
 * @category  \Mu\Core
 * @package   \Mu\Core\Log
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @version   $Id$
 *
 * @uses      \Mu\Core\Mixin\MixinAbstract
 * @uses      \Mu\Core\Plugin\Pluginable
 * @uses      \Mu\Core\Log\Entry
 */
class Log extends MixinAbstract {
    /**
     * Mixin implements
     * @var array
     */
    protected $_implements = array(
        'Mu\Core\Plugin\Pluginable' => array(
            'types' => array(
                'writers' => array('abstract' => 'Mu\Core\Log\Writer\WriterAbstract')
            )
        )
    );

    /**
     * Instance of Log
     * @var \Mu\Core\Log
     */
    static protected $_instance;

    /**
     * Gets an instance of the Log
     * @return \Mu\Core\Log
     */
    static public function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new Log();
        }

        return self::$_instance;
    }

    /**
     * Writes a log entry
     * @param string|array|\Mu\Core\Log\Entry $entry
     * @return void
     */
    public function write($entry) {
        if (!($entry instanceof Entry)) {
            $entry = new Entry($entry);
        }

        foreach($this->writers as $writer) {
            $writer->write($entry);
        }
    }
}
