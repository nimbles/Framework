<?php
namespace Nimbles\App;

use Nimbles\App\Request\RequestAbstract;

/**
 * @trait      \Nimbles\Core\Options
 */
class Router {
    /**
     * The action which has been routed to
     * @var string
     */
    protected $_action;
    
    /**
     * The controller which has been routed to
     * @var string
     */
    protected $_controller;
    
    /**
     * The namespace which has been routed to
     * @var string
     */
    protected $_namespace;
    
    /**
     * The match string
     * @var string
     */
    protected $_match;
    
    /**
     * The filter to apply to each part
     * @var callback
     */
    protected $_filter;
    
    /**
     * The default values
     * @var array
     */
    protected $_defaults;
    
    /**
     * Class construct
     * @param array|\ArrayObject|null $options
     * @return void
     */
    public function __construct($options = null) {
        $this->setOptions(
            $options,
            array(
                'match'
            ),
            array(
                'defaults' => array(
					'namespace'  => 'Application',
                    'controller' => 'Main',
                    'action'     => 'Default'
                )
            )
        );
    }
    
    /**
     * Gets the action which has been routed to
     * @return string|null
     */
    public function getAction() {
        return $this->_action;
    }
    
    /**
     * Gets the controller which has been routed to
     * @return string|null
     */
    public function getController() {
        return $this->_controller;
    }
    
    /**
     * Gets the namespace which has been routed to
     * @return string|null
     */
    public function getNamespace() {
        return $this->_namespace;
    }
    
    /**
     * Gets the match settings
     * @return array
     */
    public function getMatch() {
        return $this->_match;
    }
    
    /**
     * Sets the match settings
     * @param array|\ArrayObject $match
     * @return \Nimbles\App\Router\RouterAbstract
     * @todo Improve validation
     */
    public function setMatch($match) {
        if ($match instanceof \ArrayObject) {
            $match = $match->getArrayCopy();
        }
        
        if (!is_array($match)) {
            // throw;
        }
        
        $this->_match = $match;
        return $this;
    }
    
    /**
     * Gets the filter to apply to each part
     * @return callback|null
     */
    public function getFilter() {
        return $this->_filter;
    }
    
    /**
     * Sets the filter to apply to each part
     * @param callback $filter
     * @return \Nimbles\App\Router\RouterAbstract
     */
    public function setFilter($filter) {
        if (!is_callable($filter)) {
            // throw;
        }
        
        $this->_filter = $filter;
        return $this;
    }
    
    /**
     * Gets the defaults
     * @return array
     */
    public function getDefaults() {
        return $this->_defaults;
    }
    
    /**
     * Sets the defaults
     * @param array|\ArrayObject $defaults
     * @return \Nimbles\App\Router\RouterAbstract
     */
    public function setDefaults($defaults) {
        if ($defaults instanceof \ArrayObject) {
            $defaults = $defaults->getArrayCopy();
        }
        
        if (!is_array($defaults)) {
            // throw;
        }
        
        $this->_defaults = $defaults;
        return $this;
    }
    
    /**
     * Applies the router to the request to determine the controller to use
     * @param \Nimbles\App\Request\RequestAbstract $request
     * @return void
     */
    public function route(RequestAbstract $request) {
        foreach ($this->getMatch() as $type => $match) {
            if (false !== strpos($type, '.')) {
                list($type, $key) = explode('.', $type, 2);
            } else {
                $key = null;
            }
            
            if (!method_exists($request, $method = 'get' . ucfirst($type))) {
                // throw ;
            }
            
            $value = $request->$method($key); // should be ok to pass null
            
            $type = $match['type'];
            unset($match['type']);
            
            $options = array_merge($this->getDefaults(), $match);            
            $match = Router\Match\MatchAbstract::factory($type, $options);
            
            if (false === ($parts = $match->match($value))) {
                
            }
        }
    }
}