<?php
/**
 * Nimbles Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://nimbl.es/license/mit
 *
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Cli;

use Nimbles\Cli\TestCase;

/**
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Cli\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Cli
 * @group      Nimbles-Cli-Request
 */
class RequestTest extends TestCase {
    /**
     * Tests the body for an Cli Request
     * @return void
     */
    public function testBody() {
        $this->setInput('hello world');

        $request = $this->createRequest();
        $this->assertInstanceOf('Nimbles\Core\Request\RequestAbstract', $request);
        $this->assertEquals('hello world', $request->getBody());
        $this->assertEquals('hello world', $request->body);
    }
}
