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
 * @subpackage Cookie
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Http\Cookie;

use Mu\Http\TestCase,
    Mu\Http\Cookie;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Cookie
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestCase
 *
 * @group      Mu
 * @group      Mu-Http
 * @group      Mu-Http-Cookie
 */
class JarTest extends TestCase {
    /**
     * Tests adding a cookie and that a Mu\Http\Cookie\Exception\InvalidInstance exception
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

        $this->assertCollection('\Mu\Http\Cookie', $jar);

        $this->setExpectedException('Mu\Http\Cookie\Exception\InvalidInstance');
        $jar[] = true;
    }

    /**
     * Tests construct and that a Mu\Http\Cookie\Exception\InvalidInstance exception is
     * thrown when adding a non cookie
     * @return void
     */
    public function testConstruct() {
        $jar = new Cookie\Jar(array(
            'test' => new Cookie(),
            'test2' => 'value'
        ));

        $this->assertEquals('value', (string) $jar['test2']);
        $this->assertType('Mu\Http\Cookie', $jar['test2']);

        $this->setExpectedException('Mu\Http\Cookie\Exception\InvalidInstance');
        $jar = new Cookie\Jar(array(
            true
        ));
    }

    /**
     * Tests that a Mu\Http\Cookie\Jar\Exception\ReadOnly exception is thrown when
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

        $this->setExpectedException('Mu\Http\Cookie\Jar\Exception\ReadOnly');
        $jar['test3'] = 'value3';
    }

    /**
     * Tests sending the cookie jar and that the Mu\Http\Cookie\Exception\HeadersAlreadySent
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
        $this->setExpectedException('Mu\Http\Cookie\Exception\HeadersAlreadySent');

        $jar->send();
    }
}