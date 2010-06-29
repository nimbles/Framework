<?php
namespace Mu\Core\Plugin;

/**
 * @category Mu\Core
 * @package Mu\Core\Plugin\Plugins
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Plugins extends \Mu\Core\Mixin {
	protected $_implements = array('Mu\Core\Config\Options');
	
	/**
	 * Plugin types, lazy loaded
	 * @var ArrayObject
	 */
	protected $_types;
	
	/**
	 * Gets a plugin type
	 * @param string $type
	 * @return \Mu\Core\Plugin|null
	 */
	public function getType($type) {
		if (!($this->_types instanceof \ArrayObject)) {
			$this->_types = new \ArrayObject();
		}
		
		if ($this->_types->offsetExists($type)) {
			return $this->_types[$type];
		}
		
		$types = $this->getOption('types');
		
		if (!($types instanceof \Mu\Core\Config)) {
			$types = new \Mu\Core\Config($types);
		}
		
		foreach ($types as $key => $options) {
			if (is_numeric($key)) {
				$key = $options;
				$options = null;
			}
			
			if ($type === $key) {
				$this->_types[$type] = new \Mu\Core\Plugin($options);
				return $this->_types[$type];
			}
		}
		
		return null;
	}
	
	/**
	 * Checks if the plugin has the types
	 * @param string $type
	 * @return bool
	 */
	public function hasType($type) {
		return (null !== $this->getType($type));
	}
	
	/**
	 * Magic __get to access types
	 * @param string $type
	 * @return \Mu\Core\Plugin|null
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
	 * @param array|\Mu\Core\Config $options
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
		
		if (!($types instanceof \Mu\Core\Config)) {
			$types = new \Mu\Core\Config($types);
		}
		
		foreach ($types as $key => $options) {
			if (is_numeric($key)) {
				$key = $options;
			}
			
			$this->{$key}->notify($object);
		}
	}
}