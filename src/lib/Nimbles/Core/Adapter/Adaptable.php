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

use Nimbles\Core\Adapter;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Config\Config
 */
trait Adaptable {
    /**
     * Gets the adapter
     * @return object
     */
    public function getAdapter() {
        if (!isset($this->adapter)) {
            $this->adapter = null;
        }
        return $this->adapter;
    }

    /** 
     * Sets the adapter
     * @param object $adapter
     * @return \Nimbles\Core\Adapter\Adaptable
     */
    public function setAdapter($adapter) {

        if (!method_exists($this, 'getConfig')) {
            throw new Adapter\Exception('Dependency fail, getConfig() is missing');
        }

        $config = $this->getConfig();
        if (!$config instanceof \Nimbles\Config\Config) {
            throw new Adapter\Exception('getConfig() must return a \Nimbles\Config object');
        }

        if (null !== $config) {
            $config = $config->adaptable;
            // check if namespaces have been defined, if not we cannot accept by string
            if (isset($config->namespaces) && (null === ($namespaces = $config->namespaces)) && !is_object($adapter)) {
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
            if (isset($config->abstract) && null !== ($abstract = $config->abstract)) {
                if (!$ref->isSubclassOf($abstract)) {
                    throw new Adapter\Exception\InvalidAbstract('Adapter does not extend abstract ' . $abstract);
                }
            } else if (isset($config->interface) && null !== ($interface = $config->interface)) {
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

        $this->adapter = $adapter;
        return $this;
    }
}