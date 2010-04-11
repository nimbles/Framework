<?php
namespace Tests\Mu\Config;
require_once 'PHPUnit/Framework.php';

/**
 * File Tests
 * @author rob
 *
 */
class FileTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Test reading a config file for level 1
	 * @return void
	 */
	public function testLoadConfigFileLevel1() {
		$file = new \Mu\Config\File(dirname(__FILE__) . '/_files/config.php', 'level1');
		
		$config = $file->getParsedConfig();
		$this->assertType('\Mu\Config', $config);
		
		$this->assertEquals(1, $config->config->a);
		$this->assertEquals(4, $config->config->d->e);
		$this->assertEquals(null, $config->config->j);
	}
	
	/**
	 * Tests reading a config file for level 2 extending level 1
	 * @return void
	 */
	public function testLoadConfigFileLevel2() {
		$file = new \Mu\Config\File(dirname(__FILE__) . '/_files/config.php', 'level2');
		
		$config = $file->getParsedConfig();
		$this->assertType('\Mu\Config', $config);
		
		$this->assertEquals('one', $config->config->a);
		$this->assertEquals('four', $config->config->d->e);
		$this->assertEquals(null, $config->config->j);
	}
	
	/**
	 * Tests reading a config file for level 3 extending level 2
	 * @return void
	 */
	public function testLoadConfigFileLevel3() {
		$file = new \Mu\Config\File(dirname(__FILE__) . '/_files/config.php', 'level3');
		
		$config = $file->getParsedConfig();
		$this->assertType('\Mu\Config', $config);
		
		$this->assertEquals('one', $config->config->a);
		$this->assertEquals('four', $config->config->d->e);
		$this->assertEquals(8, $config->config->j);
	}
}