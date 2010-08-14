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
 * @package    Mu-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Core\Log;

use Mu\Core\TestCase,
    Mu\Core\Log;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestCase
 *
 * @group      Mu
 * @group      Mu-Core
 * @group      Mu-Core-Log
 */
class EntryTest extends TestCase {
    /**
     * Tests constructing a log entry from just a string
     * @return void
     */
    public function testConstructJustMessage() {
        $entry = new Log\Entry('Hello world');

        $this->assertEquals('Hello world', $entry->getOption('message'));
        $this->assertEquals(getmypid(), $entry->getOption('pid'));
        $this->assertEquals(LOG_INFO, $entry->getOption('level'));
        $this->assertNull($entry->getOption('category'));
    }

    /**
     * Tests constructing a log entry from an array
     */
    public function testConstructArray() {
        $ts = new \Mu\Core\DateTime();

        $entry = new Log\Entry(array(
            'message' => 'Hello world',
            'timestamp' => $ts,
            'extra' => 'test'
        ));

        $this->assertEquals('Hello world', $entry->getOption('message'));
        $this->assertEquals(getmypid(), $entry->getOption('pid'));
        $this->assertEquals(LOG_INFO, $entry->getOption('level'));
        $this->assertEquals($ts, $entry->getOption('timestamp'));
        $this->assertNull($entry->getOption('category'));
        $this->assertEquals('test', $entry->getOption('extra'));
    }
}
