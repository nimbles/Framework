<?php
namespace Nimbles\Plugin;

trait Plugins {
    /**
     * The plugins collection
     * @var \Nimbles\Plugin\Collection
     */
    protected $_plugins;
    
    /**
     * Gets the plugin or collection
     * @param string|null $type if null the plugins collection is returned
     * @return \Nimbles\Plugin\Collection|\Nimbles\Plugin\Plugin|null 
     * @throws \Nimbles\Plugin\Exception\InvalidConfig
     */
    public function getPlugin($type = null) {
        if (null === $this->_plugins) {
            if (!method_exists($this, 'getConfig')) {
                throw new \Nimbles\Plugin\Exception\InvalidConfig('When implmenting Plugins, a getConfig method must exist');           
            }
            
            if (!is_array($config = $this->getConfig('plugins'))) {
                throw new \Nimbles\Plugin\Exception\InvalidConfig('When implmenting Plugins, getConfig should provide an array for plugins');
            }
            
            $this->_plugins = new \Nimbles\Plugin\Collection();
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
     * @return \Nimbles\Plugin\Plugin
     * @throws \Nimbles\Plugin\Exception\InvalidType
     */
    public function attach($type, $name, $plugin) {
        if (null === ($type = $this->getPlugin($type))) {
            throw new \Nimbles\Plugin\Exception\InvalidType('Invalid plugin type ' . $type);
        }
        
        return $type->attach($name, $plugin);
    }
    
    /**
     * Detaches a named plugin from a given type
     * @param string $type
     * @param string $name
     * @return \Nimbles\Plugin\Plugin
     * @throws \Nimbles\Plugin\Exception\InvalidType
     */
    public function detach($type, $name) {
        if (null === ($type = $this->getPlugin($type))) {
            throw new \Nimbles\Plugin\Exception\InvalidType('Invalid plugin type ' . $type);
        }
        
        return $type->detach($name);
    }
}