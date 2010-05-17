<?php
namespace Tests\Mu\Log;
require_once 'PHPUnit/Framework.php';

/**
 * Log Tests
 * @author rob
 *
 */
class LogTest extends \PHPUnit_Framework_TestCase {
	public function testGetInstance() {
		$instance = \Mu\Log::getInstance();
		$this->assertType('\Mu\Log', $instance);
	}
	
	public function testAddWriterByAttach() {
		$instance = new \Mu\Log();
		
		$writer = new \Mu\Log\Writer\Mock(array(
			'formatter' => array(
				'simple' => array(
					'format' => '%message%'
				)
			)
		));
		
		$instance->attach('writers', 'mock', $writer);
		$this->assertEquals($writer, $instance->plugins->writers->mock);
		
		$instance->write('Hello world');
		$entries = $writer->getEntries();
		
		$this->assertEquals('Hello world', $entries[0]);
	}
	
	public function testAddWriterBySetter() {
		$instance = new \Mu\Log();
		
		$writer = new \Mu\Log\Writer\Mock(array(
			'formatter' => array(
				'simple' => array(
					'format' => '%message%'
				)
			)
		));
		
		$instance->plugins->writers->mock = $writer;
		$this->assertEquals($writer, $instance->plugins->writers->mock);
		
		$instance->write('Hello world');
		$entries = $writer->getEntries();
		
		$this->assertEquals('Hello world', $entries[0]);
	}
	
	public function testMultipleWritersSameFormat() {
		$instance = new \Mu\Log();
		
		$instance->plugins->writers->mock1 = new \Mu\Log\Writer\Mock(array(
			'formatter' => array(
				'simple' => array(
					'format' => '%message%'
				)
			)
		));
		
		$instance->plugins->writers->mock2 = new \Mu\Log\Writer\Mock(array(
			'formatter' => array(
				'simple' => array(
					'format' => '%message%'
				)
			)
		));
		
		$instance->write('Hello world');
		
		$entries1 = $instance->plugins->writers->mock1->getEntries();
		$this->assertEquals('Hello world', $entries1[0]);
		
		$entries2 = $instance->plugins->writers->mock2->getEntries();
		$this->assertEquals('Hello world', $entries2[0]);
	}
	
	public function testMultipleWritersDifferentFormat() {
		$instance = new \Mu\Log();
		
		$instance->plugins->writers->mock1 = new \Mu\Log\Writer\Mock(array(
			'formatter' => array(
				'simple' => array(
					'format' => '%message%'
				)
			)
		));
		
		$instance->plugins->writers->mock2 = new \Mu\Log\Writer\Mock(array(
			'formatter' => array(
				'simple' => array(
					'format' => '%pid% - %message%'
				)
			)
		));
		
		$instance->write('Hello world');
		
		$entries1 = $instance->plugins->writers->mock1->getEntries();
		$this->assertEquals('Hello world', $entries1[0]);
		
		$entries2 = $instance->plugins->writers->mock2->getEntries();
		$this->assertEquals(getmypid() . ' - Hello world', $entries2[0]);
	}
}