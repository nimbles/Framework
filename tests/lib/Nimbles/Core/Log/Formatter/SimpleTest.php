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

namespace Tests\Lib\Nimbles\Core\Log\Formatter;

use Nimbles\Core\TestCase;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Core
 * @group      Nimbles-Core-Log
 */
class SimpleTest extends TestCase {
    /**
     * A log entry
     * @var \Nimbles\Core\Log\Entry
     */
    protected $_entry;

    /**
     * Sets up the the test
     * @return void
     */
    public function setUp() {
        $this->_entry = new \Nimbles\Core\Log\Entry('This is a test message');
    }

    /**
     * Tests the construct of a simple formatter with no params
     * @return void
     */
    public function testConstructNoParams() {
        $formatter = new \Nimbles\Core\Log\Formatter\Simple();
        $this->assertEquals(
            sprintf('%s %d INFO - uncategorised - This is a test message',
                $this->_entry->getOption('timestamp')->format(\Nimbles\Core\DateTime::ISO8601), getmypid())
            , $formatter->format($this->_entry));
    }

    /**
     * Tests the construct of a simple formater with a custom format
     * @return void
     */
    public function testCustomFormat() {
        $formatter = new \Nimbles\Core\Log\Formatter\Simple(array(
            'format' => '%message%'
        ));
        $this->assertEquals('This is a test message', $formatter->format($this->_entry));
    }
}
