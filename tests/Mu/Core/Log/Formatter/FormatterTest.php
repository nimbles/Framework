<?php
namespace Tests\Mu\Core\Log\Formatter;


/**
 * Formatter Tests
 * @author rob
 *
 */
class FormatterTest extends \Mu\Core\TestCase {
	public function testFactoryEmptyArray() {
		$this->setExpectedException('\Mu\Core\Log\Formatter\Exception\InvalidOptions');
		\Mu\Core\Log\Formatter::factory(array());
	}
	
	public function testFactoryInvalidOptions() {
		$this->setExpectedException('\Mu\Core\Log\Formatter\Exception\InvalidOptions');
		\Mu\Core\Log\Formatter::factory(1);
	}
	
	public function testFactoryStreamString() {
		$formatter = \Mu\Core\Log\Formatter::factory('simple');
		$this->assertType('\Mu\Core\Log\Formatter\Simple', $formatter);
	}
	
	public function testFactoryStreamArray() {
		$formatter = \Mu\Core\Log\Formatter::factory(array('simple' => array()));
		$this->assertType('\Mu\Core\Log\Formatter\Simple', $formatter);
	}
	
	public function testFactoryStreamArrayObject() {
		$options = new \ArrayObject(
			array('simple' => array())
		);
		$formatter = \Mu\Core\Log\Formatter::factory($options);
		$this->assertType('\Mu\Core\Log\Formatter\Simple', $formatter);
	}
}