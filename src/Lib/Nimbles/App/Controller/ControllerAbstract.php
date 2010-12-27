<?php
namespace Nimbles\App\Controller;

use Nimbles\App\Controller\Request\RequestAbstract,
    Nimbles\App\Controller\Request\ResponseAbstract;

/**
 * @trait \Nimbles\Core\Options
 * @trait \Nimbles\Core\Event\Events
 */
abstract class ControllerAbstract {
    protected $_request;
    protected $_response;
    
    public function __construct($options = null) {
        $this->setOptions($options);
    }
    
    public function getRequest() {
        return $this->_request;
    }
    
    public function setRequest(RequestAbstract $request) {
        $this->_request = $request;
        return $this;
    }
    
    public function getResponse() {
        return $this->_response;
    }
    
    public function setResponse(ResponseAbstract $response) {
        $this->_response = $response;
        return $this;
    }
    
    public function dispatch($action, array $args = null) {
        $this->fireEvent('preDispatch', $this);
                
        try {
            if (!method_exists($this, $dispatch = $action . 'Action')) {
                // throw ;    
            }
            
            if (null == $args) {
                call_user_func(array($this, $dispatch));
            } else {
                call_user_func_array(array($this, $dispatch), $args);   
            }
        } catch (\Exception $ex) {
            
        }   
          
        $this->fireEvent('postDispatch', $this);
        
        return true;
    }
}