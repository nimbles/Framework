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

namespace Tests\Lib\Nimbles\Core\Log\Writer;

require_once '_files/GlobalStream.php';

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
class StreamTest extends TestCase {
    /**
     * Log Entry
     * @var \Nimbles\Core\Log\Entry
     */
    protected $_entry;

    /**
     * Rewriters a stream writer
     * @return void
     */
    public static function setUpBeforeClass() {
        stream_wrapper_register('global', 'Tests\Lib\Nimbles\Core\Log\Writer\GlobalStream');
    }

    /**
     * Creates the log entry
     * @return void
     */
    public function setUp() {
        $this->_entry = new \Nimbles\Core\Log\Entry('This is a test message');
    }

    /**
     * Tests writing to a stream
     * @return void
     */
    public function testWrite() {
        global $stream;

        $stream = '';

        $writer = new \Nimbles\Core\Log\Writer\Stream(array(
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
     * Tests that the \Nimbles\Core\Log\Writer\Exception\MissingStreamOption exception is thrown
     * when the stream option is not given when creating the stream writer
     * @return void
     */
    public function testNoStreamOption() {
        $this->setExpectedException('\Nimbles\Core\Log\Writer\Exception\MissingStreamOption');

        $writer = new \Nimbles\Core\Log\Writer\Stream();
        $writer->write($this->_entry);
    }
}
