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
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Adapter;

use Mu\Core\Mixin\Mixinable\MixinableAbstract,
    Mu\Core\Adapter;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\Mixinable\MixinableAbstract
 */
class Adaptable extends MixinableAbstract {
    /**
     * The adapter for the given object
     * @var object
     */
    protected $_adapter;

    /**
     * Gets the adapter
     * @return object
     */
    public function getAdapter() {
        return $this->_adapter;
    }

    /**
     * Sets the adapter
     * @param object $adapter
     * @return \Mu\Core\Adapter\Adaptable
     */
    public function setAdapter($adapter) {
        if (!is_object($adapter) && !is_string($adapter)) {
            throw new Adapter\Exception\InvalidAdapter('Adapter must be an object or a string');
        }

        $config = $this->getConfig();

        if (is_string($adapter)) {
            $paths = array('');
            if (null !== $config) {
                if (isset($config->paths)) {
                    $paths = $config->paths;
                }
            }

            $adapterInstance = null;
            foreach ($paths as $path) {
                $adapterClass = $path . '\\' . $adapter;
                if (class_exists($adapterClass)) {
                    $args = func_get_args();
                    array_pop($args);
                    $adapterInstance = new $adapterClass($args);
                    break;
                }
            }
            if (null === $adapterInstance) {
                throw new Adapter\Exception\InvalidAdapter('Adapter cannot be found');
            }
            $adapter = $adapterInstance;
        }

        if (null !== $config) {
	        $ref = new \ReflectionClass($adapter);
	        if (null !== ($abstract = $config->abstract)) {
	            if (!$ref->isSubclassOf($abstract)) {
	                throw new Adapter\Exception\InvalidAbstract('Adapter does not extend abstract ' . $abstract);
	            }
	        } else if (null !== ($interface = $config->interface)) {
	            if (!$ref->implementsInterface($interface)) {
	                throw new Adapter\Exception\InvalidInterface('Adapter does not implement interface ' . $interface);
	            }
	        }
        }

        $this->_adapter = $adapter;

        return $this;
    }

    /**
     * Reference to self, so that the saved adapter can be accessed
     * @return \Mu\Core\Adapter\Adaptable
     */
    public function getObject() {
        return $this;
    }

    /**
     * Gets the mixed in methods
     * @return array
     */
    public function getMethods() {
        if (null === $this->_methods) {
            $this->_methods = array(
                'getAdapter' => function($object, &$adaptable) {
                    return $adaptable->getAdapter();
                },

                'setAdapter' => function($object, &$adaptable, $value) {
                    $adaptable->setAdapter($value);
                    return $object;
                }
            );
        }

        return $this->_methods;
    }

    /**
     * Gets the mixed in properties
     * @return array
     */
    public function getProperties() {
        if (null === $this->_properties) {
            $this->_properties = array(
                'adapter' => function($object, &$adaptable, $get, $property, array $value = null) {
                    if (!$get) {
                        $object->setAdapter($value);
                        return $value;
                    }

                    return $object->getAdapter();
                }
            );
        }

        return $this->_properties;
    }
}