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
 * @package   Mu\Http\Response
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Mu\Http;

/**
 * @category  Mu
 * @package   Mu\Http\Response
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Http
 */
class ResponseTest extends \Mu\Http\TestCase {
    /**
     * Tests that the http response is of the write abstract
     * @return void
     */
    public function testAbstract() {
        $response = new \Mu\Http\Response();
        $this->assertType('\Mu\Core\Response\ResponseAbstract', $response);
    }

    /**
     * Tests getting and setting the headers on a response
     * @return void
     */
    public function testHeaders() {
        $response = new \Mu\Http\Response();

        $this->assertSame(array(), $response->getHeaders());
        $response->setHeader('Content-Type', 'text/plain');
        $this->assertArrayHasKey('Content-Type', $response->getHeaders());
        $this->assertType('\Mu\http\Header', $response->getHeader('Content-Type'));
        $this->assertNull($response->getHeader('Content-Length'));

        $response->setHeaders(array(
            \Mu\Http\Header::factory('Allow', array('GET', 'HEAD')),
            'Content-Length: 348',
            'Content-Location' => '/123',
            'Pragma' => \Mu\Http\Header::factory('Pragma', 'no-cache'),
            'Foo' => \Mu\Http\Header::factory('WWW-Authenticate: Basic'), // should set name to WWW-Authenticate
        ));

        $this->assertArrayHasKey('Allow', $response->getHeaders());
        $this->assertArrayHasKey('Content-Length', $response->getHeaders());
        $this->assertArrayHasKey('Content-Location', $response->getHeaders());
        $this->assertArrayHasKey('Pragma', $response->getHeaders());
        $this->assertArrayHasKey('WWW-Authenticate', $response->getHeaders());

        $this->assertType('\Mu\http\Header', $response->getHeader('Allow'));
        $this->assertType('\Mu\http\Header', $response->getHeader('Content-Length'));
        $this->assertType('\Mu\http\Header', $response->getHeader('Content-Location'));
        $this->assertType('\Mu\http\Header', $response->getHeader('Pragma'));
        $this->assertType('\Mu\http\Header', $response->getHeader('WWW-Authenticate'));
    }

    /**
     * Tests getting and setting the status on a response
     * @return void
     */
    public function testStatus() {
        $response = new \Mu\http\Response();

        $this->assertType('\Mu\Http\Status', $response->getStatus());
        $this->assertEquals(\Mu\http\Status::STATUS_OK, $response->getStatus()->getStatus());

        $response->setStatus(\Mu\http\Status::STATUS_FORBIDDEN);
        $this->assertType('\Mu\Http\Status', $response->getStatus());
        $this->assertEquals(\Mu\http\Status::STATUS_FORBIDDEN, $response->getStatus()->getStatus());

        $response->setStatus(new \Mu\Http\Status('Request Entity Too Large'));
        $this->assertType('\Mu\Http\Status', $response->getStatus());
        $this->assertEquals(\Mu\http\Status::STATUS_REQUEST_ENTITY_TOO_LARGE, $response->getStatus()->getStatus());

        $response = new \Mu\http\Response(array(
            'status' => \Mu\http\Status::STATUS_NOT_FOUND
        ));
        $this->assertType('\Mu\Http\Status', $response->getStatus());
        $this->assertEquals(\Mu\http\Status::STATUS_NOT_FOUND, $response->getStatus()->getStatus());
    }

    /**
     * Tests getting and setting the response to be compressed
     * @return void
     */
    public function testCompressed() {
        $response = new \Mu\http\Response();

        $this->assertFalse($response->getCompressed());
        $response->setCompressed(true);
        $this->assertTrue($response->getCompressed());
    }
}