<?php
/**
 * Nimbles Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://nimbl.es/license/mit
 *
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Event
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Event;

require_once 'ListenerMock.php';

use Nimbles\Core\TestCase,
    Nimbles\Core\Event,
    Nimbles\Core\Event\Collection;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Event
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Event\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Event
 */
class CollectionTest extends TestCase {
    /**
     * Tests the run mode of the collection
     * @param array $options
     * @return void
     * @dataProvider optionsProvider
     */
    public function testOptions($options) {
        $collection = new Collection(null, $options);

        $this->assertEquals('Nimbles\Core\Event', $collection->getType());
        $this->assertEquals(Collection::INDEX_ASSOCIATIVE, $collection->getIndexType());
        $this->assertFalse($collection->isReadonly());
    }

    /**
     * Tests connecting callables to events
     * @return void
     */
    public function testConnect() {
        $collection = new Collection();
        $mock = new ListenerMock();
        $mockself = new ListenerMockSelfConnect();

        $collection->connect('event1', array($mock, 'listen1'));

        $this->assertEquals(1, $collection->count());
        $this->assertInstanceOf('Nimbles\Core\Event', $collection['event1']);
        $this->assertEquals('event1', $collection['event1']->getName());
        $this->assertEquals(1, $collection['event1']->count());
        $this->assertSame(array(array($mock, 'listen1')), $collection['event1']->getArrayCopy());

        $collection->connect('event1', array($mock, 'listen2'));

        $this->assertEquals(1, $collection->count());
        $this->assertEquals(2, $collection['event1']->count());
        $this->assertSame(array(array($mock, 'listen1'), array($mock, 'listen2')), $collection['event1']->getArrayCopy());

        $collection->connect('event2', array(array($mock, 'listen3')));

        $this->assertEquals(2, $collection->count());

        $this->assertInstanceOf('Nimbles\Core\Event', $collection['event2']);
        $this->assertEquals('event2', $collection['event2']->getName());
        $this->assertEquals(1, $collection['event2']->count());
        $this->assertSame(array(array($mock, 'listen3')), $collection['event2']->getArrayCopy());

        $collection->connect($mockself);

        $this->assertEquals(3, $collection->count());

        $this->assertEquals(3, $collection['event1']->count());
        $this->assertSame(array(array($mock, 'listen1'), array($mock, 'listen2'), array($mockself, 'listen1')), $collection['event1']->getArrayCopy());

        $this->assertEquals(2, $collection['event2']->count());
        $this->assertSame(array(array($mock, 'listen3'), array($mockself, 'listen2')), $collection['event2']->getArrayCopy());

        $this->assertInstanceOf('Nimbles\Core\Event', $collection['event3']);
        $this->assertEquals('event3', $collection['event3']->getName());
        $this->assertEquals(1, $collection['event3']->count());
        $this->assertSame(array(array($mockself, 'listen3')), $collection['event3']->getArrayCopy());

        $this->setExpectedException('Nimbles\Core\Event\Exception\InvalidConnections');
        $collection->connect(new ListenerMockInvalidSelfConnect());
    }

    /**
     * Tests firing named events from the collection
     * @return void
     */
    public function testFireEvent() {
        $collection = new Collection();
        $mock = $this->getMock('Tests\Lib\Nimbles\Core\Event\ListenerMock');

        $collection->connect('event1', array($mock, 'listen1'));
        $collection->connect('event1', array($mock, 'listen2'));
        $collection->connect('event2', array($mock, 'listen2'));
        $collection->connect('event2', array($mock, 'listen3'));

        $mock->expects($this->once())->method('listen1')->with($this->isInstanceOf('Nimbles\Core\Event'));
        $mock->expects($this->exactly(2))->method('listen2')->with($this->isInstanceOf('Nimbles\Core\Event'));
        $mock->expects($this->once())->method('listen3')->with($this->isInstanceOf('Nimbles\Core\Event'), $this->equalTo('hello'));

        $collection->fireEvent('event1');
        $collection->fireEvent('event2', 'hello');
    }

    /**
     * Tests firing named events from the collection, until a callable returns true
     * @return void
     */
    public function testFireEventUntil() {
        $collection = new Collection();
        $mock = $this->getMock('Tests\Lib\Nimbles\Core\Event\ListenerMock', array('listen1', 'listen3'));

        $collection->connect('event1', array($mock, 'listen1'));
        $collection->connect('event1', array($mock, 'listen2'));
        $collection->connect('event1', array($mock, 'listen3'));

        $collection->connect('event2', array($mock, 'listen2'));
        $collection->connect('event2', array($mock, 'listen3'));

        $mock->expects($this->once())->method('listen1')->with($this->isInstanceOf('Nimbles\Core\Event'), $this->equalTo('hello'));
        $mock->expects($this->never())->method('listen2');

        $collection->fireEventUntil('event1', 'hello');
        $collection->fireEventUntil('event2');
    }
    
    /**
     * Tests the factory method on the collection
     * @param string|int $index
     * @param mixed $value
     * @param bool $valid
     * 
     * @dataProvider factoryProvider
     */
    public function testFactory($index, $value, $valid = true) {
        $event = Collection::factory($index, $value);
        
        if ($valid) {
            $this->assertInstanceOf('Nimbles\Core\Event', $event);
            $this->assertEquals($index, $event->getName());
        } else {
            $this->assertNull($event);
        }
    }

    /**
     * Data provider for collection options
     * @return array
     */
    public function optionsProvider() {
        return array(
            array(null, null),
            array(array(), null),
            array(array('type' => 'string'), null),
            array(array('indexType' => Collection::INDEX_MIXED), null),
            array(array('readonly' => true), null),
        );
    }
    
    /**
     * Data provider for factory method
     * @return array
     */
    public function factoryProvider() {
        return array(
            array('foo', 'bar'),
            array('foo', array()),
            array('foo', new Event()),
            array('foo', false, false)
        );
    }
}