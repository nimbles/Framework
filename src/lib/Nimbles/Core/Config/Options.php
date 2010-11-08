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

namespace Nimbles\Core\Config;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Config\Configurable
 */
class Options extends Configurable {
    /**
     * Gets the object associated with the mixin
     * @return \Nimbles\Core\Config
     */
    public function getObject() {
        $config = parent::getObject();
        if (null !== $this->getConfig()) {
            $config->setConfig($this->getConfig());
        }

        return $config;
    }

    /**
     * Gets the methods which can be mixed in
     * @return array
     */
    public function getMethods() {
        if (null === $this->_methods) {
            $this->_methods = array(
                'getOption' => function($object, &$config, $key) {
                    $methods = array_map(
                        function($prefix) use ($key) {
                            return $prefix . ucfirst($key);
                        },
                        array('get', 'is')
                    );

                    foreach ($methods as $method) {
                        if (method_exists($object, $method) || false !== $object->methodExists($method)) {
                            return $object->$method();
                        }
                    }

                    return $config->$key;
                },

                'setOption' => function($object, &$config, $key, $value) {
                    $methods = array_map(
                        function($prefix) use ($key) {
                            return $prefix . ucfirst($key);
                        },
                        array('set', 'is')
                    );
                    foreach ($methods as $method) {
                        if (method_exists($object, $method) || false !== $object->methodExists($method)) {
                            return $object->$method($value);
                        }
                    }

                    return $config->$key = $value;
                },

                'setOptions' => function($object, &$config, $options) {
                    if (null === $options) {
                        $options = array();
                    }
                    // merge default config with provided options
                    $config->merge($options);

                    foreach ($config as $key => $value) {
                        $object->setOption($key, $value);
                    }
                }
            );
        }
        return $this->_methods;
    }
}
