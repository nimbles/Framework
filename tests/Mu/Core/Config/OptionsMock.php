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
 * @package   \Mu\Core\Config
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Mu\Core\Config;

class OptionsMock extends \Mu\Core\Mixin\MixinAbstract {
    protected $_implements = array('Mu\Core\Config\Options');

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
}