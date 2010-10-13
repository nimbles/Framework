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

use Nimbles\Core\Mixin\Mixinable\MixinableAbstract,
    Nimbles\Core\Log;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixinable\MixinableAbstract
 * @uses       \Nimbles\Core\Log
 */
class Loggable extends MixinableAbstract {
    /**
     * Gets the object associated with this mixin
     * @return \Nimbles\Core\Log
     */
    public function getObject() {
        return Log::getInstance();
    }

    /**
     * Gets the method available for this mixin
     * @return array
     */
    public function getMethods() {
        if (null === $this->_methods) {
            $this->_methods = array(
                'log' => function($object, &$log, $entry) {
                    return $log->write($entry);
                }
            );
        }
        return $this->_methods;
    }
}
