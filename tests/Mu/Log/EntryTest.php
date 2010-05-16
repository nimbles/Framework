<?php
namespace Tests\Mu\Log;
require_once 'PHPUnit/Framework.php';

/**
 * Entry Tests
 * @author rob
 *
 */
class EntryTest extends \PHPUnit_Framework_TestCase {
	public function testConstructJustMessage() {
		$entry = new \Mu\Log\Entry('Hello world');
		
		$this->assertEquals('Hello world', $entry->getOption('message'));
		$this->assertEquals(getmypid(), $entry->getOption('pid'));
		$this->assertEquals(LOG_INFO, $entry->getOption('level'));
		$this->assertNull($entry->getOption('category'));
	}
	
	public function testConstructArray() {
		$ts = new \Mu\DateTime();
		
		$entry = new \Mu\Log\Entry(array(
			'message' => 'Hello world',
			'timestamp' => $ts,
			'extra' => 'test'
		));
		
		$this->assertEquals('Hello world', $entry->getOption('message'));
		$this->assertEquals(getmypid(), $entry->getOption('pid'));
		$this->assertEquals(LOG_INFO, $entry->getOption('level'));
		$this->assertEquals($ts, $entry->getOption('timestamp'));
		$this->assertNull($entry->getOption('category'));
		$this->assertEquals('test', $entry->getOption('extra'));
	}
}