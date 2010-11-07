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
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Core\Plugin;

use Nimbles\Core\Mixin\Mixinable\MixinableAbstract;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\Mixinable\MixinableAbstract
 *
 * @uses       \Nimbles\Core\Plugin\Plugins
 * @uses       \Nimbles\Core\Plugin\Exception\UndefinedType
 */
class Pluginable extends MixinableAbstract {
    /**
     * The plugins
     * @var \Nimbles\Core\Plugin\Plugins
     */
    protected $_plugins;

    /**
     * Gets the object associated with this mixin
     * @return \Nimbles\Core\Plugin
     */
    public function getObject() {
        if (null === $this->_plugins) {
            $this->_plugins = new \Nimbles\Core\Plugin\Plugins($this->getConfig());
        }

        return $this->_plugins;
    }

    /**
     * Checks if the mixin provides the given property
     * @param string $property
     * @return bool
     */
    public function hasProperty($property) {
        if (!array_key_exists($property, $this->getProperties())) {
            if (null !== ($value = $this->getObject()->getType($property))) {
                $this->_properties[$property] = function($object, &$plugins, $get, $property) {
                    if (!$get) {
                        throw new \Nimbles\Core\Mixin\Exception\ReadOnly('plugins property is read only');
                    }

                    return $plugins->$property;
                };
            }
        }

        return array_key_exists($property, $this->getProperties());
    }

    /**
     * Gets the method available for this mixin
     * @return array
     */
    public function getMethods() {
        if (null === $this->_methods) {
            $this->_methods = array(
                'attach' => function($object, &$plugins, $type, $name, $plugin) {
                    if (isset($plugins->{$type})) {
                        return $plugins->{$type}->attach($name, $plugin);
                    }

                    throw new Exception\UndefinedType('Plugin type ' . $type . ' is undefined');
                },

                'detach' => function($object, &$plugins, $type, $name) {
                    if (isset($plugins->{$type})) {
                        return $plugins->{$type}->detach($name);
                    }

                    throw new Exception\UndefinedType('Plugin type ' . $type . ' is undefined');
                },

                'notify' => function($object, &$plugins, $type = null) {
                    if (null !== $type) {
                        if (isset($plugins->{$type})) {
                            return $plugins->{$type}->notify($object);
                        }
                        throw new Exception\UndefinedType('Plugin type ' . $type . ' is undefined');
                    } else {
                        return $plugins->notify($object);
                    }
                }
            );
        }

        return $this->_methods;
    }
}