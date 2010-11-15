<?php
namespace Nimbles\Plugins;

trait Plugins {
    /**
     * The plugins collection
     * @var \Nimbles\Plugins\Collection
     */
    protected $_plugins;
    
    /**
     * Gets the plugin or collection
     * @param string|null $type if null the plugins collection is returned
     * @return \Nimbles\Plugins\Collection|\Nimbles\Plugins\Plugin|null 
     */
    public function getPlugin($type = null) {
        if (null === $this->_plugins) {
            $this->_plugins = new \Nimbles\Plugins\Collection();
        }
        
        if (null === $type) {
            return $this->_plugins;
        }
        
        return $this->_plugins->getPlugin($type);
    }
    
    /**
     * Attaches a named plugin to a given type
     * @param string $type
     * @param string $name
     * @param mixed  $plugin
     * @return \Nimbles\Plugins\Plugin
     * @throws \Nimbles\Plugins\Exception\InvalidType
     */
    public function attach($type, $name, $plugin) {
        if (null === ($type = $this->getPlugin($type))) {
            throw new \Nimbles\Plugins\Exception\InvalidType('Invalid plugin type ' . $type);
        }
        
        return $type->attach($name, $plugin);
    }
    
    /**
     * Detaches a named plugin from a given type
     * @param string $type
     * @param string $name
     * @return \Nimbles\Plugins\Plugin
     * @throws \Nimbles\Plugins\Exception\InvalidType
     */
    public function detach($type, $name) {
        if (null === ($type = $this->getPlugin($type))) {
            throw new \Nimbles\Plugins\Exception\InvalidType('Invalid plugin type ' . $type);
        }
        
        return $type->detach($name);
    }
}