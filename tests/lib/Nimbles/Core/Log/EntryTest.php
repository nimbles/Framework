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
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Log;

use Nimbles\Core\TestCase,
    Nimbles\Core\Log;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Core
 * @group      Nimbles-Core-Log
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
        $ts = new \Nimbles\Core\DateTime();

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
