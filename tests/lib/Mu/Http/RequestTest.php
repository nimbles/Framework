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
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Http;

use Mu\Http\TestCase;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestCase
 *
 * @group      Mu
 * @group      Mu-Http
 * @group      Mu-Http-Request
 */
class RequestTest extends TestCase {
    /**
     * Test that the request object extends the abstract
     * @return void
     */
    public function testConstruct() {
        $request = $this->createRequest();
        $this->assertType('Mu\Core\Request\RequestAbstract', $request);
    }

    /**
     * Tests the query
     * @return void
     */
    public function testQuery() {
        static::$_query = array(
            'foo' => 'bar',
            'baz' => 'qux'
        );

        $request = $this->createRequest();

        $this->assertType('Mu\Core\Collection', $request->getQuery());
        $this->assertType('Mu\Core\Collection', $request->query);

        $this->assertEquals('bar', $request->getQuery('foo'));
        $this->assertEquals('bar', $request->query->foo);

        $this->assertEquals('qux', $request->getQuery('baz'));
        $this->assertEquals('qux', $request->query->baz);

        $this->assertNull($request->getQuery('quux'));
    }

    /**
     * Tests the post
     * @return void
     */
    public function testPost() {
        static::$_post = array(
            'foo' => 'bar',
            'baz' => 'qux'
        );

        $request = $this->createRequest();

        $this->assertType('Mu\Core\Collection', $request->getPost());
        $this->assertType('Mu\Core\Collection', $request->post);

        $this->assertEquals('bar', $request->getPost('foo'));
        $this->assertEquals('bar', $request->post->foo);

        $this->assertEquals('qux', $request->getPost('baz'));
        $this->assertEquals('qux', $request->post->baz);

        $this->assertNull($request->getPost('quux'));
    }

    /**
     * Test the server
     * @return void
     */
    public function testServer() {
        static::$_server = array(
            'foo' => 'bar',
            'baz' => 'qux'
        );

        $request = $this->createRequest();

        $this->assertType('Mu\Core\Collection', $request->getServer());
        $this->assertType('Mu\Core\Collection', $request->server);

        $this->assertEquals('bar', $request->getServer('foo'));
        $this->assertEquals('bar', $request->server->foo);

        $this->assertEquals('qux', $request->getServer('baz'));
        $this->assertEquals('qux', $request->server->baz);

        $this->assertNull($request->getServer('quux'));
    }

    /**
     * Tests using the session, when accessing via request, the session should
     * be read only
     * @return void
     */
    public function testSession() {
        static::$_session = array(
            'test1' => 'abc',
            'test2' => 123
        );

        $request = $this->createRequest();


        $this->assertType('Mu\Http\Session', $request->getSession());
        $this->assertType('Mu\Http\Session', $request->session);

        $this->assertEquals('abc', $request->getSession('test1'));
        $this->assertEquals('abc', $request->session->read('test1'));
        $this->assertEquals(123, $request->getSession('test2'));
        $this->assertNull($request->getSession('test3'));

        $request->getSession()->write('test3', 'def');
        $this->assertNull($request->getSession('test3'));

        $request->getSession()->clear();
        $this->assertEquals('abc', $request->getSession('test1'));
        $this->assertEquals(123, $request->getSession('test2'));
    }

    /**
     * Tests that the request uri is detected for multiple platforms
     * @dataProvider requestUriProvider
     * @param array $options
     * @return void
     */
    public function testGetRequestUri($options) {
        foreach ($options as $property => $array) {
            $property = '_' . $property;
            static::$$property = $array;
        }

        $request = $this->createRequest();
        $this->assertEquals('/module/controller/action', $request->getRequestUri());
    }

    /**
     * Tests the http method is detected
     * @dataProvider methodProvider
     * @param string $method
     * @param array  $options
     * @return void
     */
    public function testGetMethod($method, $options) {
        foreach ($options as $property => $array) {
            $property = '_' . $property;
            static::$$property = $array;
        }

        $request = $this->createRequest();
        $this->assertEquals($method, $request->getMethod());
    }

    /**
     * Tests getting the port
     * @return void
     */
    public function testGetPort() {
        static::$_server = array(
            'SERVER_PORT' => '80'
        );
        $request = $this->createRequest();

        $this->assertEquals(80, $request->getPort());
    }

    /**
     * Tests getting the host
     * @return void
     */
    public function testGetHost() {
        static::$_server = array(
            'SERVER_NAME' => 'mu-framework.com'
        );
        $request = $this->createRequest();
        $this->assertEquals('mu-framework.com', $request->getHost());
    }

    /**
     * Tests reading headers from a request
     * @return void
     * @dataProvider headerProvider
     */
    public function testGetHeader($name, $value) {
        $serverName = 'HTTP_' . strtoupper(str_replace('-', '_', $name));
        static::$_server = array(
            $serverName => $value,
        );
        $request = $this->createRequest();

        $this->assertType('Mu\Http\Header\Collection', $request->getHeader());
        $this->assertType('Mu\Http\Header\Collection', $request->header);

        $this->assertType('Mu\Http\Header', $request->getHeader($name));
        $this->assertEquals($name . ': ' . $value, (string) $request->getHeader($name));

        $this->assertType('Mu\Http\Header', $request->header->getHeader($name));
        $this->assertEquals($name . ': ' . $value, (string) $request->header->getHeader($name));

        $this->assertType('Mu\Http\Header', $request->header->$name);
        $this->assertEquals($name . ': ' . $value, (string) $request->header->$name);
    }

    /**
     * Tests the cookie
     * @return void
     */
    public function testCookie() {
        static::$_cookies = array(
            'hello' => 'world'
        );

        $request = $this->createRequest();
        $this->assertType('Mu\Http\Cookie\Jar', $request->getCookie());
        $this->assertType('Mu\Http\Cookie\Jar', $request->cookie);

        $this->assertType('Mu\Http\Cookie', $request->getCookie('hello'));
        $this->assertType('Mu\Http\Cookie', $request->cookie->getCookie('hello'));
        $this->assertType('Mu\Http\Cookie', $request->cookie->hello);

        $this->assertEquals('world', $request->getCookie('hello')->getValue());
        $this->assertEquals('world', $request->cookie->getCookie('hello')->getValue());
        $this->assertEquals('world', $request->cookie->hello->getValue());

        $this->assertEquals('world', (string) $request->getCookie('hello'));
        $this->assertEquals('world', (string) $request->cookie->getCookie('hello'));
        $this->assertEquals('world', (string) $request->cookie->hello);
    }

    /**
     * Tests that the body of the request is retrieved correctly
     * @return void
     */
    public function testGetBody() {
        $request = $this->createRequest();

        static::setInput('hello world');
        $this->assertEquals('hello world', $request->getBody());
        $this->assertEquals('hello world', $request->body);
    }

    /**
     * Data provider for request uri
     * @return array
     */
    public function requestUriProvider() {
        return array(
            array(array(  // apache and lighttpd
                'server' => array(
                    'REQUEST_URI' => '/module/controller/action',
                ),
            )),
            array(array( // iis
                'server' => array(
                    'HTTP_X_REWRITE_URL' => '/module/controller/action',
                ),
            )),
        );
    }


    /**
     * Data provider for request methods
     * @return array
     */
    public function methodProvider() {
        return array(
            array('GET', array(  // standard GET support
                'server' => array(
                    'REQUEST_METHOD' => 'GET',
                ),
            )),
            array('POST', array(  // standard POST support
                'server' => array(
                    'REQUEST_METHOD' => 'POST',
                ),
            )),
            array('PUT', array(  // standard PUT support
                'server' => array(
                    'REQUEST_METHOD' => 'PUT',
                ),
            )),
            array('PUT', array( //
                'server' => array( // X-Http-Method-Override header support
                    'REQUEST_METHOD' => 'POST',
                    'HTTP_X_HTTP_METHOD_OVERRIDE' => 'PUT',
                ),
            )),
            array('PUT', array( //
                'server' => array( // method_override querystring support
                    'REQUEST_METHOD' => 'POST',
                ),
                'query' => array(
                    'method_override' => 'PUT'
                )
            )),
        );
    }

    /**
     * Data provider for headers
     * @return array
     */
    public function headerProvider() {
        return array(
            array('User-Agent', 'test'),
            array('X-Custom', 'value'),
            array('Accept', 'text/plain'),
        );
    }
}
