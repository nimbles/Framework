<?php
/**
 * Mu Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://mu-framework.com/license/mit
 *
 * @category  Mu
 * @package   \Mu\Cli\Request
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     \Mu\Cli
 */

namespace Tests\Mu\Cli;

/**
 * @category  Mu
 * @package   \Mu\Cli\Request
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     \Mu\Cli
 */
class RequestTest extends \Mu\Cli\TestCase {
    /**
     * Tests the body for an Cli Request
     * @return void
     */
    public function testBody() {
        $this->setInput('hello world');

        $request = $this->createRequest();
        $this->assertType('Mu\Core\Request\RequestAbstract', $request);
        $this->assertEquals('hello world', $request->getBody());
    }
}
