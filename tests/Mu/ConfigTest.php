<?php
namespace Tests\Mu;
require_once 'PHPUnit/Framework.php';

class ConfigTest extends \PHPUnit_Framework_TestCase {
	protected $_testData;
	
	public function setUp() {
		$this->_testData = array(
			'a' => 1,
			'b' => 2,
			'c' => 3,
			'd' => array(
				'e' => 4,
				'f' => 5,
				'g' => array(
					'h' => 6
				)
			)
		);
	}
	
	public function testConstructWithNoParameters() {
		$config = new \Mu\Config();
		$this->assertType('\Mu\Config', $config);
	}
	
	public function testConstructWithEmptyArray() {
		$config = new \Mu\Config(array());
		$this->assertType('\Mu\Config', $config);
	}
	
	public function testConstructWithNonArray() {
		$this->setExpectedException('\Mu\Config\Exception\InvalidConfig');
		$config = new \Mu\Config('test');
	}
	
	public function testConstructWithPopulatedArray() {
		$config = new \Mu\Config($this->_testData);
		$this->assertType('\Mu\Config', $config);
	}
	
	public function testAccesses() {
		$config = new \Mu\Config($this->_testData);
		$this->assertType('\Mu\Config', $config);
		
		$this->assertEquals(1, $config->a);
		$this->assertEquals(2, $config->b);
		$this->assertEquals(3, $config->c);
		$this->assertType('\Mu\Config', $config->d);
		$this->assertEquals(4, $config->d->e);
		$this->assertEquals(4, $config->{'d.e'});
		$this->assertEquals(5, $config->d->f);
		$this->assertEquals(5, $config->{'d.f'});
		$this->assertType('\Mu\Config', $config->d->g);
		$this->assertType('\Mu\Config', $config->{'d.g'});
		$this->assertEquals(6, $config->d->g->h);
		$this->assertEquals(6, $config->{'d.g.h'});
		$this->assertNull($config->e);
	}
	
	public function testGetConfig() {
		$config = new \Mu\Config($this->_testData);
		$this->assertType('\Mu\Config', $config);
		
		$this->assertEquals(1, $config->getConfig('a'));
		$this->assertEquals(2, $config->getConfig('b'));
		$this->assertEquals(3, $config->getConfig('c'));
		$this->assertType('\Mu\Config', $config->getConfig('d'));
		$this->assertEquals(4, $config->getConfig('d.e'));
		$this->assertEquals(5, $config->getConfig('d.f'));
		$this->assertType('\Mu\Config', $config->getConfig('d.g'));
		$this->assertEquals(6, $config->getConfig('d.g.h'));
		$this->assertNull($config->getConfig('e'));
	}
}