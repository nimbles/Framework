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
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Config;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Config\Configurable
 */
class Options extends Configurable {
    /**
     * Gets the object associated with the mixin
     * @return \Mu\Core\Config
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
                    $method = 'get' . ucfirst($key);
                    if (method_exists($object, $method)) {
                        return $object->$method();
                    }

                    return $config->{$key};
                },

                'setOption' => function($object, &$config, $key, $value) {
                    $method = 'set' . ucfirst($key);
                    if (method_exists($object, $method)) {
                        return $object->$method($value);
                    }

                    return $config->{$key} = $value;
                },

                'setOptions' => function($object, &$config, $options) {
                    if (is_array($options) || ($options instanceof \Mu\Core\Config)) {
                        foreach ($options as $key => $value) {
                            $object->setOption($key, $value);
                        }
                    }
                }
            );
        }
        return $this->_methods;
    }
}
