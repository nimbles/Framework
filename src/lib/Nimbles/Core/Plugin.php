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

namespace Nimbles\Core;

use Nimbles\Core\ArrayObject;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\MixinAbstract
 * @uses       \IteratorAggregate
 * @uses       \Nimbles\Core\Config\Options
 *
 * @uses       \Traversable
 *
 * @uses       \Nimbles\Core\ArrayObject
 * @uses       \Nimbles\Core\Plugin\Exception\InvalidAbstract
 * @uses       \Nimbles\Core\Plugin\Exception\InvalidInterface
 * @uses       \Nimbles\Core\Plugin\Exception\PluginNotFound
 * @uses       \Nimbles\Core\Plugin\Exception
 */
class Plugin extends Mixin\MixinAbstract
    implements \IteratorAggregate {

    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    protected static function _getImplements() {
        return array('Nimbles\Core\Config\Options');
    }

    /**
     * Plugin collection
     * @var \Nimbles\Core\ArrayObject
     */
    protected $_plugins;

    /**
     * The class names which have been attached
     * @var array|null
     */
    protected $_classNames;

    /**
     * Checks if a plugin exists
     * @param string $name
     * @return bool
     */
    public function hasPlugin($name) {
        return $this->getPlugins()->offsetExists($name);
    }

    /**
     * Gets a plugin by name
     * @param string $name
     * @return object|null
     */
    public function getPlugin($name) {
        if ($this->hasPlugin($name)) {
            if (is_string($this->_plugins[$name])) {
                $plugin = $this->_plugins[$name];
                $this->_plugins[$name] = new $plugin();
            }

            return $this->_plugins[$name];
        }

        return null;
    }

    /**
     * Gets the plugin collection
     * @return array
     */
    public function getPlugins() {
        if (!($this->_plugins instanceof ArrayObject)) {
            $this->_plugins = new ArrayObject();
        }

        return $this->_plugins;
    }

    /**
     * Class construct
     * @param array|\Nimbles\Core\Config $options
     * @return void
     */
    public function __construct($options = null) {
        $this->setOptions($options);
    }

    /**
     * Magic __get for getting a plugin by name
     * @param string $name
     * @return object|null
     */
    public function __get($name) {
        return $this->getPlugin($name);
    }

    /**
     * Magic __set to attach a plugin
     * @param string $name
     * @param object $plugin
     */
    public function __set($name, $plugin) {
        return $this->attach($name, $plugin);
    }

    /**
     * Magic __isset for checking if a plugin exists
     * @param string $name
     * @return bool
     */
    public function __isset($name) {
        return $this->hasPlugin($name);
    }

    /**
     * Magic __unset to detach a plugin
     * @param string $name
     */
    public function __unset($name) {
        $this->detach($name);
    }

    /**
     * Get iteractor method to allow foreach
     * @return \Traversable
     */
    public function getIterator() {
        return $this->getPlugins()->getIterator();
    }

    /**
     * Magic __call so that if a plugin is invokable it is called
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call($method, $args) {
        if ((null !== ($plugin = $this->getPlugin($method))) && is_callable($plugin)) {
            return call_user_func_array($plugin, $args);
        }

        return parent::__call($method, $args);
    }

    /**
     * Attaches a plugin
     * @param string|object $plugin
     * @throws \Nimbles\Core\Plugin\Exception\InvalidAbstract
     * @throws \Nimbles\Core\Plugin\Exception\InvalidInterface
     * @throws \Nimbles\Core\Plugin\Exception\PluginNotFound
     * @throws \Nimbles\Core\Plugin\Exception
     */
    public function attach($name, $plugin) {
        try {
            $ref = new \ReflectionClass($plugin);
            if (true === $this->getOption('singleInstance')) {
                if (!is_array($this->_classNames)) {
                    $this->_classNames = array();
                }

                if (in_array($ref->getName(), $this->_classNames)) {
                    throw new Plugin\Exception\PluginAlreadyRegistered(
                        'Cannot register duplicate instances of the same class when running in single instance mode'
                    );
                }

                $this->_classNames[] = $ref->getName();
            }

            if (null !== ($abstract = $this->getOption('abstract'))) {
                if (!$ref->isSubclassOf($abstract)) {
                    throw new Plugin\Exception\InvalidAbstract('Plugin does not extend abstract ' . $abstract);
                }
            } else if (null !== ($interface = $this->getOption('interface'))) {
                if (!$ref->implementsInterface($interface)) {
                    throw new Plugin\Exception\InvalidInterface('Plugin does not implement interface ' . $interface);
                }
            }

            if (!is_array($this->_plugins) && !($this->_plugins instanceof ArrayObject)) {
                $this->_plugins = new ArrayObject();
            }

            $this->_plugins[$name] = $plugin;
        } catch (\ReflectionException $ex) {
            if (is_string($plugin)) {
                throw new Plugin\Exception\PluginNotFound('Plugin ' . $plugin . ' does not exist');
            }

            throw new Plugin\Exception('Unknown error when attaching the plugin: ' . $ex->getMessage());
        }
    }

    /**
     * Detaches a plugin
     * @param string $name
     * @return void
     */
    public function detach($name) {
        if ($this->hasPlugin($name)) {
            unset($this->_plugins[$name]);
        }
    }

    /**
     * Notifies the plugins, following the observer pattern
     * @param object $object
     * @return void
     */
    public function notify($object = null) {
        $plugin_names = array_keys($this->getPlugins()->getArrayCopy());
        foreach ($plugin_names as $plugin_name) {
            $plugin = $this->getPlugin($plugin_name);
            if (method_exists($plugin, 'update')) {
                $plugin->update($object);
            }
        }
    }
}
