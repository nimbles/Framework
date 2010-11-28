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
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Config;

use Nimbles\Core\Mixin\MixinAbstract,
    Nimbles\Core\Mixin\Mixinable\MixinableAbstract;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\MixinAbstract
 * @uses       \Nimbles\Core\Config\Options
 */
class OptionsMock extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    protected static function _getImplements() {
        return array('Nimbles\Core\Config\Options');
    }

    protected $_test;

    public function getTest() {
        if (null === $this->_test) {
            $this->_test = 'test';
        }
        return $this->_test;
    }

    public function setTest($value) {
        $this->_test = $value;
        return $this;
    }

    public function __construct($options = null) {
        $this->setOptions($options);
    }
}

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Tests\Lib\Nimbles\Core\Config\OptionsMock
 * @uses       \Nimbles\Core\Config\Options
 */
class OptionsWithDefaultsMock extends OptionsMock {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    protected static function _getImplements() {
        return array(
            'Nimbles\Core\Config\Options' => array(
                'test' => 'hello world'
            )
        );
    }
}

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\MixinAbstract
 * @uses       \Nimbles\Core\Config\Options
 */
class OptionsWithOtherMixinMock extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    protected static function _getImplements() {
        return array(
            'Nimbles\Core\Config\Options',
            'Tests\Lib\Nimbles\Core\Config\MixinableMock'
        );
    }

    public function __construct($options = null) {
        $this->setOptions($options);
    }
}

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\Mixinable\MixinableAbstract
 */
class MixinableMock extends MixinableAbstract {
    protected $_test;

    public function getObject() {
        return $this;
    }

    public function getTest() {
        return $this->_test;
    }

    public function setTest($value) {
        $this->_test = $value;
    }

    public function getMethods() {
        return array(
            'getTest' => function($object, &$mixinable) {
                return $mixinable->getTest();
            },
            'setTest' => function($object, &$mixinable, $value) {
                $mixinable->setTest($value);
                return $object;
            },
        );
    }
}