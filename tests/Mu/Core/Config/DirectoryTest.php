<?php
namespace Tests\Mu\Core\Config;


/**
 * Directory Tests
 * @author rob
 *
 */
class DirectoryTest extends \Mu\Core\TestCase {
	/**
	 * Tests reading a directory of config files for level 1
	 * @return void
	 */
	public function testLoadConfigFileLevel1() {
		$dir = new \Mu\Core\Config\Directory(dirname(__FILE__) . '/_files/', 'level1');
		
		$config = $dir->getParsedConfig();
		$this->assertType('\Mu\Core\Config', $config);
		
		$this->assertEquals(1, $config->config->a);
		$this->assertEquals(4, $config->config->d->e);
		$this->assertEquals(null, $config->config->j);
		
		$this->assertEquals(1, $config->additional->a);
		$this->assertEquals(2, $config->additional->b);
		$this->assertEquals(null, $config->additional->c);
	}
	
	/**
	 * Tests reading a directory of config files for level 2 extending level 1
	 * @return void
	 */
	public function testLoadConfigFileLevel2() {
		$dir = new \Mu\Core\Config\Directory(dirname(__FILE__) . '/_files/', 'level2');
		
		$config = $dir->getParsedConfig();
		$this->assertType('\Mu\Core\Config', $config);
		
		$this->assertEquals('one', $config->config->a);
		$this->assertEquals('four', $config->config->d->e);
		$this->assertEquals(null, $config->config->j);
		
		$this->assertEquals('one', $config->additional->a);
		$this->assertEquals('two', $config->additional->b);
		$this->assertEquals(null, $config->additional->c);
	}
	
	/**
	 * Tests reading a directory of config files for level 3 extending level 2
	 * @return void
	 */
	public function testLoadConfigFileLevel3() {
		$dir = new \Mu\Core\Config\Directory(dirname(__FILE__) . '/_files/', 'level3');
		
		$config = $dir->getParsedConfig();
		$this->assertType('\Mu\Core\Config', $config);
		
		$this->assertEquals('one', $config->config->a);
		$this->assertEquals('four', $config->config->d->e);
		$this->assertEquals(8, $config->config->j);
		
		$this->assertEquals('one', $config->additional->a);
		$this->assertEquals('two', $config->additional->b);
		$this->assertEquals(3, $config->additional->c);
	}
}