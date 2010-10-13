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
class MockTest extends TestCase {
    /**
     * Tests getting the log entries
     * @return void
     */
    public function testGetEntries() {
        $writer = new \Nimbles\Core\Log\Writer\Mock(array(
            'formatter' => array(
                'simple' => array(
                    'format' => '%message%'
                )
            )
        ));

        $this->assertType('array', $writer->getEntries());
    }

    /**
     * Tests writing to a stream
     * @return void
     */
    public function testWrite() {
        $writer = new \Nimbles\Core\Log\Writer\Mock(array(
            'formatter' => array(
                'simple' => array(
                    'format' => '%message%'
                )
            )
        ));

        $writer->write(new \Nimbles\Core\Log\Entry('This is a test message 1'));
        $writer->write(new \Nimbles\Core\Log\Entry('This is a test message 2'));
        $entries = $writer->getEntries();

        $this->assertEquals('This is a test message 1', $entries[0]);
        $this->assertEquals('This is a test message 2', $entries[1]);
    }
}
