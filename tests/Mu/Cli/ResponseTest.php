<?php
namespace Tests\Mu\Cli;

/**
 * Response Tests
 * @author rob
 */
class ResponseTest extends \Mu\Cli\TestCase {
	public function testStdoutFromOptions() {
		$response = new \Mu\Cli\Response(array(
			'body' => 'hello world'
		));
		$response->send();

		$this->assertType('Mu\Core\Response\ResponseAbstract', $response);
		$this->assertEquals('hello world', self::getStdout());
		$this->assertEquals('hello world', $response->getBody());
	}

	public function testStdoutFromSetter() {
		$response = new \Mu\Cli\Response();
		$response->setBody('hello world');

		$response->send();

		$this->assertType('Mu\Core\Response\ResponseAbstract', $response);
		$this->assertEquals('hello world', self::getStdout());
		$this->assertEquals('hello world', $response->getBody());
	}
}