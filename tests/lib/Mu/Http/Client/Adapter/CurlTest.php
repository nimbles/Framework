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
namespace Tests\Lib\Mu\Http\Client\Adapter;

use Mu\Http\TestCase,
    Mu\Http\Status,
    Mu\Http\Client,
    Mu\Http\Client\Adapter,
    Mu\Http\Client\Adapter\Curl;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Http\TestCase,
 * @uses       \Mu\Http\Status,
 * @uses       \Mu\Http\Client,
 * @uses       \Mu\Http\Client\Adapter,
 * @uses       \Mu\Http\Client\Adapter\Curl
 *
 * @group      Mu
 * @group      Mu-Http
 * @group      Mu-Http-Client
 * @group      Mu-Http-Client-Adapter
 * @group      Mu-Http-Client-Adapter-Curl
 */
class CurlTest extends TestCase {

    protected function setUp()
    {
        if (!extension_loaded('curl')) {
            $this->markTestSkipped('cURL is not installed, marking all Http Client Curl Adapter tests skipped.');
        }
        parent::setUp();
    }

    /**
     * @dataProvider provideCurlOptions
     */
    public function testCurlOptions($value, $valid) {
        $curl = new Curl();
        if (!$valid) {
            $this->setExpectedException('Mu\Http\Client\Adapter\Curl\Exception');
        }
        $curl->setCurlOptions($value);
        if ($value instanceof \Mu\Core\Config) {
            $value = $value->getArrayCopy();
        }

        $this->assertEquals($value, $curl->getCurlOptions());
    }

    public function provideCurlOptions() {
        return array(
            array(array(), true),
            array(new \Mu\Core\Config(array()), true),
            array(true, false),
            array('incorrect', false),
            array(1, false),
        );
    }

    /**
     * Test the write method the curl adapter
     *
     * This test uses the _files/curl.txt file
     */
    public function testWrite() {
        $request = new Client\Request();
        $dir = dirname(__FILE__);
        $request->setRequestUri('file://' . $dir . '/_files/curl.txt');
        $curl = new Curl();
        $curl->setRequest($request);
        $response = $curl->write();

        $this->assertEquals('<html><body><h1>It works!</h1></body></html>', $response->getBody());
        $this->assertEquals(Status::STATUS_OK, $response->getStatus()->getStatus());
    }

    public function testFailedWrite() {
        $request = new Client\Request();
        $dir = dirname(__FILE__);
        $request->setRequestUri('http://localhost:21/invalidpath');
        $curl = new Curl();
        $curl->setRequest($request);
        $this->setExpectedException('Mu\Http\Client\Adapter\Curl\Exception');
        $response = $curl->write();
    }

}