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
namespace Tests\Lib\Mu\Http\Client;

use Mu\Http\TestCase,
    Mu\Http\Status,
    Mu\Http\Client\Response;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Http\TestCase
 * @uses       \Mu\Http\Status
 * @uses       \Mu\Http\Client\Request
 *
 * @group      Mu
 * @group      Mu-Http
 * @group      Mu-Http-Client
 * @group      Mu-Http-Client-Response
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