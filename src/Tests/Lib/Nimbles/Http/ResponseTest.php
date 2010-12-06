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

namespace Tests\Lib\Nimbles\Http;

use Nimbles\Http\TestCase;

/**
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Http
 * @group      Nimbles-Http-Response
 */
class ResponseTest extends TestCase {
    /**
     * Tests that the http response is of the write abstract
     * @return void
     */
    public function testAbstract() {
        $response = new \Nimbles\Http\Response();
        $this->assertType('\Nimbles\Core\Response\ResponseAbstract', $response);
    }

    /**
     * Tests getting and setting the headers on a response
     * @return void
     */
    public function testHeaders() {
        $response = new \Nimbles\Http\Response();

        $this->assertType('Nimbles\Http\Header\Collection', $response->getHeader());
        $response->setHeader('Content-Type', 'text/plain');
        $this->assertTrue($response->getHeader()->offsetExists('Content-Type'));

        $this->assertType('\Nimbles\Http\Header', $response->getHeader('Content-Type'));
        $this->assertEquals('Content-Type: text/plain', (string) $response->getHeader('Content-Type'));

        $this->assertType('\Nimbles\Http\Header', $response->header->getHeader('Content-Type'));
        $this->assertEquals('Content-Type: text/plain', (string) $response->header->getHeader('Content-Type'));

        $this->assertType('\Nimbles\Http\Header', $response->header->{'Content-Type'});
        $this->assertEquals('Content-Type: text/plain', (string) $response->header->{'Content-Type'});

        $this->assertNull($response->getHeader('Content-Length'));

        $response->setHeaders(array(
            \Nimbles\Http\Header::factory('Allow', array('GET', 'HEAD')),
            'Content-Length: 348',
            'Content-Location' => '/123',
            'Pragma' => \Nimbles\Http\Header::factory('Pragma', 'no-cache'),
            'Foo' => \Nimbles\Http\Header::factory('WWW-Authenticate: Basic'), // should set name to WWW-Authenticate
        ));

        $this->assertTrue($response->getHeader()->offsetExists('Allow'));
        $this->assertTrue($response->getHeader()->offsetExists('Content-Length'));
        $this->assertTrue($response->getHeader()->offsetExists('Content-Location'));
        $this->assertTrue($response->getHeader()->offsetExists('Pragma'));
        $this->assertTrue($response->getHeader()->offsetExists('WWW-Authenticate'));

        $this->assertType('\Nimbles\Http\Header', $response->getHeader('Allow'));
        $this->assertType('\Nimbles\Http\Header', $response->getHeader('Content-Length'));
        $this->assertType('\Nimbles\Http\Header', $response->getHeader('Content-Location'));
        $this->assertType('\Nimbles\Http\Header', $response->getHeader('Pragma'));
        $this->assertType('\Nimbles\Http\Header', $response->getHeader('WWW-Authenticate'));
    }

    /**
     * Tests getting and setting the status on a response
     * @return void
     */
    public function testStatus() {
        $response = new \Nimbles\Http\Response();

        $this->assertType('\Nimbles\Http\Status', $response->getStatus());
        $this->assertEquals(\Nimbles\Http\Status::STATUS_OK, $response->getStatus()->getStatus());

        $response->setStatus(\Nimbles\Http\Status::STATUS_FORBIDDEN);
        $this->assertType('\Nimbles\Http\Status', $response->getStatus());
        $this->assertEquals(\Nimbles\Http\Status::STATUS_FORBIDDEN, $response->getStatus()->getStatus());

        $response->setStatus(new \Nimbles\Http\Status(array('status' => 'Request Entity Too Large')));
        $this->assertType('\Nimbles\Http\Status', $response->getStatus());
        $this->assertEquals(\Nimbles\Http\Status::STATUS_REQUEST_ENTITY_TOO_LARGE, $response->getStatus()->getStatus());

        $response = new \Nimbles\Http\Response(array(
            'status' => \Nimbles\Http\Status::STATUS_NOT_FOUND
        ));
        $this->assertType('\Nimbles\Http\Status', $response->getStatus());
        $this->assertEquals(\Nimbles\Http\Status::STATUS_NOT_FOUND, $response->getStatus()->getStatus());
    }

    /**
     * Tests getting and setting the response to be compressed
     * @return void
     */
    public function testCompressed() {
        $response = new \Nimbles\Http\Response();

        $this->assertFalse($response->isCompressed());
        $response->isCompressed(true);
        $this->assertTrue($response->isCompressed());
    }

    /**
     * Tests getting an setting cookies
     * @return void
     */
    public function testCookie() {
        $response = new \Nimbles\Http\Response();

        $this->assertType('\Nimbles\Http\Cookie\Jar', $response->getCookie());

        $response->setCookie('test1', 'value1');
        $response->setCookie(new \Nimbles\Http\Cookie(array(
            'name' => 'test2',
            'value' => 'value2',
            'expires' => 200
        )));
        $response->cookie->test3 = 'value3';

        $this->assertCollection('\Nimbles\Http\Cookie', $response->getCookie());
        $this->assertCollection('\Nimbles\Http\Cookie', $response->cookie);

        $cookie1 = $response->getCookie('test1');
        $cookie2 = $response->getCookie('test2');
        $cookie3 = $response->getCookie('test3');

        $this->assertType('Nimbles\Http\Cookie', $cookie1);
        $this->assertEquals('value1', $cookie1->getValue());
        $this->assertEquals(0, $cookie1->getExpires());

        $this->assertType('Nimbles\Http\Cookie', $cookie2);
        $this->assertEquals('value2', $cookie2->getValue());
        $this->assertEquals(200, $cookie2->getExpires());

        $this->assertType('Nimbles\Http\Cookie', $cookie3);
        $this->assertEquals('value3', $cookie3->getValue());
        $this->assertEquals(0, $cookie3->getExpires());

        $this->assertSame($cookie1, $response->cookie->test1);
        $this->assertSame($cookie2, $response->cookie->test2);
        $this->assertSame($cookie3, $response->cookie->test3);
    }

    /**
     * Tests the session from a response
     * @return void
     */
    public function testSession() {
        $response = new \Nimbles\Http\Response();
        $session = $this->createSession();
        $response->setSession($session);

        $this->assertType('Nimbles\Http\Session', $response->getSession());
        static::$_session = array(
            'test1' => 'abc',
            'test2' => 123
        );

        $this->assertType('Nimbles\Http\Session', $response->getSession());
        $this->assertType('Nimbles\Http\Session', $response->session);

        $this->assertEquals('abc', $response->getSession('test1'));
        $this->assertEquals('abc', $response->session->test1);

        $this->assertEquals(123, $response->getSession('test2'));
        $this->assertEquals(123, $response->session->test2);

        $this->assertNull($response->getSession('test3'));
        $this->assertNull($response->session->test3);

        $response->setSession('test3', 'def');

        $this->assertEquals('def', $response->getSession('test3'));
        $this->assertEquals('def', $response->session->test3);
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