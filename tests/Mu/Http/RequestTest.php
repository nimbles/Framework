<?php
namespace Tests\Mu\Http;

class RequestTest extends \Mu\Http\TestCase {
    public function testConstruct() {
        $request = new \Mu\Http\Request();

        $this->assertType('Mu\Core\Request', $request);
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
     * @dataProvider putWithBodyProvider
     */
    public function testRequestPutWithBody(array $options) {
        $request = new \Mu\Http\Request($options);

        $this->assertEquals('/module/controller/action', $request->getRequestUri());
        $this->assertEquals('PUT', $request->getMethod());

        $this->assertTrue($request->isPut());
        $this->assertFalse($request->isGet());
        $this->assertFalse($request->isPost());
        $this->assertFalse($request->isDelete());
        $this->assertFalse($request->isOptions());

        $this->assertEquals('test', $request->getBody());
    }

    public function putWithBodyProvider() {
        return array(
            array(array(  // apache and lighttpd, server accepts PUT
            	'server' => array(
	                'REQUEST_URI' => '/module/controller/action',
	                'REQUEST_METHOD' => 'PUT'
                ),
                'body' => 'test'
            )),
            array(array( // iis, server accepts PUT
                'server' => array(
                	'HTTP_X_REWRITE_URL' => '/module/controller/action',
	                'REQUEST_METHOD' => 'PUT'
                ),
                'body' => 'test'
            )),
            array(array(  // apache and lighttpd, server does not accept PUT, header used with POST
            	'server' => array(
	                'REQUEST_URI' => '/module/controller/action',
	                'REQUEST_METHOD' => 'POST',
                    'HTTP_X_HTTP_METHOD_OVERRIDE' => 'PUT'
                ),
                'body' => 'test'
            )),
            array(array( // iis, server accepts PUT, server does not accept PUT, header used with POST
                'server' => array(
                	'HTTP_X_REWRITE_URL' => '/module/controller/action',
	                'REQUEST_METHOD' => 'POST',
                    'HTTP_X_HTTP_METHOD_OVERRIDE' => 'PUT'
                ),
                'body' => 'test'
            )),
        );
    }
}