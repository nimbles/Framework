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
		$this->assertType('\Mu\Plugin\Plugins', $pluginable->plugins);
		$this->assertType('\Mu\Plugin', $pluginable->plugins->simple);
		$this->assertType('\Mu\Plugin', $pluginable->plugins->restricted);
		
		$pluginable->plugins->simple->plugin = new PluginSingle();
		$this->assertType('\Tests\Mu\Plugin\PluginSingle', $pluginable->plugins->simple->plugin);
		
		$pluginable->plugins->restricted->plugin = new PluginConcrete();
		$this->assertType('\Tests\Mu\Plugin\PluginAbstract', $pluginable->plugins->restricted->plugin);
		
		$this->setExpectedException('\Mu\Plugin\Exception\InvalidAbstract');
		$pluginable->plugins->restricted->plugin = new PluginSingle();
	}
	
	/**
	 * Tests that the pluginable mixin adds attach and detach methods that behave as expected
	 * @return void
	 */
	public function testMixinMethods() {
		$pluginable = new PluginableMock();
		$pluginable->attach('restricted', 'plugin', new PluginConcrete());
		$this->assertType('\Tests\Mu\Plugin\PluginAbstract', $pluginable->plugins->restricted->plugin);
		$pluginable->detach('restricted', 'plugin');
		
		$this->assertFalse(isset($pluginable->plugins->restricted->plugin));
	}
	
	/**
	 * Tests that a pluginable is a subject and the plugins observe it
	 * @return void
	 */
	public function testMixinObserver() {
		$pluginable = new PluginableMock();
		
		$plugin = $this->getMock('\Tests\Mu\Plugin\PluginObserver', array('update'));
		$plugin->expects($this->exactly(4))
			->method('update')
			->with($this->equalTo($pluginable));
			
		
		$pluginable->attach('restricted', 'plugin', $plugin);
		$pluginable->attach('simple', 'plugin', $plugin);
		
		$pluginable->notify('restricted');
		$pluginable->notify('simple');
		$pluginable->notify();
	}
}