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
 * @package   Mu\Core\Log
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Core\Log
 */

namespace Tests\Mu\Core\Log;


/**
 * @category  Mu
 * @package   Mu\Core\Log
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Core\Log
 */
class LogTest extends \Mu\Core\TestCase {
    /**
     * Tests getting an instance of the log
     * @return void
     */
    public function testGetInstance() {
        $instance = \Mu\Core\Log::getInstance();
        $this->assertType('\Mu\Core\Log', $instance);
    }

    /**
     * Tests adding a writer by attach
     * @return void
     */
    public function testAddWriterByAttach() {
        $instance = new \Mu\Core\Log();

        $writer = new \Mu\Core\Log\Writer\Mock(array(
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
        $instance = new \Mu\Core\Log();

        $writer = new \Mu\Core\Log\Writer\Mock(array(
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
        $instance = new \Mu\Core\Log();

        $instance->writers->mock1 = new \Mu\Core\Log\Writer\Mock(array(
            'formatter' => array(
                'simple' => array(
                    'format' => '%message%'
                )
            )
        ));

        $instance->writers->mock2 = new \Mu\Core\Log\Writer\Mock(array(
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
        $instance = new \Mu\Core\Log();

        $instance->writers->mock1 = new \Mu\Core\Log\Writer\Mock(array(
            'formatter' => array(
                'simple' => array(
                    'format' => '%message%'
                )
            )
        ));

        $instance->writers->mock2 = new \Mu\Core\Log\Writer\Mock(array(
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
