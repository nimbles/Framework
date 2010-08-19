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

namespace Tests\Lib\Mu\Core\Log\Writer;

require_once '_files/GlobalStream.php';

use Mu\Core\TestCase;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestSuite
 *
 * @group      Mu
 * @group      Mu-Core
 * @group      Mu-Core-Log
 */
class StreamTest extends TestCase {
    /**
     * Log Entry
     * @var \Mu\Core\Log\Entry
     */
    protected $_entry;

    /**
     * Rewriters a stream writer
     * @return void
     */
    public static function setUpBeforeClass() {
        stream_wrapper_register('global', 'Tests\Lib\Mu\Core\Log\Writer\GlobalStream');
    }

    /**
     * Creates the log entry
     * @return void
     */
    public function setUp() {
        $this->_entry = new \Mu\Core\Log\Entry('This is a test message');
    }

    /**
     * Tests writing to a stream
     * @return void
     */
    public function testWrite() {
        global $stream;

        $stream = '';

        $writer = new \Mu\Core\Log\Writer\Stream(array(
            'stream' => 'global://stream',
            'formatter' => array(
                'simple' => array(
                    'format' => '%message%'
                )
            )
        ));

        $writer->write($this->_entry);
        $this->assertEquals("This is a test message\n", $stream);
    }

    /**
     * Tests that the \Mu\Core\Log\Writer\Exception\MissingStreamOption exception is thrown
     * when the stream option is not given when creating the stream writer
     * @return void
     */
    public function testNoStreamOption() {
        $this->setExpectedException('\Mu\Core\Log\Writer\Exception\MissingStreamOption');

        $writer = new \Mu\Core\Log\Writer\Stream();
        $writer->write($this->_entry);
    }
}
