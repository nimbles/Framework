<?php
namespace Mu\Log;

/**
 * @category Mu
 * @package Mu\Log\Formatter
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
abstract class Formatter extends \Mu\Mixin {
	/**
	 * Abstract method to format the entry
	 * @param Entry $entry
	 */
	abstract public function format(Entry $entry);
	
	/**
	 * Factory method for formatters
	 * @param string|array $options
	 * @return \Mu\Log\Formatter
	 * @throws \Mu\Log\Formatter\Exception\InvalidFormatterType
	 */
	static public function factory($options) {
		if ($options instanceof Formatter) { // already a formatter so just return it
			return $options; 
		}
		
		if (!(is_string($options) || is_array($options) || ($options instanceof \ArrayObject))) {
			throw new Formatter\Exception\InvalidOptions('Options must be a string or array, recieved : ' . gettype($options));
		}
		
		if (is_string($options)) { // options is just the class name
			$type = $options;
			$options = array();
		} else if (is_array($options) || ($options instanceof \ArrayObject)) { // options is an array of name pointing to a array of options
			if ((is_array($options) && !count($options)) || (($options instanceof \ArrayObject) && !$options->count())) {
				throw new Formatter\Exception\InvalidOptions('Options must not be empty');
			}
			
			reset($options);
			
			$type = key($options);
			if (is_numeric($type)) {
				throw new Formatter\Exception\InvalidFormatterType('Formatter type passed into factory must be a string');
			}
			
			$options = current($options);
			if (!is_array($options)) {
				$options = array($options);
			}
		}
		
		$class = __NAMESPACE__ . '\\Formatter\\' . ucfirst($type);
		if (!class_exists($class)) {
			throw new Formatter\Exception\InvalidFormatterType('Unknown formatter type: ' . $type);
		}
		
		return new $class($options);
	}
	
	/**
	 * Gets an option formatted from an entry
	 * @param \Mu\Log\Entry $entry
	 * @param string $option
	 * @return null|string
	 */
	public function getFormattedOption(Entry $entry, $option) {
		$value = $entry->getOption($option);
		
		switch ($option) {
			case 'timestamp' :
				if (!($value instanceof \Mu\DateTime)) {
					return null;
				}
				
				return $value->format(\Mu\DateTime::ISO8601);
				break;
				
			case 'level' :
				switch ($value) {
					case LOG_EMERG :
						return 'EMERG';
						
					case LOG_ALERT :
						return 'ALERT';
						
					case LOG_CRIT :
						return 'CRIT';
						
					case LOG_ERR :
						return 'ERROR';
						
					case LOG_WARNING :
						return 'WARN';
						
					case LOG_NOTICE :
						return 'NOTICE';
						
					case LOG_INFO :
						return 'INFO';
						
					case LOG_DEBUG :
						return 'DEBUG';
				}
				break;
				
			case 'category' :
				if (null === $value) {
					return 'uncategorised';
				}
				break;
		}
		
		return $value;
	}
}