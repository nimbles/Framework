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
 * @package    Nimbles-Adapter
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Adapter;

use Nimbles\Core\Util\Type;

/**
 * @category   Nimbles
 * @package    Nimbles-Adapter
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @trait      \Nimbles\Core\Options
 */
class Adapter {
    /**
     * The adapter
     * @var object
     */
    protected $_adapter;
        
    /**
     * The namespaces used to map a class to
     * @var string[]|null
     */
    protected $_namespaces;
    
    /**
     * The type the adapter should be restricted to
     * @var string|null
     */
    protected $_type;
    
    /**
     * Class construct
     * @param array|\ArrayObject|null $options
     * @return void
     */
    public function __construct($options = null) {
        $options = array_merge(
            array(
                'type' => null
            ),
            $options
        );
        
        if (isset($options['adapter'])) {
            // unset adapter to ensure that the options are loaded first
            $adapter = $options['adapter'];
            unset($options['adapter']);
            
            $this->setOptions($options);
            
            // load after options are loaded
            $this->setAdapter($adapter);
        } else {
            $this->setOptions($options);
        }
    }
    
    /**
     * Gets the adapter
     * @return object
     */
    public function getAdapter() {
        return $this->_adapter;
    }
    
    /**
     * Sets the adapter
     * 
     * If the adapter passed in is a string, then the method will automatically
     * attempt to create an instance of the class within the provided options
     * 
     * @param string|object $adapter
     * @return \Nimbles\Adapter\Adapter
     * @throws \Nimbles\Adapter\Exception\InvalidAdapter
     */
    public function setAdapter($adapter) {
        if (is_string($adapter)) {
            $adapter = $this->_getMappedClass($adapter);
            
            if (!class_exists($adapter)) {
                throw new Exception\InvalidAdapter('Cannot set adapter by a string because the given class does not exist');
            }
            
            // use reflection to create a new instance
            $ref = new \ReflectionClass($adapter);
            
            $args = func_get_args();
            array_shift($args);
            
            if ((null === ($constructor = $ref->getConstructor()) || (0 === count($constructor->getParameters())))) {
                $adapter = new $adapter();
            } else {
                $adapter = $ref->newInstanceArgs($args);
            }
        }
        
        // check type is valid
        if (!is_a($adapter, $this->getType)) {
            throw new Exception\InvalidAdapter('Provided adapter is not of given type: ' . $this->getType());
        }
        
        $this->_adapter = $adapter;
        return $this;
    }
    
    /**
     * Gets the namespaces used to map a class to
     * @return string[]|null
     */
    public function getNamespaces() {
        return $this->_namespaces;
    }
    
    /**
     * Sets the namespaces used to map a class to
     * @param array|null $namespaces
     * @return \Nimbles\Adapter\Adapter
     * @throw \Nimbles\Adapter\Exception\InvalidNamespaces
     */
    public function setNamespaces($namespaces) {
        if (!((null === $namespaces) || is_array($namespaces))) {
            throw new Exception\InvalidNamespaces('Namespaces must either be null or an array');
        }
        
        $this->_namespaces = $namespaces;
        return $this;
    }
    
	/**
     * Gets the type the adapter should be restricted to
     * @return string|null
     */
    public function getType() {
        return $this->_type;
    }
    
    /**
     * Sets the type the adapter should be restricted to
     * @param string|null $type
     * @return \Nimbles\Adapter\Adapter
     */
    public function setType($type) {
        if (!((null === $type) || is_string($type))) {
            throw new Exception\InvalidType('Type must be either null or a string');
        }
        
        $this->_type = $type;
        return $this;
    }
    
    /**
     * Mapps a class according to the provided namepspaces
     * @param string $class
     * @return string
     * @throw \Nimbles\Adapter\Exception\InvalidNamespaces
     */
    protected function _getMappedClass($class) {
        if (!class_exists($class) && is_array($namespaces = $this->getNamespaces())) {
            // map with given namespaces
            $classes = array_filter(
                array_map(
                    function($namespace) use ($class) {
                        return $namespace . '\\' . $class;
                    },
                    $namespaces
                ),
                'class_exists'
            );
            
            if (0 === count($classes)) {
                throw new Exception\InvalidNamespaces('Could not locate class according to namespace mapping');
            }
            
            $class = array_shift($classes);
        }
        
        return $class;
    }
}