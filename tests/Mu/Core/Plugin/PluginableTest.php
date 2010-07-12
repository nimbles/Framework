<?php
namespace Tests\Mu\Core\Plugin;

require_once 'PluginMock.php';
require_once 'PluginableMock.php';

/**
 * Pluginable Tests
 * @author rob
 *
 */
class PluginableTest extends \Mu\Core\TestCase {
	/**
	 * Tests that the pluginable mixin adds a plugins property that behaves as expected
	 * @return true
	 */
	public function testMixnProperties() {
		$pluginable = new PluginableMock();
		//$this->assertType('\Mu\Core\Plugin\Plugins', $pluginable->plugins);
		
		$this->assertType('\Mu\Core\Plugin', $pluginable->simple);
		$this->assertType('\Mu\Core\Plugin', $pluginable->restricted);
		
		$pluginable->simple->plugin = new PluginSingle();
		$this->assertType('\Tests\Mu\Core\Plugin\PluginSingle', $pluginable->simple->plugin);
		
		$pluginable->restricted->plugin = new PluginConcrete();
		$this->assertType('\Tests\Mu\Core\Plugin\PluginAbstract', $pluginable->restricted->plugin);
		
		$this->setExpectedException('\Mu\Core\Plugin\Exception\InvalidAbstract');
		$pluginable->restricted->plugin = new PluginSingle();
	}
	
	/**
	 * Tests that the pluginable mixin adds attach and detach methods that behave as expected
	 * @return void
	 */
	public function testMixinMethods() {
		$pluginable = new PluginableMock();
		$pluginable->attach('restricted', 'plugin', new PluginConcrete());
		$this->assertType('\Tests\Mu\Core\Plugin\PluginAbstract', $pluginable->restricted->plugin);
		$pluginable->detach('restricted', 'plugin');
		
		$this->assertFalse(isset($pluginable->plugins->restricted->plugin));
	}
	
	/**
	 * Tests that a pluginable is a subject and the plugins observe it
	 * @return void
	 */
	public function testMixinObserver() {
		$pluginable = new PluginableMock();
		
		$plugin = $this->getMock('\Tests\Mu\Core\Plugin\PluginObserver', array('update'));
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