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
 * @package   \Mu\Cli\Response
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     \Mu\Cli
 */

namespace Tests\Mu\Cli;

/**
 * @category  Mu
 * @package   \Mu\Cli\Response
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     \Mu\Cli
 */
class ResponseTest extends \Mu\Cli\TestCase {
    /**
     * Tests the body is given from the options
     * @return void
     */
    public function testBodyFromOptions() {
        $response = $this->createResponse(array(
            'body' => 'hello world'
        ));

        $response->send();

        $this->assertType('Mu\Core\Response\ResponseAbstract', $response);
        $this->assertEquals('hello world', $this->getOutput());
        $this->assertEquals('hello world', $response->getBody());
    }

    /**
     * Tests the body is given from the setter
     * @return void
     */
    public function testBodyFromSetter() {
        $response = $this->createResponse();
        $response->setBody('hello world');

        $response->send();

        $this->assertType('Mu\Core\Response\ResponseAbstract', $response);
        $this->assertEquals('hello world', $this->getOutput());
        $this->assertEquals('hello world', $response->getBody());
    }
}