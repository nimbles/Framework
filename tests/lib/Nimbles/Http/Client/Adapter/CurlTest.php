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
namespace Tests\Lib\Nimbles\Http\Client\Adapter;

use Nimbles\Http\TestCase,
    Nimbles\Http\Status,
    Nimbles\Http\Client,
    Nimbles\Http\Client\Adapter,
    Nimbles\Http\Client\Adapter\Curl;

/**
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Http\TestCase,
 * @uses       \Nimbles\Http\Status,
 * @uses       \Nimbles\Http\Client,
 * @uses       \Nimbles\Http\Client\Adapter,
 * @uses       \Nimbles\Http\Client\Adapter\Curl
 *
 * @group      Nimbles
 * @group      Nimbles-Http
 * @group      Nimbles-Http-Client
 * @group      Nimbles-Http-Client-Adapter
 * @group      Nimbles-Http-Client-Adapter-Curl
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
            $this->setExpectedException('Nimbles\Http\Client\Adapter\Curl\Exception');
        }
        $curl->setCurlOptions($value);
        if ($value instanceof \Nimbles\Core\Config) {
            $value = $value->getArrayCopy();
        }

        $this->assertEquals($value, $curl->getCurlOptions());
    }

    public function provideCurlOptions() {
        return array(
            array(array(), true),
            array(new \Nimbles\Core\Config(array()), true),
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
        $this->setExpectedException('Nimbles\Http\Client\Adapter\Curl\Exception');
        $response = $curl->write();
    }

}