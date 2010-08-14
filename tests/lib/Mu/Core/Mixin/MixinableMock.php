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
 * @category  Mu
 * @package   \Mu\Core\Mixin
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Mu\Core\Mixin;

class MixinPropertiesMock extends \Mu\Core\Mixin\MixinAbstract {
    protected $_implements = array('tests\Mu\Core\Mixin\MixinableProperties');
}

class MixinableProperties extends \Mu\Core\Mixin\Mixinable\MixinableAbstract {
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

class MixinMethodsMock extends \Mu\Core\Mixin\MixinAbstract {
    protected $_implements = array('Tests\Mu\Core\Mixin\MixinableMethods');
}

class MixinableMethods extends \Mu\Core\Mixin\Mixinable\MixinableAbstract {
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

class MixinPropertiesAndMethodsMock extends \Mu\Core\Mixin\MixinAbstract {
    protected $_implements = array('Tests\Mu\Core\Mixin\MixinableProperties', 'Tests\Mu\Core\Mixin\MixinableMethods');
}
