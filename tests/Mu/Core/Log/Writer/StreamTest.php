<?php
namespace Tests\Mu\Core\Log\Writer;
require_once 'PHPUnit/Framework.php';
require_once '_files/GlobalStream.php';

/**
 * Stream Tests
 * @author rob
 *
 */
class StreamTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Log Entry
	 * @var \Mu\Core\Log\Entry
	 */
	protected $_entry;
	
	/**
	 * Rewriters a stream writer
	 * @return void
	 */
	public static function setUpBeforeClass() {
		stream_wrapper_register('global', 'Tests\Mu\Core\Log\Writer\GlobalStream');
	}
	
	/**
	 * Creates the log entry
	 * @return void
	 */
	public function setUp() {
		$this->_entry = new \Mu\Core\Log\Entry('This is a test message');
	}
	
	/**
	 * Tests writing to a stream
	 * @return void
	 */
	public function testWrite() {
		global $stream;
		
		$stream = '';
		
		$writer = new \Mu\Core\Log\Writer\Stream(array(
			'stream' => 'global://stream',
			'formatter' => array(
				'simple' => array(
					'format' => '%message%'
				)
			)
		));
		
		$writer->write($this->_entry);
		$this->assertEquals("This is a test message\n", $stream);
	}
	
	public function testNoStreamOption() {
		$this->setExpectedException('Mu\Core\Log\Writer\Exception\MissingStreamOption');
		
		$writer = new \Mu\Core\Log\Writer\Stream();
		$writer->write($this->_entry);
	}
}