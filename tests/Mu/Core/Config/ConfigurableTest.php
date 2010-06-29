<?php
namespace Tests\Mu\Core\Config;

require_once 'ConfigurableMock.php';

/**
 * Config Tests
 * @author rob
 *
 */
class ConfigurableTest extends \Mu\Core\TestCase {
	/**
	 * Tests the mixin properties are created and behave properly
	 * @return void
	 */
	public function testMixinProperties() {
		$mock = new ConfigurableMock();
		$this->assertType('\Mu\Core\Config', $mock->config);
		
		$mock->config->a = 1;
		$this->assertEquals(1, $mock->config->a);
	}
}