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
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Cli;

use Mu\Cli\TestCase;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Cli\TestCase
 *
 * @group      Mu
 * @group      Mu-Cli
 * @group      Mu-Cli-Request
 */
class RequestTest extends TestCase {
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
