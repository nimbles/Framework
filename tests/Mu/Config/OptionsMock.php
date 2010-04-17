<?php
namespace Tests\Mu\Config;

class OptionsMock extends \Mu\Mixin {
	protected $_implements = array('Mu\Config\Options');
	
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