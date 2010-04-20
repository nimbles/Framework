<?php
namespace Tests\Mu\Log\Formatter;
require_once 'PHPUnit/Framework.php';

/**
 * Simple Tests
 * @author rob
 *
 */
class SimpleTest extends \PHPUnit_Framework_TestCase {
	protected $_entry;
	
	public function setUp() {
		$this->_entry = new \Mu\Log\Entry('This is a test message');
	}
	
	public function testConstructNoParams() {
		$formatter = new \Mu\Log\Formatter\Simple();
		$this->assertEquals(
			sprintf('%s %d INFO - uncategorised - This is a test message',
				$this->_entry->getOption('timestamp')->format(\Mu\DateTime::ISO8601), getmypid())
			, $formatter->format($this->_entry));
	}
}