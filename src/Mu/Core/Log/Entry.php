<?php
namespace Mu\Core\Log;

/**
 * @category Mu
 * @package Mu\Core\Log\Entry
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Entry extends \Mu\Core\Mixin {
	/**
	 * Mixin implements
	 * @var array
	 */
	protected $_implements = array('Mu\Core\Config\Options');
	
	/**
	 * Class construct
	 * @param string|array $entry
	 * @return void
	 */
	public function __construct($entry) {
		parent::__construct();
		
		$options = array();
		if (is_string($entry)) {
			$options = array(
				'timestamp' => new \Mu\Core\DateTime(),
				'pid' => getmypid(),
				'level' => LOG_INFO,
				'category' => null,
				'message' => $entry
			);
		} else if (is_array($entry)) {
			if (!array_key_exists('message', $entry)) {
				throw new Exception\MissingMessage('Log entry must contain a message');
			}
			
			$options = array(
				'timestamp' => array_key_exists('timestamp', $entry) ? $entry['timestamp'] : new \Mu\Core\DateTime(),
				'pid' =>  array_key_exists('pid', $entry) ? $entry['pid'] : getmypid(),
				'level' =>  array_key_exists('level', $entry) ? $entry['level'] : LOG_INFO,
				'category' =>  array_key_exists('category', $entry) ? $entry['category'] : null
			);
			
			// copy over message and remaining meta data
			foreach ($entry as $key => $value) {
				if (!array_key_exists($key, $options)) {
					$options[$key] = $value;	
				}
			}
		}
		
		$this->setOptions($options);
	}
}