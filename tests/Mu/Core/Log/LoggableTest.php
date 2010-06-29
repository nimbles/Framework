<?php
namespace Tests\Mu\Core\Log;

require_once 'LoggableMock.php';

/**
 * Log Tests
 * @author rob
 *
 */
class LoggableTest extends \Mu\Core\TestCase {
	public function testMixinMethods() {
		$instance = \Mu\Core\Log::getInstance();
		$writer = new \Mu\Core\Log\Writer\Mock(array(
			'formatter' => array(
				'simple' => array(
					'format' => '%category% - %message%'
				)
			)
		));
		$instance->plugins->writers->mock = $writer;
		
		$loggable = new LoggableMock();
		$loggable->log('Hello world');
		$loggable->log(new \Mu\Core\Log\Entry(array(
			'message' => 'Hello world',
			'category' => 'test'
		)));
		
		$entries = $writer->getEntries();
		$this->assertEquals('uncategorised - Hello world', $entries[0]);
		$this->assertEquals('test - Hello world', $entries[1]);
	}
}