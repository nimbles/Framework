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
class MockTest extends TestCase {
    /**
     * Tests getting the log entries
     * @return void
     */
    public function testGetEntries() {
        $writer = new \Mu\Core\Log\Writer\Mock(array(
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
        $writer = new \Mu\Core\Log\Writer\Mock(array(
            'formatter' => array(
                'simple' => array(
                    'format' => '%message%'
                )
            )
        ));

        $writer->write(new \Mu\Core\Log\Entry('This is a test message 1'));
        $writer->write(new \Mu\Core\Log\Entry('This is a test message 2'));
        $entries = $writer->getEntries();

        $this->assertEquals('This is a test message 1', $entries[0]);
        $this->assertEquals('This is a test message 2', $entries[1]);
    }
}