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

namespace Tests\Lib\Nimbles\Core;

use Nimbles\Core\TestCase,
    Nimbles\Core\Event;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Event
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Core
 * @group      Nimbles-Core-Event
 */
class EventTest extends TestCase {
    /**
     * Tests getting and setting the event name
     * @return void
     */
    public function testGetSetName() {
        $event = new Event();
        $event->setName('foo');
        
        $this->assertEquals('foo', $event->getName());
        
        $this->setExpectedException('Nimbles\Core\Event\Exception\InvalidName');
        $event->setName(123);
    }
    
    /**
     * Tests fireing an event
     * @return void
     */
    public function testFire() {
        $event = new Event();
        
        $value1 = null;
        $value2 = null;
        
        $event[] = function($event, $value) use (&$value1) { $value1 = $value; return false; };
        $event[] = function($event, $value) use (&$value2) { $value2 = $value; return false; };
        
        $event->fire('hello');
        
        $this->assertEquals('hello', $value1);
        $this->assertEquals('hello', $value2);
    }
    
	/**
     * Tests fireing an event until true is reached
     * @return void
     */
    public function testFireUtil() {
        $event = new Event();
        
        $value1 = null;
        $value2 = null;
        
        $event[] = function($event, $value) use (&$value1) { $value1 = $value; return false; };
        $event[] = function($event, $value) use (&$value2) { $value2 = $value; return false; };
        
        $event->fireUntil('hello');
        
        $this->assertEquals('hello', $value1);
        $this->assertEquals('hello', $value2);
        
        $value3 = null;
        $value4 = null;
        
        $event[] = function($event, $value) use (&$value3) { $value3 = $value; return true; };
        $event[] = function($event, $value) use (&$value4) { $value4 = $value; return false; };
        
        $event->fireUntil('hello2');
        
        $this->assertEquals('hello2', $value1);
        $this->assertEquals('hello2', $value2);
        $this->assertEquals('hello2', $value3);
        $this->assertNull($value4);
    }
}