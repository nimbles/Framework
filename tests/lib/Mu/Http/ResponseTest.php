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
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Http;

use Mu\Http\TestCase;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestCase
 *
 * @group      Mu
 * @group      Mu-Http
 * @group      Mu-Http-Response
 */
class ResponseTest extends TestCase {
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

    /**
     * Tests sending the response
     * @return void
     * @dataProvider sendProvider
     */
    public function testSend($headers, $status, $body, $expectedHeaders, $expectedOutput) {
        $response = $this->createResponse();

        $response->setHeaders($headers)->setStatus($status)
            ->setBody($body);

        $response->send();

        $this->assertSame($expectedHeaders, $this->_headers);
        $this->assertEquals($expectedOutput, $this->getOutput());

        $this->resetDelegatesVars();

        $this->_headersSent = true;
        $response->send();
        $this->assertSame(array(), $this->_headers);
        $this->assertEquals($expectedOutput, $this->getOutput());
    }

    /**
     * Data provider for sending of a reponse
     * @return array
     */
    public function sendProvider() {
        return array(
            array(
                array(
		            'Content-Type' => 'text/plain',
		            'Content-Length' => '11',
		        ),
                \Mu\http\Status::STATUS_OK,
                'hello world',
                array(
		            'Content-Type: text/plain',
		            'Content-Length: 11',
		            'HTTP/1.1 200 OK'
		        ),
		        'hello world'
		    ),
            array(
                array(
                    'Content-Type' => 'text/plain',
                    'Content-Length' => '11',
                ),
                \Mu\http\Status::STATUS_NO_CONTENT,
                'hello world',
                array(
		            'Content-Type: text/plain',
		            'Content-Length: 11',
		            'HTTP/1.1 204 No Content'
		        ),
		        ''
		    ),
		    array(
                array(
                    'Content-Type' => 'text/plain',
                    'Content-Length' => '11',
                ),
                \Mu\http\Status::STATUS_NOT_MODIFIED,
                'hello world',
                array(
                    'Content-Type: text/plain',
                    'Content-Length: 11',
                'HTTP/1.1 304 Not Modified'
                ),
                ''
            ),
        );
    }
}