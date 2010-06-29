<?php
namespace Tests\Mu\Core\Log\Writer;

require_once '_files/GlobalStream.php';

/**
 * Stream Tests
 * @author rob
 *
 */
class MockTest extends \Mu\Core\TestCase {	
	public function testGetEntries() {
		$writer = new \Mu\Core\Log\Writer\Mock(array(
			'formatter' => array(
				'simple' => array(
					'format' => '%message%'
				)
			)
		));
		
		$this->assertType('array', $writer->getEntries());
	}
	
	/**
	 * Tests writing to a stream
	 * @return void
	 */
	public function testWrite() {
		$writer = new \Mu\Core\Log\Writer\Mock(array(
			'formatter' => array(
				'simple' => array(
					'format' => '%message%'
				)
			)
		));
		
		$writer->write(new \Mu\Core\Log\Entry('This is a test message 1'));
		$writer->write(new \Mu\Core\Log\Entry('This is a test message 2'));
		$entries = $writer->getEntries();
		
		$this->assertEquals('This is a test message 1', $entries[0]);
		$this->assertEquals('This is a test message 2', $entries[1]);
	}
}