<?php
namespace Mu\Plugin;

/**
 * @category Mu
 * @package Mu\Plugin\Plugins
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Plugins extends \Mu\Mixin {
	protected $_implements = array('Mu\Config\Options');
	
	/**
	 * Plugin types, lazy loaded
	 * @var array
	 */
	protected $_types;
	
	/**
	 * Gets a plugin type
	 * @param string $type
	 * @return \Mu\Plugin|null
	 */
	public function getType($type) {
		if (!is_array($this->_types)) {
			$this->_types = array();
		}
		
		if (array_key_exists($type, $this->_types)) {
			return $this->_types[$type];
		}
		
		$types = $this->getOption('types');
		
		//print_r($types);
		
		if (!($types instanceof \Mu\Config)) {
			$types = new \Mu\Config($types);
		}
		
		foreach ($types as $key => $options) {
			if (is_numeric($key)) {
				$key = $options;
				$options = null;
			}
			
			if ($type === $key) {
				$this->_types[$type] = new \Mu\Plugin($options);
				return $this->_types[$type];
			}
		}
		
		return null;
	}
	
	/**
	 * 
	 * @param unknown_type $type
	 */
	public function hasType($type) {
		return (null !== $this->getType($type));
	}
	
	/**
	 * Magic __get to access types
	 * @param string $type
	 * @return \Mu\Plugin|null
	 */
	public function __get($type) {
		return $this->getType($type);
	}
	
	/**
	 * Magic __isset to check if a type exists
	 * @param string $type
	 * @return bool
	 */
	public function __isset($type) {
		return $this->hasType($type);
	}
	
	/**
	 * Class construct
	 * @param array|\Mu\Config $options
	 * @return void
	 */
	public function __construct($options = null) {
		parent::__construct();
		$this->setOptions($options);
	}
	
	/**
	 * Notifies all plugin types
	 * @param object|null $object
	 * @return void
	 */
	public function notify($object = null) {
		$types = $this->getOption('types');
		if (!($types instanceof \Mu\Config)) {
			$types = new \Mu\Config($types);
		}
		
		foreach ($types as $key => $options) {
			if (is_numeric($key)) {
				$key = $options;
			}
			
			$this->{$key}->notify($object);
		}
	}
}