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
        $response = new \Mu\Http\Response();

        $this->assertType('\Mu\Http\Status', $response->getStatus());
        $this->assertEquals(\Mu\http\Status::STATUS_OK, $response->getStatus()->getStatus());

        $response->setStatus(\Mu\http\Status::STATUS_FORBIDDEN);
        $this->assertType('\Mu\Http\Status', $response->getStatus());
        $this->assertEquals(\Mu\http\Status::STATUS_FORBIDDEN, $response->getStatus()->getStatus());

        $response->setStatus(new \Mu\Http\Status(array('status' => 'Request Entity Too Large')));
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
     * Tests getting an setting cookies
     * @return void
     */
    public function testCookie() {
        $response = new \Mu\Http\Response();

        $this->assertType('\Mu\Http\Cookie\Jar', $response->getCookie());

        $response->setCookie('test1', 'value1');
        $response->setCookie(new \Mu\Http\Cookie(array(
            'name' => 'test2',
            'value' => 'value2',
            'expire' => 200
        )));
        $this->assertCollection('\Mu\Http\Cookie', $response->getCookie());

        $cookie1 = $response->getCookie('test1');
        $cookie2 = $response->getCookie('test2');

        $this->assertEquals('value1', $cookie1->getValue());
        $this->assertEquals(0, $cookie1->getExpire());

        $this->assertEquals('value2', $cookie2->getValue());
        $this->assertEquals(200, $cookie2->getExpire());
    }

   /**
     * Tests sending the response
     * @return void
     * @dataProvider sendProvider
     */
    public function testSend($headers, $cookies, $status, $body, $expectedHeaders, $expectedOutput) {
        $response = $this->createResponse();

        $response->setHeaders($headers)
            ->setStatus($status)
            ->setBody($body);

        foreach ($cookies as $cookie) {
            $response->setCookie($cookie);
        }

        $response->send();

        $this->assertSame($expectedHeaders, static::$_headers);
        $this->assertEquals($expectedOutput, static::getOutput());

        $this->resetDelegatesVars();

        static::isHeadersSent(true);
        $response->send();
        $this->assertSame(array(), static::$_headers);
        $this->assertEquals($expectedOutput, static::getOutput());
    }

    /**
     * Data provider for sending of a reponse
     * @return array
     */
    public function sendProvider() {
        $args = array();
        $statuses = array(null, 204, 304);

        foreach ($statuses as $status) {
            $body = (null === $status) ? 'hello world' : '';

            $status = $this->createStatus(
                (null === $status) ?
                null :
                array('status' => $status)
            );

            $args[] = array(
                array(
                    $this->createHeader(array('name' => 'Content-Type', 'value' => 'text/plain')),
                    $this->createHeader(array('name' => 'Content-Length', 'value' => '11')),
                ),
                array(
                    $this->createCookie(array('name' => 'test1', 'value' => 'value1')),
                    $this->createCookie(array('name' => 'test2', 'value' => 'value2', 'path' => '/foo')),
                ),
                $status,
                'hello world',
                array(
                    'Content-Type: text/plain',
                    'Content-Length: 11',
                    'Set-Cookie: test1=value1; path=/',
                    'Set-Cookie: test2=value2; path=/foo',
                    (string) $status
                ),
                $body
            );
        }

        return $args;
    }
}