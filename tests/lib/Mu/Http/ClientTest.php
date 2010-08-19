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
    Mu\Http\Client;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestCase
 *
 * @group      Mu
 * @group      Mu-Http
 * @group      Mu-Http-Client
 */
class ClientTest extends TestCase {

    /**
     * @dataProvider methodDataProvider
     */
    public function testMethod($method, $valid) {
        $client = new Client();

        $constraint = $this->equalTo($method);
        if (!$valid) {
            $this->setExpectedException('\Mu\Http\Client\Exception\InvalidMethod');
            $constraint = $this->logicalNot(
                $this->equalTo($method)
            );
        }

        $returnValue = $client->setMethod($method);

        $this->assertThat($client->getMethod(), $constraint);
        $this->assertEquals($client, $returnValue);
    }

    public function methodDataProvider() {
        return array(
            array('GET', true),
            array('HEAD', true),
            array('POST', true),
            array('PUT', true),
            array('DELETE', true),
            array('OPTIONS', true),
            array(0, false),
            array(array(), false),
            array(new \stdClass(), false),
        );
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
            array('Curl', array(), 'Mu\\Http\\Client\\Adapter\\Curl'),
            array('MultiCurl', array(), 'Mu\\Http\\Client\\Adapter\\MultiCurl'),
            // Alternative spelling
            array('curl', array(), 'Mu\\Http\\Client\\Adapter\\Curl'),
            array('CURL', array(), 'Mu\\Http\\Client\\Adapter\\Curl'),
            // Camel case
            array('multi-curl', array(), false),
            array('Multi-Curl', array(), false),
            // Objects
            array(new \Mu\Http\Client\Adapter\Curl(), array(), 'Mu\\Http\\Client\\Adapter\\Curl'),
            array(new \Mu\Http\Client\Adapter\MultiCurl(), array(), 'Mu\\Http\\Client\\Adapter\\MultiCurl'),
        );
    }
}