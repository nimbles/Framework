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
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */
namespace Tests\Lib\Nimbles\Http;

use Nimbles\Http\TestCase,
    Nimbles\Http\Client,
    Nimbles\Http\Status,
    Nimbles\Http\Cookie;

/**
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Http\TestCase
 * @uses       \Nimbles\Http\Client
 * @uses       \Nimbles\Http\Status
 * @uses       \Nimbles\Http\Cookie
 *
 * @group      Nimbles
 * @group      Nimbles-Http
 * @group      Nimbles-Http-Client
 */
class ClientTest extends TestCase {

    public function setUp() {
        if (!extension_loaded('curl')) {
            $this->markTestSkipped('cURL is not installed, marking all Http Client Curl Adapter tests skipped.');
        }
        parent::setUp();
    }

    /**
     * @dataProvider adapterDataProvider
     */
    public function testAdapter($adapter, $options, $valid) {
        $client = new Client();

        if (!$valid) {
            $this->setExpectedException('Nimbles\Core\Adapter\Exception\InvalidAdapter');
            $constraint = $this->logicalNot(
                $this->equalTo(null)
            );
        } else {
            $constraint = $this->isInstanceOf($valid);
        }

        $returnValue = $client->setAdapter($adapter, $options);

        $this->assertThat($client->getAdapter(), $constraint);
        $this->assertEquals($client, $returnValue);
    }

    public function adapterDataProvider() {
        return array(
            // Valid Adapters
            array('Curl', array(), 'Nimbles\Http\Client\Adapter\Curl'),
            array('CurlMulti', array(), 'Nimbles\Http\Client\Adapter\CurlMulti'),
            // Alternative spelling
            array('curl', array(), 'Nimbles\Http\Client\Adapter\Curl'),
            array('CURL', array(), 'Nimbles\Http\Client\Adapter\Curl'),
            // Camel case
            array('curl-multi', array(), false),
            array('Curl-Multi', array(), false),
            // Objects
            array(new \Nimbles\Http\Client\Adapter\Curl(), array(), 'Nimbles\Http\Client\Adapter\Curl'),
            array(new \Nimbles\Http\Client\Adapter\CurlMulti(), array(), 'Nimbles\Http\Client\Adapter\CurlMulti'),
        );
    }

    /**
     * @dataProvider requestDataProvider
     */
    public function testRequest($request, $method, $adapter, $status, $headers, $body) {
        $client = new Client();
        if (null !== $adapter) {
            $client->setAdapter($adapter);
        }
        $response = $client->request($request, $method);

        if (null !== $status) {
            $this->assertEquals($status, $response->getStatus()->getStatus());
        }

        if (null !== $headers) {
            foreach($headers as $key => $value) {
                $header = $response->getHeader($key);
                $this->assertNotNull($header);
                $this->assertEquals($key, $header->getName());
                $this->assertEquals($value, $header->getValue());
            }
        }
        $method = (null === $method) ? 'GET' : $method;

        $this->assertEquals($method, $client->getLastRequest()->getMethod());
        $this->assertEquals($body, $response->getBody());
        $this->assertEquals($response, $client->getLastResponse());

    }

    public function requestDataProvider() {
        $fileDir = 'file://' . dirname(__FILE__) . '/_files/client/';
        return array(
            array($fileDir . '1.txt', 'GET', 'Curl', Status::STATUS_OK, array('Key' => 'Value'), 'Body'),
            array($fileDir . '1.txt', NULL, 'Curl', Status::STATUS_OK, array('Key' => 'Value'), 'Body'),
            array($fileDir . '1.txt', 'POST', 'Curl', Status::STATUS_OK, array('Key' => 'Value'), 'Body'),
            array($fileDir . '1.txt', 'GET', NULL, Status::STATUS_OK, array('Key' => 'Value'), 'Body'),
            array($fileDir . '2.txt', 'POST', 'Curl', Status::STATUS_OK, array('Key1' => 'Value', 'Key2' => 'Value', 'Key3' => 'Value'), "Body\nof\n2"),
            array(new Client\Request(array('requestUri' => $fileDir . '1.txt')) , 'GET', 'Curl', Status::STATUS_OK, array('Key' => 'Value'), 'Body'),
            array(new Client\Request(array('requestUri' => $fileDir . '1.txt')) , NULL, 'Curl', Status::STATUS_OK, array('Key' => 'Value'), 'Body'),
        );
    }

    public function testDefaultAdapter() {
        $client = new Client();
        $this->assertInstanceOf('\Nimbles\Http\Client\Adapter\Curl', $client->getDefaultAdapter());
    }

    /**
     * @dataProvider requestInvalidDataProvider
     */
    public function testRequestInvalidRequest($request) {
        $client = new Client();
        $this->setExpectedException('Nimbles\Http\Client\Exception');
        $response = $client->request($request);
    }

    public function requestInvalidDataProvider() {
        return array(
            array(new \Nimbles\Http\Request()),
            array(1),
            array(0.9),
            array(new \stdClass()),
            array(function() {return new \stdClass();}),
            array(false),
            array(true),
        );
    }

    public function testRequestMulti() {
        $client = new Client();

        $requests = array(
            new Client\Request(array('requestUri' => 'file://' . dirname(__FILE__) . '/_files/client/1.txt', 'method' => 'GET')),
            new Client\Request(array('requestUri' => 'file://' . dirname(__FILE__) . '/_files/client/1.txt')),
            new Client\Request(array('requestUri' => 'file://' . dirname(__FILE__) . '/_files/client/2.txt', 'method' => 'GET')),
            new Client\Request(array('requestUri' => 'file://' . dirname(__FILE__) . '/_files/client/2.txt'))
        );

        $client->setAdapter('CurlMulti');

        $batch = $client->request($requests);

        $this->assertEquals($batch, $client->getLastBatch());
        $this->assertEquals(count($requests), count($batch));
        foreach($batch as $result) {
            $this->assertArrayHasKey('request', $result);
            $this->assertArrayHasKey('response', $result);
            $request = $result['request'];
            $this->assertContains($request, $requests);
        }

        $this->setExpectedException('\Nimbles\Http\Client\Exception');
        $client->setAdapter('Curl');
        $client->request($requests);
    }

    /**
     * Test the cookie jar of the response and client
     */
    public function testCookieJar() {
        $client = new Client();
        $cookieJar = new Cookie\Jar();
        $client->setCookieJar($cookieJar);
        $this->assertEquals($cookieJar, $client->getCookieJar());

        $request = new Client\Request(
            array(
                'requestUri' => 'file://' . dirname(__FILE__) . '/_files/client/cookie.txt',
                'method' => 'GET'
            )
        );

        $response = $client->request($request);
        $this->assertInstanceOf('Nimbles\Http\Cookie\Jar', $response->getCookie());
        $responseCookieJar = $response->getCookie()->getArrayCopy();
        $this->assertArrayHasKey('Name', $responseCookieJar);
        $this->assertInstanceOf('Nimbles\Http\Cookie', $responseCookieJar['Name']);
        $this->assertEquals('Value', $responseCookieJar['Name']->getValue());
        $this->assertEquals('localhost', $responseCookieJar['Name']->getDomain());
        $this->assertEquals('/', $responseCookieJar['Name']->getPath());
        $this->assertEquals(strtotime('Tue, 31-Dec-2050 23:59:59 GMT') - time(), $responseCookieJar['Name']->getExpires());

        $arrayCookieJar = $cookieJar->getArrayCopy();
        $this->assertArrayHasKey('Name', $arrayCookieJar);
        $this->assertEquals($responseCookieJar['Name'], $arrayCookieJar['Name']);

        $cookieJar->exchangeArray(array()); //reset the cookie jar
        $client->setAdapter('CurlMulti');
        $request = new Client\Request(
            array(
                'requestUri' => 'file://' . dirname(__FILE__) . '/_files/client/cookie.txt',
                'method' => 'GET'
            ),
            array(
                'requestUri' => 'file://' . dirname(__FILE__) . '/_files/client/cookie.txt',
                'method' => 'GET'
            )
        );

        $batch = $client->request($request);
        $arrayCookieJar = $cookieJar->getArrayCopy();
        $this->assertArrayHasKey('Name', $arrayCookieJar);

    }
}