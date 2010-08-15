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
     * Tests adding a cookie
     * @return void
     */
    public function testAddCookie() {
        $jar = new Cookie\Jar();
        $jar[] = new Cookie();

        $this->setExpectedException('Mu\Http\Cookie\Exception\InvalidInstance');
        $jar[] = true;
    }

    /**
     * Tests construct
     * @return void
     */
    public function testConstruct() {
        $jar = new Cookie\Jar(array(
            new Cookie()
        ));

        $this->setExpectedException('Mu\Http\Cookie\Exception\InvalidInstance');
        $jar = new Cookie\Jar(array(
            true
        ));
    }

    /**
     * Tests sending the cookie jar
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