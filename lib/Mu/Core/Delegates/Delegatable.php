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
 * @subpackage Delegates
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Delegates;

use Mu\Core\Mixin\Mixinable\MixinableAbstract;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Delegates
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\Mixinable\MixinableAbstract
 * @uses       \Mu\Core\Delegates
 */
class Delegatable extends MixinableAbstract {
    /**
     * The delegates
     * @var \Mu\Core\Delegates
     */
    protected $_delegates;

    /**
     * Gets the object associated with this mixin
     * @return \Mu\Core\Delegates
     */
    public function getObject() {
        if (null === $this->_delegates) {
            $this->_delegates = new \Mu\Core\Delegates($this->getConfig());
        }

        return $this->_delegates;
    }

    /**
     * Checks if the mixin provides the given method
     * @param string $method
     * @return bool
     */
    public function hasMethod($method) {
        if (!array_key_exists($method, $this->getMethods())) {
            if (null !== ($delegate = $this->getObject()->getDelegate($method))) {
                $this->_methods[$method] = function($object, &$delegates) use ($delegate) {
                    $args = func_get_args();
                    array_splice($args, 0, 2); // remove first 2 args

                    return call_user_func_array($delegate, $args);
                };
            }
        }

        return array_key_exists($method, $this->getMethods());
    }

    /**
     * Gets the methods which can be mixed in
     * @return array
     */
    public function getMethods() {
        if (null === $this->_methods) {
            $this->_methods = array(
                'hasDelegate' => function($thisObject, &$delegates, $name) {
                    return $delegates->hasDelegate($name);
                },

                'getDelegate' => function($thisObject, &$delegates, $name) {
                    return $delegates->getDelegate($name);
                },

                'setDelegate' => function($thisObject, &$delegates, $name, $delegate) {
                    return $delegates->setDelegate($name, $delegate);
                }
            );
        }

        return $this->_methods;
    }
}