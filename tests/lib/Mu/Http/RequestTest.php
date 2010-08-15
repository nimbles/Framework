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
     * Tests over the getters which should have the same behavior
     * @dataProvider getterProvider
     * @param string $getter
     * @param bool $cast Indicates that should be casted before asserting
     * @param string $type
     * @return void
     */
    public function testGetter($getter, $cast, $type) {
        $request = $this->createRequest(array(
            $getter => array(
                'foo' => 'bar',
                'baz' => 'qux'
            )
        ));

        $method = 'get' . ucfirst($getter);

        if ($cast) {
	        $this->assertEquals('bar', (string) $request->$method('foo'));
	        $this->assertEquals('qux', (string) $request->$method('baz'));
        } else {
            $this->assertEquals('bar', $request->$method('foo'));
            $this->assertEquals('qux', $request->$method('baz'));
        }

        $this->assertType($type, $request->$method());
        $this->assertNull($request->$method('quux'));
    }

    /**
     * Tests that the request uri is detected for multiple platforms
     * @dataProvider requestUriProvider
     * @param array $options
     * @return void
     */
    public function testGetRequestUri($options) {
        $request = $this->createRequest($options);
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
        $request = $this->createRequest($options);
        $this->assertEquals($method, $request->getMethod());
    }

    /**
     * Tests getting the port
     * @return void
     */
    public function testGetPort() {
        $request = $this->createRequest(array(
            'server' => array(
                'SERVER_PORT' => 80
            )
        ));

        $this->assertEquals(80, $request->getPort());
    }

    /**
     * Tests getting the host
     * @return void
     */
    public function testGetHost() {
        $request = $this->createRequest(array(
            'server' => array(
                'SERVER_NAME' => 'mu-framework.com'
            )
        ));

        $this->assertEquals('mu-framework.com', $request->getHost());
    }

    public function testGetBody() {
        $request = $this->createRequest();

        $this->setInput('hello world');
        $this->assertEquals('hello world', $request->getBody());
    }

    /**
     * Data provider for getter methods
     * @return array
     */
    public function getterProvider() {
        return array(
            array('query', false, 'array'),
            array('post', false, 'array'),
            array('session', true, 'array'),
            array('cookie', true, 'Mu\Http\Cookie\Jar'),
        );
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
}
