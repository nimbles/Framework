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
 * @subpackage Status
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Http;

use Nimbles\Http\TestCase,
    Nimbles\Http\Status;

/**
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Status
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Http
 * @group      Nimbles-Http-Status
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
     * @param string $statusClass
     * @return void
     * @dataProvider codeProvider
     */
    public function testConstruct($code, $description, $statusClass) {
        // create by code
        $status = new Status(array('status' => $code));

        $this->assertEquals($code, $status->getStatus());
        $this->assertEquals($description, $status->getDescription());
        $this->assertEquals(sprintf('HTTP/1.1 %d %s', $code, $description), (string) $status);

        $methods = array(
            'isInformation' => false,
            'isSuccessful'  => false,
            'isRedirection' => false,
            'isClientError' => false,
            'isServerError' => false
        );

        $methods['is' . ucfirst($statusClass)] = true;

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
        ), static::$_headers);

        static::isHeadersSent(true);
        $this->setExpectedException('\Nimbles\Http\Status\Exception\HeadersAlreadySent');
        $status->send();
    }

    /**
     * Provide status codes to test with
     * @return array
     */
    public function codeProvider() {
        return array(
            array(100, 'Continue',                      'information'),
            array(203, 'Non-Authoritative Information', 'successful'),
            array(301, 'Moved Permanently',             'redirection'),
            array(415, 'Unsupported Media Type',        'clientError'),
            array(505, 'HTTP Version Not Supported',    'serverError'),
        );
    }
}
