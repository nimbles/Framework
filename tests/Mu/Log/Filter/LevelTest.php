<?php
namespace Tests\Mu\Log\Filter;
require_once 'PHPUnit/Framework.php';

/**
 * Level Filter Tests
 * @author rob
 *
 */
class LevelTest extends \PHPUnit_Framework_TestCase {
	public function testIncludeSingle() {
		$filter = new \Mu\Log\Filter\Level(array(
			'type' => \Mu\Log\Filter\Level::LEVEL_INCLUDE,
			'level' => LOG_NOTICE
		));
		
		$this->assertTrue($filter->apply(new \Mu\Log\Entry(array(
			'message' => 'This is a test message',
			'level' => LOG_NOTICE
		))));
		
		$this->assertFalse($filter->apply(new \Mu\Log\Entry(array(
			'message' => 'This is a test message',
			'level' => LOG_INFO
		))));
	}
	
	public function testExcludeSingle() {
		$filter = new \Mu\Log\Filter\Level(array(
			'type' => \Mu\Log\Filter\Level::LEVEL_EXCLUDE,
			'level' => LOG_NOTICE
		));
		
		$this->assertTrue($filter->apply(new \Mu\Log\Entry(array(
			'message' => 'This is a test message',
			'level' => LOG_INFO
		))));
		
		$this->assertFalse($filter->apply(new \Mu\Log\Entry(array(
			'message' => 'This is a test message',
			'level' => LOG_NOTICE
		))));
	}
	
	public function testIncludeArray() {
		$filter = new \Mu\Log\Filter\Level(array(
			'type' => \Mu\Log\Filter\Level::LEVEL_INCLUDE,
			'level' => array(LOG_INFO, LOG_NOTICE, LOG_CRIT)
		));
		
		$this->assertTrue($filter->apply(new \Mu\Log\Entry(array(
			'message' => 'This is a test message',
			'level' => LOG_INFO
		))));
		
		$this->assertTrue($filter->apply(new \Mu\Log\Entry(array(
			'message' => 'This is a test message',
			'level' => LOG_NOTICE
		))));
		
		$this->assertTrue($filter->apply(new \Mu\Log\Entry(array(
			'message' => 'This is a test message',
			'level' => LOG_CRIT
		))));
		
		$this->assertFalse($filter->apply(new \Mu\Log\Entry(array(
			'message' => 'This is a test message',
			'level' => LOG_DEBUG
		))));
		
		$this->assertFalse($filter->apply(new \Mu\Log\Entry(array(
			'message' => 'This is a test message',
			'level' => LOG_WARNING
		))));
		
		$this->assertFalse($filter->apply(new \Mu\Log\Entry(array(
			'message' => 'This is a test message',
			'level' => LOG_ERR
		))));
	}
	
	public function testExcludeArray() {
		$filter = new \Mu\Log\Filter\Level(array(
			'type' => \Mu\Log\Filter\Level::LEVEL_EXCLUDE,
			'level' => array(LOG_INFO, LOG_NOTICE, LOG_CRIT)
		));
		
		$this->assertFalse($filter->apply(new \Mu\Log\Entry(array(
			'message' => 'This is a test message',
			'level' => LOG_INFO
		))));
		
		$this->assertFalse($filter->apply(new \Mu\Log\Entry(array(
			'message' => 'This is a test message',
			'level' => LOG_NOTICE
		))));
		
		$this->assertFalse($filter->apply(new \Mu\Log\Entry(array(
			'message' => 'This is a test message',
			'level' => LOG_CRIT
		))));
		
		$this->assertTrue($filter->apply(new \Mu\Log\Entry(array(
			'message' => 'This is a test message',
			'level' => LOG_DEBUG
		))));
		
		$this->assertTrue($filter->apply(new \Mu\Log\Entry(array(
			'message' => 'This is a test message',
			'level' => LOG_WARNING
		))));
		
		$this->assertTrue($filter->apply(new \Mu\Log\Entry(array(
			'message' => 'This is a test message',
			'level' => LOG_ERR
		))));
	}
	
	public function testAbove() {
		$filter = new \Mu\Log\Filter\Level(array(
			'type' => \Mu\Log\Filter\Level::LEVEL_ABOVE,
			'level' => LOG_INFO
		));
		
		$this->assertTrue($filter->apply(new \Mu\Log\Entry(array(
			'message' => 'This is a test message',
			'level' => LOG_INFO
		))));
		
		$this->assertTrue($filter->apply(new \Mu\Log\Entry(array(
			'message' => 'This is a test message',
			'level' => LOG_NOTICE
		))));
		
		$this->assertFalse($filter->apply(new \Mu\Log\Entry(array(
			'message' => 'This is a test message',
			'level' => LOG_DEBUG
		))));
	}
	
	public function testBelow() {
		$filter = new \Mu\Log\Filter\Level(array(
			'type' => \Mu\Log\Filter\Level::LEVEL_BELOW,
			'level' => LOG_NOTICE
		));
		
		$this->assertTrue($filter->apply(new \Mu\Log\Entry(array(
			'message' => 'This is a test message',
			'level' => LOG_INFO
		))));
		
		$this->assertTrue($filter->apply(new \Mu\Log\Entry(array(
			'message' => 'This is a test message',
			'level' => LOG_NOTICE
		))));
		
		$this->assertFalse($filter->apply(new \Mu\Log\Entry(array(
			'message' => 'This is a test message',
			'level' => LOG_CRIT
		))));
	}
	
	/**
	 * @dataProvider invalidProvider
	 */
	public function testInvalid($type, $levels) {
		$this->setExpectedException('\Mu\Log\Filter\Exception\InvalidLevel');
		
		$filter = new \Mu\Log\Filter\Level(array(
			'type' => \Mu\Log\Filter\Level::LEVEL_ABOVE,
			'level' => -1
		));
		
		$filter->apply(new \Mu\Log\Entry(array(
			'message' => 'This is a test message',
			'level' => LOG_DEBUG
		)));
	}
	
	public function invalidProvider() {
		return array(
			array(\Mu\Log\Filter\Level::LEVEL_ABOVE, -1),
			array(\Mu\Log\Filter\Level::LEVEL_ABOVE, 8),
			array(\Mu\Log\Filter\Level::LEVEL_BELOW, -1),
			array(\Mu\Log\Filter\Level::LEVEL_BELOW, 8),
			array(\Mu\Log\Filter\Level::LEVEL_INCLUDE, -1),
			array(\Mu\Log\Filter\Level::LEVEL_INCLUDE, 8),
			array(\Mu\Log\Filter\Level::LEVEL_EXCLUDE, -1),
			array(\Mu\Log\Filter\Level::LEVEL_EXCLUDE, 8),
			array(\Mu\Log\Filter\Level::LEVEL_INCLUDE, array(-1, 8)),
			array(\Mu\Log\Filter\Level::LEVEL_EXCLUDE, array(-1, 8)),
		);
	}
}