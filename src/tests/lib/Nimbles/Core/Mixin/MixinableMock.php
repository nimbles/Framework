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
 * @subpackage Mixin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Mixin;

use Nimbles\Core\Mixin\MixinAbstract,
    Nimbles\Core\Mixin\Mixinable\MixinableAbstract;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Mixin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\MixinAbstract
 *
 * @uses       \Tests\Lib\Nimbles\Core\Mixin\MixinableProperties
 */
class MixinPropertiesMock extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    static protected function _getImplements() {
        return array('Tests\Lib\Nimbles\Core\Mixin\MixinableProperties');
    }
}

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Mixin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\Mixinable\MixinableAbstract
 */
class MixinableProperties extends MixinableAbstract {
    public $readOnly = 'readonly';
    public $readAndWrite = null;

    public function getObject() {
        return $this;
    }

    public function getProperties() {
        return array(
            'readOnly' => function($object, &$mixinable, $get, $property) {
                if (!$get) {
                    throw new \Nimbles\Core\Mixin\Exception\ReadOnly('readOnly property is read only');
                }
                return $mixinable->readOnly;
            },
            'readAndWrite' => function($object, &$mixinable, $get, $property, $value = null) {
                if ($get) {
                    return $mixinable->readAndWrite;
                } else {
                    return $mixinable->readAndWrite = $value;
                }
            }
        );
    }
}

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Mixin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\MixinAbstract
 */
class MixinMethodsMock extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    static protected function _getImplements() {
        return array('Tests\Lib\Nimbles\Core\Mixin\MixinableMethods');
    }
}

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Mixin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\Mixinable\MixinableAbstract
 */
class MixinableMethods extends MixinableAbstract {
    public function getObject() {
        return $this;
    }

    public function getMethods() {
        return array(
            'testMethod' => function($object, &$mixinable) {
                $args = func_get_args();
                array_shift($args);
                array_shift($args);
                return $args;
            },
        );
    }
}

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Mixin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\MixinAbstract
 */
class MixinPropertiesAndMethodsMock extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    static protected function _getImplements() {
        return array(
            'Tests\Lib\Nimbles\Core\Mixin\MixinableProperties',
            'Tests\Lib\Nimbles\Core\Mixin\MixinableMethods'
        );
    }
}
