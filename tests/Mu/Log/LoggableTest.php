<?php
namespace Tests\Mu\Log;
require_once 'PHPUnit/Framework.php';
require_once 'LoggableMock.php';

/**
 * Log Tests
 * @author rob
 *
 */
class LoggableTest extends \PHPUnit_Framework_TestCase {
	public function testMixinMethods() {
		$instance = \Mu\Log::getInstance();
		$writer = new \Mu\Log\Writer\Mock(array(
			'formatter' => array(
				'simple' => array(
					'format' => '%category% - %message%'
				)
			)
		));
		$instance->plugins->writers->mock = $writer;
		
		$loggable = new LoggableMock();
		$loggable->log('Hello world');
		$loggable->log(new \Mu\Log\Entry(array(
			'message' => 'Hello world',
			'category' => 'test'
		)));
		
		$entries = $writer->getEntries();
		$this->assertEquals('uncategorised - Hello world', $entries[0]);
		$this->assertEquals('test - Hello world', $entries[1]);
	}
}