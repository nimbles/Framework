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
 * @subpackage Cookie
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */
namespace Tests\Lib\Mu\Http;

use Mu\Http\TestCase,
    Mu\Http\Cookie;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Header
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
class CookieTest extends TestCase {
    /**
     * Tests that the default options are set
     * @return void
     */
    public function testDefaultOptions() {
        $cookie = new Cookie(array(
            'name' => 'test_name',
            'value' => 'test_value'
        ));

        $this->assertEquals(0, $cookie->getExpire());
        $this->assertEquals('/', $cookie->getPath());
        $this->assertNull($cookie->getDomain());
        $this->assertFalse($cookie->isSecure());
        $this->assertFalse($cookie->isHttponly());
        $this->assertEquals('test_name', $cookie->getName());
        $this->assertEquals('test_value', $cookie->getValue());
    }

    /**
     * Tests that setting custom options via constructor
     * @return void
     */
    public function testConstructOptions() {
        $cookie = new Cookie(array(
            'expire' => 100,
            'path' => '/foo',
            'domain' => 'www.bar.com',
            'secure' => true,
            'httponly' => true,
            'name' => 'test_name',
            'value' => 'test_value'
        ));

        $this->assertEquals(100, $cookie->getExpire());
        $this->assertEquals('/foo', $cookie->getPath());
        $this->assertEquals('www.bar.com', $cookie->getDomain());
        $this->assertTrue($cookie->isSecure());
        $this->assertTrue($cookie->isHttponly());
        $this->assertEquals('test_name', $cookie->getName());
        $this->assertEquals('test_value', $cookie->getValue());
    }

    /**
     * Tests the send method
     */
    public function testSend() {
        $cookie = $this->createCookie(array(
            'name' => 'test_name',
            'value' => 'test value'
        ));

        $cookie->send();
        $this->assertSame(array(
            'Set-Cookie: test_name=test value; path=/'
        ), static::$_headers);

        $this->resetDelegatesVars();

        $cookie->send(true);
        $this->assertSame(array(
            'Set-Cookie: test_name=test value; path=/'
        ), static::$_headers);

        static::isHeadersSent(true);
        $this->setExpectedException('Mu\Http\Cookie\Exception\HeadersAlreadySent');

        $cookie->send();
    }
}