<?php
/**
 * Nimbles Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://Nimbles-framework.com/license/mit
 *
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Core\Plugin;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Plugin\Collection
 * @uses       \Nimbles\Core\Plugin\Exception\InvalidConfig
 * @uses       \Nimbles\Core\Plugin\Exception\InvalidInstance
 * @uses       \Nimbles\Core\Plugin\Exception\InvalidType
 */
trait Plugins {    
    /**
     * Gets the plugin or collection
     * @param string|null $type if null the plugins collection is returned
     * @return \Nimbles\Core\Plugin\Collection|\Nimbles\Core\Plugin|null 
     * @throws \Nimbles\Core\Plugin\Exception\InvalidConfig
     * @throws \Nimbles\Core\Plugin\Exception\InvalidInstance
     */
    public function getPlugin($type = null) {
        if (!isset($this->plugins)) {
            if (!method_exists($this, 'getConfig')) {
                throw new \Nimbles\Core\Plugin\Exception\InvalidConfig(
                	'When implmenting Plugins, a getConfig method must exist'
                );           
            }
            
            $config = $this->getConfig('plugins');
            
            if (!is_array($config) && !($config instanceof \ArrayObject)) {
                throw new \Nimbles\Core\Plugin\Exception\InvalidConfig(
                	'When implmenting Plugins, getConfig should provide an array for plugins'
                );
            }
            
            $this->plugins = new \Nimbles\Core\Plugin\Collection($config);
        } else if (!($this->plugins instanceof \Nimbles\Core\Plugin\Collection)) {
            throw new \Nimbles\Core\Plugin\Exception\InvalidInstance(
            	'plugins property is not an instanceof Nimbles\Plugin\Collection'
            );
        }
        
        if (null === $type) {
            return $this->plugins;
        }
        
        return $this->plugins->getPlugin($type);
    }
    
    /**
     * Attaches a named plugin to a given type
     * @param string $type
     * @param string $name
     * @param mixed  $plugin
     * @return \Nimbles\Core\Plugin
     * @throws \Nimbles\Core\Plugin\Exception\InvalidType
     */
    public function attach($type, $name, $plugin) {
        if (null === ($type = $this->getPlugin($type))) {
            throw new \Nimbles\Core\Plugin\Exception\InvalidType('Invalid plugin type ' . $type);
        }
        
        return $type->attach($name, $plugin);
    }
    
    /**
     * Detaches a named plugin from a given type
     * @param string $type
     * @param string $name
     * @return \Nimbles\Core\Plugin
     * @throws \Nimbles\Core\Plugin\Exception\InvalidType
     */
    public function detach($type, $name) {
        if (null === ($type = $this->getPlugin($type))) {
            throw new \Nimbles\Core\Plugin\Exception\InvalidType('Invalid plugin type ' . $type);
        }
        
        return $type->detach($name);
    }
}