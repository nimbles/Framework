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
 * @package    Nimbles-Event
 * @subpackage Events
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Event;

require_once 'ListenerMock.php';
require_once 'EventsMock.php';

use Nimbles\Event\TestCase;

/**
 * @category   Nimbles
 * @package    Nimbles-Event
 * @subpackage Events
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Event\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Event
 */
class EventsTest extends TestCase {
    /**
     * Tests that the mock has the traits methods
     * @return void
     */
    public function testTrait() {
        $eventsMock = new EventsMock();
        $this->assertTrue(method_exists($eventsMock, 'getEvent'));
        $this->assertTrue(method_exists($eventsMock, 'connect'));
        $this->assertTrue(method_exists($eventsMock, 'fireEvent'));
        $this->assertTrue(method_exists($eventsMock, 'fireEventUntil'));
    }
    
    /**
     * Tests connecting callables to the events mixin
     * @return void
     */
    public function testConnect() {
        $eventsMock = new EventsMock();
        $listenMock = new ListenerMock();
        $listenMockSelf = new ListenerMockSelfConnect();

        $eventsMock->connect('event1', array($listenMock, 'listen1'));

        $this->assertType('Nimbles\Event\Collection', $eventsMock->getEvent());
        $this->assertEquals(1, $eventsMock->getEvent()->count());

        $this->assertType('Nimbles\Event\Event', $eventsMock->getEvent('event1'));
        $this->assertEquals('event1', $eventsMock->getEvent('event1')->getName());
        $this->assertEquals(1, $eventsMock->getEvent('event1')->count());
        $this->assertSame(array(array($listenMock, 'listen1')), $eventsMock->getEvent('event1')->getArrayCopy());

        $eventsMock->connect('event1', array($listenMock, 'listen2'));

        $this->assertEquals(1, $eventsMock->getEvent()->count());

        $this->assertEquals(2, $eventsMock->getEvent('event1')->count());
        $this->assertSame(array(array($listenMock, 'listen1'), array($listenMock, 'listen2')), $eventsMock->getEvent('event1')->getArrayCopy());

        $eventsMock->connect('event2', array($listenMock, 'listen3'));

        $this->assertEquals(2, $eventsMock->getEvent()->count());

        $this->assertType('Nimbles\Event\Event', $eventsMock->getEvent('event2'));
        $this->assertEquals(1, $eventsMock->getEvent('event2')->count());
        $this->assertEquals('event2', $eventsMock->getEvent('event2')->getName());
        $this->assertSame(array(array($listenMock, 'listen3')), $eventsMock->getEvent('event2')->getArrayCopy());

        $eventsMock->connect($listenMockSelf);

        $this->assertEquals(3, $eventsMock->getEvent()->count());

        $this->assertEquals(3, $eventsMock->getEvent('event1')->count());
        $this->assertSame(array(array($listenMock, 'listen1'), array($listenMock, 'listen2'), array($listenMockSelf, 'listen1')), $eventsMock->getEvent('event1')->getArrayCopy());

        $this->assertEquals(2, $eventsMock->getEvent('event2')->count());
        $this->assertSame(array(array($listenMock, 'listen3'), array($listenMockSelf, 'listen2')), $eventsMock->getEvent('event2')->getArrayCopy());

        $this->assertType('Nimbles\Event\Event', $eventsMock->getEvent('event3'));
        $this->assertEquals('event3', $eventsMock->getEvent('event3')->getName());
        $this->assertEquals(1, $eventsMock->getEvent('event3')->count());
        $this->assertSame(array(array($listenMockSelf, 'listen3')), $eventsMock->getEvent('event3')->getArrayCopy());

        $this->setExpectedException('Nimbles\Event\Exception\InvalidConnections');
        $eventsMock->connect(new ListenerMockInvalidSelfConnect());
    }

    /**
     * Tests firing of named events to the mixin
     * @return void
     */
    public function testFireEvent() {
        $eventsMock = new EventsMock();
        $mock = $this->getMock('Tests\Lib\Nimbles\Event\ListenerMock');

        $eventsMock->connect('event1', array($mock, 'listen1'));
        $eventsMock->connect('event1', array($mock, 'listen2'));
        $eventsMock->connect('event2', array($mock, 'listen2'));
        $eventsMock->connect('event2', array($mock, 'listen3'));

        $mock->expects($this->once())->method('listen1')->with($this->isInstanceOf('Nimbles\Event\Event'));
        $mock->expects($this->exactly(2))->method('listen2')->with($this->isInstanceOf('Nimbles\Event\Event'));
        $mock->expects($this->once())->method('listen3')->with($this->isInstanceOf('Nimbles\Event\Event'), $this->equalTo('hello'));

        $eventsMock->fireEvent('event1');
        $eventsMock->fireEvent('event2', 'hello');
    }

    /**
     * Tests firing named events from the collection, until a callable returns true
     * @return void
     */
    public function testFireEventUntil() {
        $eventsMock = new EventsMock();
        $mock = $this->getMock('Tests\Lib\Nimbles\Event\ListenerMock', array('listen1', 'listen3'));

        $eventsMock->connect('event1', array($mock, 'listen1'));
        $eventsMock->connect('event1', array($mock, 'listen2'));
        $eventsMock->connect('event1', array($mock, 'listen3'));

        $eventsMock->connect('event2', array($mock, 'listen2'));
        $eventsMock->connect('event2', array($mock, 'listen3'));

        $mock->expects($this->once())->method('listen1')->with($this->isInstanceOf('Nimbles\Event\Event'), $this->equalTo('hello'));
        $mock->expects($this->never())->method('listen3');

        $eventsMock->fireEventUntil('event1', 'hello');
        $eventsMock->fireEventUntil('event2');
    }
}