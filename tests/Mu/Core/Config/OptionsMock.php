<?php
namespace Tests\Mu\Core\Config;

class OptionsMock extends \Mu\Core\Mixin {
	protected $_implements = array('Mu\Core\Config\Options');
	
	protected $_test;
	
	public function getTest() {
		if (null === $this->_test) {
			$this->_test = 'test';
		}
		return $this->_test;
	}
	
	public function setTest($value) {
		$this->_test = $value;
		return $this;
	}
}