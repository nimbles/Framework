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

namespace Tests\Lib\Nimbles\Core;

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
class LogTest extends TestCase {
    /**
     * Tests getting an instance of the log
     * @return void
     */
    public function testGetInstance() {
        $instance = Log::getInstance();
        $this->assertInstanceOf('\Nimbles\Core\Log', $instance);
    }

    /**
     * Tests adding a writer by attach
     * @return void
     */
    public function testAddWriterByAttach() {
        $instance = new Log();

        $writer = new Log\Writer\Mock(array(
            'formatter' => array(
                'simple' => array(
                    'format' => '%message%'
                )
            )
        ));

        $instance->attach('writers', 'mock', $writer);
        $this->assertEquals($writer, $instance->writers->mock);

        $instance->write('Hello world');
        $entries = $writer->getEntries();

        $this->assertEquals('Hello world', $entries[0]);
    }

    /**
     * Tests adding a writter by a setter
     * @return void
     */
    public function testAddWriterBySetter() {
        $instance = new Log();

        $writer = new Log\Writer\Mock(array(
            'formatter' => array(
                'simple' => array(
                    'format' => '%message%'
                )
            )
        ));

        $instance->writers->mock = $writer;
        $this->assertEquals($writer, $instance->writers->mock);

        $instance->write('Hello world');
        $entries = $writer->getEntries();

        $this->assertEquals('Hello world', $entries[0]);
    }

    /**
     * Tests multiple writers with the same format
     * @return void
     */
    public function testMultipleWritersSameFormat() {
        $instance = new Log();

        $instance->writers->mock1 = new Log\Writer\Mock(array(
            'formatter' => array(
                'simple' => array(
                    'format' => '%message%'
                )
            )
        ));

        $instance->writers->mock2 = new Log\Writer\Mock(array(
            'formatter' => array(
                'simple' => array(
                    'format' => '%message%'
                )
            )
        ));

        $instance->write('Hello world');

        $entries1 = $instance->writers->mock1->getEntries();
        $this->assertEquals('Hello world', $entries1[0]);

        $entries2 = $instance->writers->mock2->getEntries();
        $this->assertEquals('Hello world', $entries2[0]);
    }

    /**
     * Tests multiple writers with different formats
     * @return void
     */
    public function testMultipleWritersDifferentFormat() {
        $instance = new Log();

        $instance->writers->mock1 = new Log\Writer\Mock(array(
            'formatter' => array(
                'simple' => array(
                    'format' => '%message%'
                )
            )
        ));

        $instance->writers->mock2 = new Log\Writer\Mock(array(
            'formatter' => array(
                'simple' => array(
                    'format' => '%pid% - %message%'
                )
            )
        ));

        $instance->write('Hello world');

        $entries1 = $instance->writers->mock1->getEntries();
        $this->assertEquals('Hello world', $entries1[0]);

        $entries2 = $instance->writers->mock2->getEntries();
        $this->assertEquals(getmypid() . ' - Hello world', $entries2[0]);
    }
}
