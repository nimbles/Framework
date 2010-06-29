<?php
namespace Mu\Core\Log\Writer;

/**
 * @category Mu\Core
 * @package Mu\Core\Log\Writer\Mock
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Mock extends \Mu\Core\Log\Writer {
	/**
	 * Array of entries
	 * @var array
	 */
	protected $_entries;
	
	/**
	 * Gets the array of written entries
	 * @return array
	 */
	public function getEntries() {
		if (!is_array($this->_entries)) {
			$this->_entries = array();
		}
		
		return $this->_entries;
	}
	
	/**
	 * Writes an entry to an array
	 * @param string $entry
	 * @return void
	 */
	protected function _write($entry) {
		if (!is_array($this->_entries)) {
			$this->_entries = array();
		}
		
		$this->_entries[] = $entry;
	}
}