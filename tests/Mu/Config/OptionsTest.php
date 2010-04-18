<?php
namespace Tests\Mu\Config;
require_once 'PHPUnit/Framework.php';
require_once 'ConfigurableMock.php';
require_once 'OptionsMock.php';

/**
 * Options Tests
 * @author rob
 *
 */
class OptionsTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Tests the mixin properties are created and behave properly
	 * @return void
	 */
	public function testMixinProperties() {
		$mock = new OptionsMock();
		$this->assertType('\Mu\Config', $mock->config);
		
		$mock->config->a = 1;
		$this->assertEquals(1, $mock->config->a);
	}
	
	/**
	 * Tests the mixin methods are created and behave properly
	 * @return void
	 */
	public function testMixinMethods() {
		$mock = new OptionsMock();
		
		$mock->setOption('b', 2);
		$this->assertEquals(2, $mock->getOption('b'));
		
		$this->assertEquals('test', $mock->getOption('test'));
		$mock->setOption('test', 'test2');
		$this->assertEquals('test2', $mock->getOption('test'));
		
		$mock->setOptions(array(
			'test' => 'test3',
			'c' => 3
		));
		
		$this->assertEquals('test3', $mock->getOption('test'));
		$this->assertEquals(3, $mock->getOption('c'));
	}
}