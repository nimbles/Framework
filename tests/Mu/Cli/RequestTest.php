<?php
namespace Tests\Mu\Cli;

/**
 * Request Tests
 * @author rob
 *
 */
class RequestTest extends \Mu\Cli\TestCase {
	public function testStdin() {
		self::setStdin('hello world');

		$request = new \Mu\Cli\Request();
		$this->assertType('Mu\Core\Request', $request);
		$this->assertEquals('hello world', $request->getStdin());
	}
}