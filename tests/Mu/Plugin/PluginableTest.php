<?php
namespace Tests\Mu\Plugin;
require_once 'PHPUnit/Framework.php';
require_once 'PluginMock.php';

/**
 * Pluginable Tests
 * @author rob
 *
 */
class PluginableTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Tests that the pluginable mixin adds a plugins property that behaves as expected
	 * @return true
	 */
	public function testMixnProperties() {
		$pluginable = new PluginableMock();
		$this->assertType('\Mu\Plugin', $pluginable->plugins);
		
		$pluginable->plugins->plugin = new PluginConcrete();
		$this->assertType('\Tests\Mu\Plugin\PluginAbstract', $pluginable->plugins->plugin);
		
		$this->setExpectedException('\Mu\Plugin\Exception\InvalidAbstract');
		$pluginable->plugins->plugin = new PluginSingle();
	}
	
	/**
	 * Tests that the pluginable mixin adds attach and detach methods that behave as expected
	 * @return void
	 */
	public function testMixinMethods() {
		$pluginable = new PluginableMock();
		$pluginable->attach('plugin', new PluginConcrete());
		$this->assertType('\Tests\Mu\Plugin\PluginConcrete', $pluginable->plugins->plugin);
		$pluginable->detach('plugin');
		
		$this->assertFalse(isset($pluginable->plugins->plugin));
	}
	
	/**
	 * Tests that a pluginable is a subject and the plugins observe it
	 * @return void
	 */
	public function testMixinObserver() {
		$pluginable = new PluginableMock();
		
		$plugin = $this->getMock('\Tests\Mu\Plugin\PluginObserver', array('update'));
		$plugin->expects($this->once())
			->method('update')
			->with($this->equalTo($pluginable));
			
		
		$pluginable->attach('plugin', $plugin);
		$pluginable->notify();
	}
}