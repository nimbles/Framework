<?php
namespace Tests\Mu\Core\Config;


/**
 * File Tests
 * @author rob
 *
 */
class FileTest extends \Mu\Core\TestCase {
	/**
	 * Test reading a config file for level 1
	 * @return void
	 */
	public function testLoadConfigFileLevel1() {
		$file = new \Mu\Core\Config\File(dirname(__FILE__) . '/_files/config.php', 'level1');
		
		$config = $file->getParsedConfig();
		$this->assertType('\Mu\Core\Config', $config);
		
		$this->assertEquals(1, $config->config->a);
		$this->assertEquals(4, $config->config->d->e);
		$this->assertEquals(null, $config->config->j);
	}
	
	/**
	 * Tests reading a config file for level 2 extending level 1
	 * @return void
	 */
	public function testLoadConfigFileLevel2() {
		$file = new \Mu\Core\Config\File(dirname(__FILE__) . '/_files/config.php', 'level2');
		
		$config = $file->getParsedConfig();
		$this->assertType('\Mu\Core\Config', $config);
		
		$this->assertEquals('one', $config->config->a);
		$this->assertEquals('four', $config->config->d->e);
		$this->assertEquals(null, $config->config->j);
	}
	
	/**
	 * Tests reading a config file for level 3 extending level 2
	 * @return void
	 */
	public function testLoadConfigFileLevel3() {
		$file = new \Mu\Core\Config\File(dirname(__FILE__) . '/_files/config.php', 'level3');
		
		$config = $file->getParsedConfig();
		$this->assertType('\Mu\Core\Config', $config);
		
		$this->assertEquals('one', $config->config->a);
		$this->assertEquals('four', $config->config->d->e);
		$this->assertEquals(8, $config->config->j);
	}
}