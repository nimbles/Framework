<?php
namespace Nimbles\App\Router\Match;

use Nimbles\App\Request\RequestAbstract;

/**
 * 
 * Enter description here ...
 * @author rob
 * @trait \Nimbles\Core\Options
 */
abstract class MatchAbstract {
    protected $_pattern;
    
    protected $_action;
    
    protected $_controller;
    
    protected $_namespace;
    
    public function __construct($options= null) {
        $this->setOptions($options, array('pattern', 'namespace', 'controller', 'action'));
    }
    
    public function getPattern() {
        return $this->_pattern;
    }
    
    public function setPattern($pattern) {
        $this->_pattern = $pattern;
        return $this;
    }
    
    public function getAction() {
        return $this->_action;
    }
    
    public function setAction($action) {
        $this->_action = $action;
        return $this;
    }
    
    public function getController() {
        return $this->_controller;
    }
    
    public function setController($controller) {
        $this->_controller = $controller;
        return $this;
    }
    
    public function getNamespace() {
        return $this->_namespace;
    }
    
    public function setNamespace($namespace) {
        $this->_namespace = $namespace;
        return $this;
    }
    
    abstract public function match($value);
    
    public static function factory($type, $options) {
        $class = __NAMESPACE__ . '\\' . ucfirst($type);
        
        if (!class_exists($class)) {
            // throw;
        }
        
        return new $class($options);
    }
}