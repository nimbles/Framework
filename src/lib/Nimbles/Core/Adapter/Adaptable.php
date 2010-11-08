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
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Core\Adapter;

use Nimbles\Core\Mixin\Mixinable\MixinableAbstract,
    Nimbles\Core\Adapter;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\Mixinable\MixinableAbstract
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
     * @return \Nimbles\Core\Adapter\Adaptable
     */
    public function setAdapter($adapter) {
        if (null !== ($config = $this->getConfig())) {
            // check if namespaces have been defined, if not we cannot accept by string
            if ((null === ($namespaces = $config->namespaces)) && !is_object($adapter)) {
                throw new Adapter\Exception\InvalidAdapter('Adapter must be an object when no namespaces are provided in config');
            }

            // quick check before doing the reflection stuff
            if (!is_object($adapter) && !is_string($adapter)) {
                throw new Adapter\Exception\InvalidAdapter('Adapter must be an object or a string');
            }

            if (is_string($adapter)) {
                // get the valid classes from the namespaces and class name
                $namespaces = (null === $namespaces) ? array() : $namespaces->getArrayCopy();
                $classes = array_filter(
                    array_map(
                        function($namespace) use ($adapter) {
                            return $namespace . '\\' . $adapter;
                        },
                        $namespaces
                    ),
                    'class_exists'
                );

                if (0 === count($classes)) {
                    throw new Adapter\Exception\InvalidAdapter('Adapter cannot be found');
                }

                // get the resolved class name
                $adapter = array_shift($classes);
            }

            // start reflection here as by class name is allowed
            $ref = new \ReflectionClass($adapter);

            // check abstract and interface
            if (null !== ($abstract = $config->abstract)) {
                if (!$ref->isSubclassOf($abstract)) {
                    throw new Adapter\Exception\InvalidAbstract('Adapter does not extend abstract ' . $abstract);
                }
            } else if (null !== ($interface = $config->interface)) {
                if (!$ref->implementsInterface($interface)) {
                    throw new Adapter\Exception\InvalidInterface('Adapter does not implement interface ' . $interface);
                }
            }

            if (is_string($adapter)) {
                // create a new instance of the class with remaining args, same as call_user_func_array
                $args = func_get_args();
                array_shift($args);

                if ((null === ($constructor = $ref->getConstructor()) || (0 === count($constructor->getParameters())))) {
                    $adapter = new $adapter();
                } else {
                    $adapter = $ref->newInstanceArgs($args);
                }
            }
        } else if (!is_object($adapter)) {
            throw new Adapter\Exception\InvalidAdapter('Adapter must be an object when no config is provided');
        }

        $this->_adapter = $adapter;
        return $this;
    }

    /**
     * Reference to self, so that the saved adapter can be accessed
     * @return \Nimbles\Core\Adapter\Adaptable
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