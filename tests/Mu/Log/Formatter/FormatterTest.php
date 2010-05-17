<?php
namespace Tests\Mu\Log\Formatter;
require_once 'PHPUnit/Framework.php';

/**
 * Formatter Tests
 * @author rob
 *
 */
class FormatterTest extends \PHPUnit_Framework_TestCase {
	public function testFactoryEmptyArray() {
		$this->setExpectedException('\Mu\Log\Formatter\Exception\InvalidOptions');
		\Mu\Log\Formatter::factory(array());
	}
	
	public function testFactoryInvalidOptions() {
		$this->setExpectedException('\Mu\Log\Formatter\Exception\InvalidOptions');
		\Mu\Log\Formatter::factory(1);
	}
	
	public function testFactoryStreamString() {
		$formatter = \Mu\Log\Formatter::factory('simple');
		$this->assertType('\Mu\Log\Formatter\Simple', $formatter);
	}
	
	public function testFactoryStreamArray() {
		$formatter = \Mu\Log\Formatter::factory(array('simple' => array()));
		$this->assertType('\Mu\Log\Formatter\Simple', $formatter);
	}
	
	public function testFactoryStreamArrayObject() {
		$options = new \ArrayObject(
			array('simple' => array())
		);
		$formatter = \Mu\Log\Formatter::factory($options);
		$this->assertType('\Mu\Log\Formatter\Simple', $formatter);
	}
}