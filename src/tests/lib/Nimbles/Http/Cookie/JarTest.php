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
 * @subpackage Cookie
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Http\Cookie;

use Nimbles\Http\TestCase,
    Nimbles\Http\Cookie;

/**
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Cookie
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Http
 * @group      Nimbles-Http-Cookie
 */
class JarTest extends TestCase {
    /**
     * Tests adding a cookie and that a Nimbles\Http\Cookie\Exception\InvalidInstance exception
     * is thrown accordingly
     * @return void
     */
    public function testAddCookie() {
        $jar = new Cookie\Jar();
        $jar[] = new Cookie(array(
            'name' => 'test',
            'value' => 'value'
        ));

        $jar['test2'] = new Cookie(array(
            'value' => 'value2'
        ));

        $jar['test3'] = 'value3';

        $this->assertCollection('\Nimbles\Http\Cookie', $jar);

        $this->setExpectedException('Nimbles\Http\Cookie\Exception\InvalidInstance');
        $jar[] = true;
    }

    /**
     * Tests construct and that a Nimbles\Http\Cookie\Exception\InvalidInstance exception is
     * thrown when adding a non cookie
     * @return void
     */
    public function testConstruct() {
        $jar = new Cookie\Jar(array(
            'test' => new Cookie(),
            'test2' => 'value'
        ));

        $this->assertEquals('value', (string) $jar['test2']);
        $this->assertType('Nimbles\Http\Cookie', $jar['test2']);

        $this->setExpectedException('Nimbles\Http\Cookie\Exception\InvalidInstance');
        $jar = new Cookie\Jar(array(
            true
        ));
    }

    /**
     * Tests that a Nimbles\Core\Collection\Exception\ReadOnly exception is thrown when
     * added a cookie to a read only jar
     * @return void
     */
    public function testReadOnly() {
        $jar = new Cookie\Jar(array(
            'test' => new Cookie(),
            'test2' => 'value'
        ), array(
            'readonly' => true
        ));

        $this->assertTrue($jar->isReadOnly());
        $this->setExpectedException('Nimbles\Core\Collection\Exception\ReadOnly');
        $jar['test3'] = 'value3';
    }

    /**
     * Tests sending the cookie jar and that the Nimbles\Http\Cookie\Exception\HeadersAlreadySent
     * exception is thrown when attempt to send once headers are already sent
     * @return void
     */
    public function testSend() {
        $jar = new Cookie\Jar();

        $cookie = new Cookie(array(
            'name' => 'test_name',
            'value' => 'test value'
        ));

        $sent = false;
        $urlencoded = array();
        $raw = array();

        $cookie->setDelegate('headers_sent', function() use (&$sent) {
            return $sent;
        });

        $cookie->setDelegate('setcookie', function() use (&$urlencoded) {
            $urlencoded = func_get_args();
            $urlencoded[1] = urlencode($urlencoded[1]);
        });

        $jar[] = $cookie;
        $this->assertEquals('test value', (string) $jar['test_name']);

        $jar->send();

        $this->assertSame(array(
            'test_name',
            'test+value',
            0,
            '/',
            null,
            false,
            false
        ), $urlencoded);

        $sent = true;
        $this->setExpectedException('Nimbles\Http\Cookie\Exception\HeadersAlreadySent');

        $jar->send();
    }
}