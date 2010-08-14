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
 * @category  Mu
 * @package   \Mu\Core\Log\Formatter
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     \Mu\Core\Log
 * @group     \Mu\Core\Log\Formatter
 */

namespace Tests\Mu\Core\Log\Formatter;


/**
 * @category  Mu
 * @package   \Mu\Core\Log\Formatter
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     \Mu\Core\Log
 * @group     \Mu\Core\Log\Formatter
 */
class SimpleTest extends \Mu\Core\TestCase {
    /**
     * A log entry
     * @var \Mu\Core\Log\Entry
     */
    protected $_entry;

    /**
     * Sets up the the test
     * @return void
     */
    public function setUp() {
        $this->_entry = new \Mu\Core\Log\Entry('This is a test message');
    }

    /**
     * Tests the construct of a simple formatter with no params
     * @return void
     */
    public function testConstructNoParams() {
        $formatter = new \Mu\Core\Log\Formatter\Simple();
        $this->assertEquals(
            sprintf('%s %d INFO - uncategorised - This is a test message',
                $this->_entry->getOption('timestamp')->format(\Mu\Core\DateTime::ISO8601), getmypid())
            , $formatter->format($this->_entry));
    }

    /**
     * Tests the construct of a simple formater with a custom format
     * @return void
     */
    public function testCustomFormat() {
        $formatter = new \Mu\Core\Log\Formatter\Simple(array(
            'format' => '%message%'
        ));
        $this->assertEquals('This is a test message', $formatter->format($this->_entry));
    }
}
