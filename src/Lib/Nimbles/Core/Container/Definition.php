<?php
/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Container
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */
namespace Nimbles\Core\Container;

use Nimbles\Core\Util\Instance,
    Nimbles\Core\Container\Exception;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Container
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Util\Instance
 * @uses       \Nimbles\Core\Container\Exception\InvalidId
 * @uses       \Nimbles\Core\Container\Exception\InvalidClass
 * @uses       \Nimbles\Core\Container\Exception\InvalidParameters
 * @uses       \Nimbles\Core\Container\Exception\CreateInstanceFailure
 * @trait      \Nimbles\Core\Options
 */
class Definition {
    /**
     * The definition id
     * @var string
     */
    protected $_id;
    
    /**
     * The class this defininition is for
     * @var string
     */
    protected $_class;
    
    /**
     * The constructor parameters for this class
     * @var array
     */
    protected $_parameters = array();
    
    /**
     * Flag to indicate that the definition is for a shared resource
     * @var bool
     */
    protected $_shared = false;
    
    /**
     * Static instance map
     * @var array
     */
    protected static $_instance;
    
    /**
     * Class construct
     * @param array|\ArrayObject $options
     * @return void
     */
    public function __construct($options) {
        $this->setOptions($options, array(
            'id',
            'class'
        ));
    }
    
    /**
     * Gets the id
     * @return string
     */
    public function getId() {
        return $this->_id;
    }
    
    /**
     * Sets the id
     * @param string $id
     * @return void
     * @throws \Nimbles\Core\Container\Exception\InvalidId
     */
    public function setId($id) {
        if (!is_string($id) || (1 > strlen($id))) {
            throw new Exception\InvalidId('Invalid id, value must be a string with a length greater than zero');
        }
        
        $this->_id = $id;
        return $this;
    }
    
    /**
     * Gets the class this definition is for
     * @return string
     */
    public function getClass() {
        return $this->_class;
    }
    
    /**
     * Sets the class this definition is for
     * @param string $class
     * @return \Nimbles\Core\Container\Definition
     * @throws \Nimbles\Core\Container\Exception\InvalidClass
     */
    public function setClass($class) {
        if (!is_string($class) || !class_exists($class)) {
            throw new Exception\InvalidClass('Invalid class, value must be a string and class name must exist');
        }
        
        $this->_class = $class;
        return $this;
    }
    
    /**
     * Gets the constructor parameters for this class
     * @return array
     */
    public function getParameters() {
        return $this->_parameters;
    }
    
    /**
     * Sets the constructor parameters for this class
     * @param array|\ArrayObject $parameters
     * @return \Nimbles\Core\Container\Definition
     * @throws \Nimbles\Core\Container\Exception\InvalidParameters
     */
    public function setParameters($parameters) {
        if ($parameters instanceof \ArrayObject) {
            $parameters = $parameters->getArrayCopy();
        }
        
        if (!is_array($parameters)) {
            throw new Exception\InvalidParameters('Invalid parameters, value must be an array or instance of an ArrayObject');
        }
        
        $this->_parameters = $parameters;
        return $this;
    }
    
    /**
     * Indicates that the definition is for a shared resource
     * @param bool|null $flag Pass in a boolean to set the flag
     * @return bool
     */
    public function isShared($flag = null) {
        if (is_bool($flag)) {
            $this->_shared = $flag;
        }
        
        return $this->_shared;
    }
    
    /**
     * Gets an instance of the defined class
     * 
     * Method just calls getInstance
     * @return object
     */
    public function __invoke() {
        return $this->getInstance();
    }
    
    /**
     * Gets an instance of the defined class
     * @return object
     * @throws \Nimbles\Core\Container\Exception\CreateInstanceFailure
     */
    public function getInstance() {
        $id = $this->getId();
        
        if ($this->isShared()) {
            if (!is_array(static::$_instance)) {
                static::$_instance = array();
            }
            
            if (array_key_exists($id, static::$_instance)) {
                return static::$_instance[$id];
            }
        }
        
        $parameters = $this->getParameters();
        $class = $this->getClass();
        
        try {
            $instance = Instance::getInstance($class, $parameters);
        } catch (\Exception $ex) {
            throw new Exception\CreateInstanceFailure('Failed to create an instance of : ' . $class, 0, $ex);
        }
        
        if (!$this->isShared()) {
            return $instance;
        }
        
        static::$_instance[$id] = $instance;
        return static::$_instance[$id];
    }
}