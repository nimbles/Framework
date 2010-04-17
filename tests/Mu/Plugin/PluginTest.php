<?php
namespace Tests\Mu\Plugin;
require_once 'PHPUnit/Framework.php';
require_once 'PluginMock.php';

/**
 * Plugin Tests
 * @author rob
 *
 */
class PluginTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Tests that the plugin system implements the observer pattern
	 * @return void
	 */
	public function testPluginsAreUpdated() {
		$plugin = $this->getMock('\Tests\Mu\Plugin\PluginObserver', array('update'));
		$plugin->expects($this->once())
			->method('update')
			->with($this->equalTo(true));
			
		$plugins = new \Mu\Plugin();
		$plugins->attach('plugin', $plugin);
		
		$plugins->notify(true);
	}
	
	/**
	 * Tests that the plugin class provides accesses methods for the plugins
	 * @return void
	 */
	public function testPluginAccesses() {
		$plugins = new \Mu\Plugin();
		$plugins->plugin = new PluginSingle();
		
		$this->assertType('\Tests\Mu\Plugin\PluginSingle', $plugins->plugin);
		$this->assertTrue(isset($plugins->plugin));
		unset($plugins->plugin);
		$this->assertFalse(isset($plugins->plugin));
	}
	
	/**
	 * Tests the plugins system rejects plugins which do not extend a given abstract
	 * @return void
	 */
	public function testPluginOptionsInvalidAbstract() {
		$plugins = new \Mu\Plugin(array(
			'abstract' => '\Tests\Mu\Plugin\PluginAbstract'
		));
		
		$plugins->attach('plugin', new PluginConcrete());
		$this->assertType('\Tests\Mu\Plugin\PluginAbstract', $plugins->getPlugin('plugin'));
		
		$this->setExpectedException('\Mu\Plugin\Exception\InvalidAbstract');
		$plugins->plugin = new PluginSingle();
	}
	
	/**
	 * Tests the plugins system rejects plugins which do not implement a given interface
	 * @return void
	 */
	public function testPluginOptionsInvalidInterface() {
		$plugins = new \Mu\Plugin(array(
			'interface' => '\Tests\Mu\Plugin\IPlugin'
		));
		
		$plugins->attach('plugin', new PluginImplementor());
		$this->assertType('\Tests\Mu\Plugin\IPlugin', $plugins->getPlugin('plugin'));
		
		$this->setExpectedException('\Mu\Plugin\Exception\InvalidInterface');
		$plugins->plugin = new PluginSingle();
	}
	
	/**
	 * Tests loading a plugin by a string
	 * @return void
	 */
	public function testPluginLoadingByString() {
		$plugins = new \Mu\Plugin();
		$plugins->attach('plugin', '\Tests\Mu\Plugin\PluginSingle');
		$this->assertType('\Tests\Mu\Plugin\PluginSingle', $plugins->getPlugin('plugin'));
	}
	
	/**
	 * Tests plugin not found when loading by string
	 * @return void
	 */
	public function testPluginNotFound() {
		$plugins = new \Mu\Plugin();
		$this->setExpectedException('\Mu\Plugin\Exception\PluginNotFound');
		
		$plugins->attach('plugin', '\Tests\Mu\Plugin\MissingPlugin');
	}
}