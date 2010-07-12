<?php
namespace Tests\Mu\Http;

class RequestTest extends \Mu\Http\TestCase {
    public function testConstruct() {
        $request = new \Mu\Http\Request();

        $this->assertType('Mu\Core\Request\RequestAbstract', $request);
    }

    /**
     * Tests over the getters which should have the same behavior
     * @dataProvider getterProvider
     */
    public function testGetter($getter) {
        $request = new \Mu\Http\Request(array(
            $getter => array(
                'foo' => 'bar',
                'baz' => 'qux'
            )
        ));

        $method = 'get' . ucfirst($getter);

        $this->assertEquals('bar', $request->$method('foo'));
        $this->assertEquals('qux', $request->$method('baz'));

        $this->assertType('array', $request->$method());
        $this->assertNull($request->$method('quux'));
    }

    public function getterProvider() {
        return array(
            array('query'),
            array('post'),
            array('session'),
            array('cookie'),
        );
    }

	/**
     * @dataProvider requestUriProvider
     */
    public function testGetRequestUri($options) {
        $request = new \Mu\Http\Request($options);
        $this->assertEquals('/module/controller/action', $request->getRequestUri());
    }

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
     * @dataProvider methodProvider
     */
    public function testGetMethod($options) {
        $request = new \Mu\Http\Request($options);
        $this->assertEquals('PUT', $request->getMethod());
    }

    public function methodProvider() {
        return array(
            array(array(  // standard PUT support
            	'server' => array(
	                'REQUEST_METHOD' => 'PUT',
                ),
            )),
            array(array( //
                'server' => array( // X-Http-Method-Override header support
                	'REQUEST_METHOD' => 'POST',
                    'HTTP_X_HTTP_METHOD_OVERRIDE' => 'PUT',
                ),
            )),
            array(array( //
                'server' => array( // method_override querystring support
                	'REQUEST_METHOD' => 'POST',
                ),
                'query' => array(
                    'method_override' => 'PUT'
                )
            )),
        );
    }

    public function testGetPort() {
        $request = new \Mu\Http\Request(array(
            'server' => array(
                'SERVER_PORT' => 80
            )
        ));

        $this->assertEquals(80, $request->getPort());
    }

    public function testGetHost() {
        $request = new \Mu\Http\Request(array(
            'server' => array(
                'SERVER_NAME' => 'mu-framework.com'
            )
        ));

        $this->assertEquals('mu-framework.com', $request->getHost());
    }
}