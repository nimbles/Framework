<?php
/**
 * Nimbles Framework
 *
 * LICENSE
 *
 * This shouce file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://nimbl.es/license/mit
 *
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Cli;

use Nimbles\Cli\TestCase;

/**
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Cli\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Cli
 * @group      Nimbles-Cli-Response
 */
class ResponseTest extends TestCase {
    /**
     * Tests the body is given from the options
     * @return void
     */
    public function testBodyFromOptions() {
        $response = $this->createResponse(array(
            'body' => 'hello world'
        ));

        $response->send();

        $this->assertType('Nimbles\Core\Response\ResponseAbstract', $response);
        $this->assertEquals('hello world', $this->getOutput());
        $this->assertEquals('hello world', $response->getBody());
        $this->assertEquals('hello world', $response->body);
    }

    /**
     * Tests the body is given from the setter
     * @return void
     */
    public function testBodyFromSetter() {
        $response = $this->createResponse();
        $response->setBody('hello world');

        $response->send();

        $this->assertType('Nimbles\Core\Response\ResponseAbstract', $response);
        $this->assertEquals('hello world', $this->getOutput());
    }

    /**
     * Tests the body is given from accesses
     * @return void
     */
    public function testBodyFromAccesses() {
        $response = $this->createResponse();
        $response->body = 'hello world';

        $response->send();

        $this->assertType('Nimbles\Core\Response\ResponseAbstract', $response);
        $this->assertEquals('hello world', $this->getOutput());
    }
}