<?php
namespace Tests\Mu\Core\Plugin;

require_once 'PluginMock.php';

/**
 * Plugins Tests
 * @author rob
 *
 */
class PluginsTest extends \Mu\Core\TestCase {
	public function testSingleSimpleType() {
		$plugins = new \Mu\Core\Plugin\Plugins(array(
			'types' => array(
				'helpers'
			)
		));
		
		$this->assertType('\Mu\Core\Plugin', $plugins->getType('helpers'));
		$this->assertType('\Mu\Core\Plugin', $plugins->helpers);
		$this->assertTrue(isset($plugins->helpers));
		
		$plugins->helpers->attach('simple', new PluginSingle());
	}
	
	public function testSingleRestrictedType() {
		$plugins = new \Mu\Core\Plugin\Plugins(array(
			'types' => array(
				'helpers' => array(
					'abstract' => '\Tests\Mu\Core\Plugin\PluginAbstract',
				)
			)
		));
		
		$this->assertType('\Mu\Core\Plugin', $plugins->getType('helpers'));
		$this->assertType('\Mu\Core\Plugin', $plugins->helpers);
		$this->assertTrue(isset($plugins->helpers));
		
		$plugins->helpers->attach('concrete', new PluginConcrete());
		
		$this->setExpectedException('\Mu\Core\Plugin\Exception\InvalidAbstract');
		$plugins->helpers->attach('simple', new PluginSingle());
	}
	
	public function testMultipleTypes() {
		$plugins = new \Mu\Core\Plugin\Plugins(array(
			'types' => array(
				'simple',
				'helpers' => array(
					'abstract' => '\Tests\Mu\Core\Plugin\PluginAbstract',
				)
			)
		));
		
		$this->assertType('\Mu\Core\Plugin', $plugins->getType('simple'));
		$this->assertType('\Mu\Core\Plugin', $plugins->simple);
		$this->assertTrue(isset($plugins->helpers));
		$plugins->simple->attach('simple', new PluginSingle());
		
		$this->assertType('\Mu\Core\Plugin', $plugins->getType('helpers'));
		$this->assertType('\Mu\Core\Plugin', $plugins->helpers);
		$this->assertTrue(isset($plugins->simple));
		
		$plugins->helpers->attach('concrete', new PluginConcrete());
		
		$this->setExpectedException('\Mu\Core\Plugin\Exception\InvalidAbstract');
		$plugins->helpers->attach('simple', new PluginSingle());
	}
}