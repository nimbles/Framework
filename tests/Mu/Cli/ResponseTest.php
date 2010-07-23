<?php
/**
 * Mu Framework
 *
 * LICENSE
 *
 * This shouce file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://mu-framework.com/license/mit
 *
 * @category  Mu
 * @package   Mu\Cli\Response
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Cli
 */

namespace Tests\Mu\Cli;

/**
 * @category  Mu
 * @package   Mu\Cli\Response
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Cli
 */
class ResponseTest extends \Mu\Cli\TestCase {
	/**
	 * Tests the stdout is given from the options
	 * @return void
	 */
	public function testStdoutFromOptions() {
		$response = new \Mu\Cli\Response(array(
			'body' => 'hello world'
		));
		$response->send();

		$this->assertType('Mu\Core\Response\ResponseAbstract', $response);
		$this->assertEquals('hello world', self::getStdout());
		$this->assertEquals('hello world', $response->getBody());
	}

	/**
	 * Tests the stdout is given from the setter
	 * @return void
	 */
	public function testStdoutFromSetter() {
		$response = new \Mu\Cli\Response();
		$response->setBody('hello world');

		$response->send();

		$this->assertType('Mu\Core\Response\ResponseAbstract', $response);
		$this->assertEquals('hello world', self::getStdout());
		$this->assertEquals('hello world', $response->getBody());
	}
}