<?php
namespace Tests\Mu\Core\Log\Formatter;
require_once 'PHPUnit/Framework.php';

/**
 * Simple Tests
 * @author rob
 *
 */
class SimpleTest extends \PHPUnit_Framework_TestCase {
	protected $_entry;
	
	public function setUp() {
		$this->_entry = new \Mu\Core\Log\Entry('This is a test message');
	}
	
	public function testConstructNoParams() {
		$formatter = new \Mu\Core\Log\Formatter\Simple();
		$this->assertEquals(
			sprintf('%s %d INFO - uncategorised - This is a test message',
				$this->_entry->getOption('timestamp')->format(\Mu\Core\DateTime::ISO8601), getmypid())
			, $formatter->format($this->_entry));
	}
	
	public function testCustomFormat() {
		$formatter = new \Mu\Core\Log\Formatter\Simple(array(
			'format' => '%message%'
		));
		$this->assertEquals('This is a test message', $formatter->format($this->_entry));
	}
}