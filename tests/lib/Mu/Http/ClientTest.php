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
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */
namespace Tests\Lib\Mu\Http;

use Mu\Http\TestCase,
    Mu\Http\Client,
    Mu\Http\Status;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Http\TestCase
 * @uses       \Mu\Http\Client
 *
 * @group      Mu
 * @group      Mu-Http
 * @group      Mu-Http-Client
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
            $this->setExpectedException('Mu\Core\Adapter\Exception\InvalidAdapter');
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
            array('Curl', array(), 'Mu\Http\Client\Adapter\Curl'),
            array('MultiCurl', array(), 'Mu\Http\Client\Adapter\MultiCurl'),
            // Alternative spelling
            array('curl', array(), 'Mu\Http\Client\Adapter\Curl'),
            array('CURL', array(), 'Mu\Http\Client\Adapter\Curl'),
            // Camel case
            array('multi-curl', array(), false),
            array('Multi-Curl', array(), false),
            // Objects
            array(new \Mu\Http\Client\Adapter\Curl(), array(), 'Mu\Http\Client\Adapter\Curl'),
            array(new \Mu\Http\Client\Adapter\MultiCurl(), array(), 'Mu\Http\Client\Adapter\MultiCurl'),
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
        $this->assertType('\Mu\Http\Client\Adapter\Curl', Client::getDefaultAdapter());
    }

    /**
     * @dataProvider requestInvalidDataProvider
     */
    public function testRequestInvalidRequest($request) {
        $client = new Client();
        $this->setExpectedException('Mu\Http\Client\Exception');
        $response = $client->request($request);
    }

    public function requestInvalidDataProvider() {
        return array(
            array(new \Mu\Http\Request()),
            array(1),
            array(0.9),
            array(new \stdClass()),
            array(function() {return new \stdClass();}),
            array(false),
            array(true),
        );
    }

}