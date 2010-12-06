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
namespace Tests\Lib\Nimbles\Http\Client;

use Nimbles\Http\TestCase,
    Nimbles\Http\Status,
    Nimbles\Http\Client\Response;

/**
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Http\TestCase
 * @uses       \Nimbles\Http\Status
 * @uses       \Nimbles\Http\Client\Request
 *
 * @group      Nimbles
 * @group      Nimbles-Http
 * @group      Nimbles-Http-Client
 * @group      Nimbles-Http-Client-Response
 */
class ResponseTest extends TestCase {

    /**
     * @dataProvider provideRawResponse
     */
    public function testSetRawResponse($raw, $status, $headers, $body) {
        $response = new Response();
        $response->setRawResponse($raw);

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
        $this->assertEquals($body, $response->getBody());
    }

    public function provideRawResponse() {
        $fileDir = dirname(__FILE__) . '/_files/response/';
        return array(
            array(file_get_contents($fileDir . '1.txt'), Status::STATUS_OK, array('Key' => 'Value'), 'Body')
        );
    }
}