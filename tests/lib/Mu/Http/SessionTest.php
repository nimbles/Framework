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
 * @subpackage Session
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Http;

use Mu\Http\TestCase,
    Mu\Http\Session;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Session
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestCase
 *
 * @group      Mu
 * @group      Mu-Http
 * @group      Mu-Http-Session
 */
class SessionTest extends TestCase {
    /**
     * Tests the isStarted method
     * @return void
     */
    public function testIsStarted() {
        $session = new Session();

        $this->assertFalse($session->isStarted());
        $this->assertTrue($session->isStarted(true));
        // check if true status persists
        $this->assertTrue($session->isStarted());
    }

    /**
     * Tests the session id
     * @return void
     */
    public function testSessionId() {
        $session = $this->createSession();

        $this->assertEquals('', $session->getId());
        $session->start();
        $this->assertNotEquals('', $session->getId(), 'Session id should not be empty');

        $id = $session->getId();
        $session->regenterateId();
        $this->assertNotEquals($id, $session->getId(), 'Session id should have changed');
    }

    /**
     * Tests the session name
     * @return void
     */
    public function testSessionName() {
        $session = $this->createSession();

        $this->assertEquals('PHPSESSID', $session->getName());
        $session->setName('TESTPHPSESSID');
        $this->assertEquals('TESTPHPSESSID', $session->getName());

        $session->start();
        $this->setExpectedException('Mu\Http\Session\Exception\SessionStarted');
        $session->setName('PHPSESSID');
    }

    /**
     * Tests starting the session
     * @return void
     */
    public function testSessionStart() {
        $session = $this->createSession();

        $this->assertFalse($session->isStarted());
        $session->start();
        $this->assertTrue($session->isStarted());

        $this->setExpectedException('Mu\Http\Session\Exception\SessionStarted');
        $session->start();
    }

    /**
     * Tests reading from the session
     * @return void
     */
    public function testRead() {
        static::$_session = array(
            'hello' => 'world',
            'test' => 123
        );

        $session = $this->createSession();

        $this->assertNull($session->read('hello'), 'Session should be empty if not started');
        $this->assertNull($session->read('test'), 'Session should be empty if not started');
        $this->assertSame(array(), $session->read(), 'Session should be empty if not started');

        $session->start();

        $this->assertEquals('world', $session->read('hello'));
        $this->assertEquals(123, $session->read('test'));
        $this->assertEquals(static::$_session, $session->read());
    }

    /**
     * Tests writing to a session
     * @return void
     */
    public function testWrite() {
        $session = $this->createSession();

        try {
            $session->write('hello', 'world');
            $this->fail('Expected exception Mu\Http\Session\Exception\SessionStarted');
        } catch (\Exception $ex) {
            $this->assertType('Mu\Http\Session\Exception\SessionStarted', $ex);
        }

        $session->start();
        $session->write('hello', 'world');

        $this->assertEquals('world', $session->read('hello'));
        $this->assertSame(static::$_session, $session->read());
    }

    /**
     * Tests destroying a session
     * @return void
     */
    public function testDestroy() {
        $session = $this->createSession();

        $session->start();
        $session->write('hello', 'world');
        $this->assertEquals('world', $session->read('hello'));

        $session->destroy();

        $this->assertEquals('', $session->getId());
        $this->assertNull($session->read('hello'));
        $this->assertSame(array(), $session->read());
    }
}