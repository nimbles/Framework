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
 * @subpackage Mixin
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Core\Mixin;

use Mu\Core\Mixin\MixinAbstract,
    Mu\Core\Mixin\Mixinable\MixinableAbstract;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Mixin
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\MixinAbstract
 *
 * @uses       \Tests\Lib\Mu\Core\Mixin\MixinableProperties
 */
class MixinPropertiesMock extends MixinAbstract {
    /**
     * Class implements
     * @var array
     */
    protected $_implements = array('Tests\Lib\Mu\Core\Mixin\MixinableProperties');
}

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Mixin
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\Mixinable\MixinableAbstract
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
                    throw new \Mu\Core\Mixin\Exception\ReadOnly('readOnly property is read only');
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
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Mixin
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\MixinAbstract
 */
class MixinMethodsMock extends MixinAbstract {
    protected $_implements = array('Tests\Lib\Mu\Core\Mixin\MixinableMethods');
}

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Mixin
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\Mixinable\MixinableAbstract
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
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Mixin
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\MixinAbstract
 */
class MixinPropertiesAndMethodsMock extends MixinAbstract {
    protected $_implements = array(
        'Tests\Lib\Mu\Core\Mixin\MixinableProperties',
        'Tests\Lib\Mu\Core\Mixin\MixinableMethods'
    );
}
