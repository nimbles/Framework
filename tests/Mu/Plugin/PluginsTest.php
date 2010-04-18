<?php
namespace Tests\Mu\Plugin;
require_once 'PHPUnit/Framework.php';
require_once 'PluginMock.php';

/**
 * Plugins Tests
 * @author rob
 *
 */
class PluginsTest extends \PHPUnit_Framework_TestCase {
	public function testSingleSimpleType() {
		$plugins = new \Mu\Plugin\Plugins(array(
			'types' => array(
				'helpers'
			)
		));
		
		$this->assertType('\Mu\Plugin', $plugins->getType('helpers'));
		$this->assertType('\Mu\Plugin', $plugins->helpers);
		$this->assertTrue(isset($plugins->helpers));
		
		$plugins->helpers->attach('simple', new PluginSingle());
	}
	
	public function testSingleRestrictedType() {
		$plugins = new \Mu\Plugin\Plugins(array(
			'types' => array(
				'helpers' => array(
					'abstract' => '\Tests\Mu\Plugin\PluginAbstract',
				)
			)
		));
		
		$this->assertType('\Mu\Plugin', $plugins->getType('helpers'));
		$this->assertType('\Mu\Plugin', $plugins->helpers);
		$this->assertTrue(isset($plugins->helpers));
		
		$plugins->helpers->attach('concrete', new PluginConcrete());
		
		$this->setExpectedException('\Mu\Plugin\Exception\InvalidAbstract');
		$plugins->helpers->attach('simple', new PluginSingle());
	}
	
	public function testMultipleTypes() {
		$plugins = new \Mu\Plugin\Plugins(array(
			'types' => array(
				'simple',
				'helpers' => array(
					'abstract' => '\Tests\Mu\Plugin\PluginAbstract',
				)
			)
		));
		
		$this->assertType('\Mu\Plugin', $plugins->getType('simple'));
		$this->assertType('\Mu\Plugin', $plugins->simple);
		$this->assertTrue(isset($plugins->helpers));
		$plugins->simple->attach('simple', new PluginSingle());
		
		$this->assertType('\Mu\Plugin', $plugins->getType('helpers'));
		$this->assertType('\Mu\Plugin', $plugins->helpers);
		$this->assertTrue(isset($plugins->simple));
		
		$plugins->helpers->attach('concrete', new PluginConcrete());
		
		$this->setExpectedException('\Mu\Plugin\Exception\InvalidAbstract');
		$plugins->helpers->attach('simple', new PluginSingle());
	}
}