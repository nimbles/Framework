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
}