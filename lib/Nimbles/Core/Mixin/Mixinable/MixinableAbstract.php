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

namespace Nimbles\Core\Mixin\Mixinable;

use Nimbles\Core\Config,
    Nimbles\Core\Mixin;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Mixin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Config
 * @uses       \Nimbles\Core\Mixin\Exception\InvalidConfig
 * @uses       \Nimbles\Core\Mixin\Exception\InvalidProperty
 * @uses       \Nimbles\Core\Mixin\Exception\InvalidMethod
 */
abstract class MixinableAbstract {
    /**
     * Mixinable config
     * @var \Nimbles\Core\Config
     */
    protected $_config;

    /**
     * The properties cache
     * @var array
     */
    protected $_properties;

    /**
     * The methods cache
     * @var array
     */
    protected $_methods;

    /**
     * Gets the config
     * @return \Nimbles\Core\Config
     */
    public function getConfig() {
        return $this->_config;
    }

    /**
     * Sets the config
     * @param null|array|Nimbles\Core\Config $config
     * @return \Nimbles\Core\Mixin\Mixinable
     * @throws \Nimbles\Core\Mixin\Exception\InvalidConfig
     */
    public function setConfig($config) {
        if (null === $config) {
            return $this;
        }

        if (is_array($config)) {
            $config = new Config($config);
        }

        if (!($config instanceof \Nimbles\Core\Config)) {
            throw new Mixin\Exception\InvalidConfig('Config must be either null, an array or an instance of \Nimbles\Core\Config');
        }

        $this->_config = $config;
        return $this;
    }

    /**
     * Class construct
     * @param null|array|Nimbles\Core\Config $config
     */
    public function __construct($config = null) {
        $this->setConfig($config);
    }

    /**
     * Gets the object associated with this mixin
     * @return null|object
     */
    public function getObject() {
        return null;
    }

    /**
     * Gets the properties which can be mixed in
     * @return array
     */
    public function getProperties() {
        if (null === $this->_properties) {
            $this->_properties = array();
        }
        return $this->_properties;
    }

    /**
     * Checks if the mixin provides the given property
     * @param string $property
     * @return bool
     */
    public function hasProperty($property) {
        return array_key_exists($property, $this->getProperties());
    }

    /**
     * Gets the requested property from the mixin
     * @param string $property
     * @return \Closure
     * @throws \Nimbles\Core\Mixin\Exception\InvalidProperty
     */
    public function getProperty($property) {
        if ($this->hasProperty($property)) {
            $properties = $this->getProperties();

            if (!($properties[$property] instanceof \Closure)) {
                throw new Mixin\Exception\InvalidProperty('Property ' . $property . ' is not a closure');
            }

            return $properties[$property];
        }
    }

    /**
     * Gets the methods which can be mixed in
     * @return array
     */
    public function getMethods() {
        if (null === $this->_methods) {
            $this->_methods = array();
        }
        return $this->_methods;
    }

    /**
     * Checks if the mixin provides the given method
     * @param string $method
     * @return bool
     */
    public function hasMethod($method) {
        return array_key_exists($method, $this->getMethods());
    }

    /**
     * Gets the requested method
     * @param string $method
     * @return \Closure
     * @throws \Nimbles\Core\Mixin\Exception\InvalidMethod
     */
    public function getMethod($method) {
        if ($this->hasMethod($method)) {
            $methods = $this->getMethods();

            if (!($methods[$method] instanceof \Closure)) {
                throw new Mixin\Exception\InvalidMethod('Method ' . $method . ' is not a closure');
            }

            return $methods[$method];
        }
    }
}
