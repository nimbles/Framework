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

namespace Tests\Lib\Nimbles\Core\Log;

use Nimbles\Core\Mixin\MixinAbstract;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\MixinAbstract
 * @uses       \Nimbles\Core\Log\Loggable
 */
class LoggableMock extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    protected static function _getImplements() {
        return array('Nimbles\Core\Log\Loggable');
    }
}
