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
 * @package   Mu\Cli\Request
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Cli
 */

namespace Tests\Mu\Cli;

/**
 * @category  Mu
 * @package   Mu\Cli\Request
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Cli
 */
class RequestTest extends \Mu\Cli\TestCase {
	/**
	 * Tests the stdin for an Cli Request
	 * @return void
	 */
	public function testStdin() {
		self::setStdin('hello world');

		$request = new \Mu\Cli\Request();
		$this->assertType('Mu\Core\Request\RequestAbstract', $request);
		$this->assertEquals('hello world', $request->getStdin());
	}
}