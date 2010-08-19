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
 * @subpackage Status
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Http;

use Mu\Http\TestCase;

use Mu\Http\Status;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Status
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestCase
 *
 * @group      Mu
 * @group      Mu-Http
 * @group      Mu-Http-Status
 */
class StatusTest extends TestCase {
    /**
     * Tests that the default status is 200 OK
     * @return void
     */
    public function testDefault() {
        $status = new Status();
        $this->assertEquals(200, $status->getStatus());
    }

    /**
     * Tests that creating a status from a given code produces the corresponding header
     * @param int    $code
     * @param string $expectedHeader
     * @return void
     * @dataProvider codeProvider
     */
    public function testConstruct($code, $description) {
        // create by code
        $status = new Status(array('status' => $code));

        $this->assertEquals($code, $status->getStatus());
        $this->assertEquals($description, $status->getDescription());
        $this->assertEquals(sprintf('HTTP/1.1 %d %s', $code, $description), (string) $status);

        $methods = array(
            'isInformation' => false,
            'isSuccessful' => false,
            'isRedirection' => false,
            'isClientError' => false,
            'isServerError' => false
        );

        switch (true) {
            case (1 === floor($code / 100)) :
                $methods['isInformation'] = true;
                break;

            case (2 === floor($code / 100)) :
                $methods['isSuccessful'] = true;
                break;

            case (3 === floor($code / 100)) :
                $methods['isRedirection'] = true;
                break;

            case (4 === floor($code / 100)) :
                $methods['isClientError'] = true;
                break;

            case (5 === floor($code / 100)) :
                $methods['isServerError'] = true;
                break;
        }

        foreach($methods as $method => $expected) {
            $this->assertEquals($expected, $status->$method());
        }

        // create by description
        $status = new Status(array('status' => $description));

        $this->assertEquals($code, $status->getStatus());
        $this->assertEquals($description, $status->getDescription());
        $this->assertEquals(sprintf('HTTP/1.1 %d %s', $code, $description), (string) $status);

        foreach($methods as $method => $expected) {
            $this->assertEquals($expected, $status->$method());
        }
    }

    /**
     * Tests sending a header
     * @param int    $code
     * @param string $expectedHeader
     * @return void
     * @dataProvider codeProvider
     */
    public function testSend($code, $description) {
        $status = $this->createStatus(array('status' => $code));
        $status->send();

        $this->assertSame(array(
            sprintf('HTTP/1.1 %d %s', $code, $description)
        ), self::$_headers);

        self::isHeadersSent(true);
        $this->setExpectedException('\Mu\Http\Status\Exception\HeadersAlreadySent');
        $status->send();
    }

    /**
     * Provide status codes to test with
     * @return array
     */
    public function codeProvider() {
        return array(
            array(100, 'Continue'),
            array(203, 'Non-Authoritative Information'),
            array(301, 'Moved Permanently'),
            array(415, 'Unsupported Media Type'),
            array(505, 'HTTP Version Not Supported'),
        );
    }
}