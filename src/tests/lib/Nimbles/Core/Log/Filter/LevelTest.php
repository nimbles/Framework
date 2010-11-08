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

namespace Tests\Lib\Nimbles\Core\Log\Filter;

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
class LevelTest extends TestCase {
    /**
     * Tests that only a single log level is included
     * @return void
     */
    public function testIncludeSingle() {
        $filter = new \Nimbles\Core\Log\Filter\Level(array(
            'type' => \Nimbles\Core\Log\Filter\Level::LEVEL_INCLUDE,
            'level' => LOG_NOTICE
        ));

        $this->assertTrue($filter->apply(new \Nimbles\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_NOTICE
        ))));

        $this->assertFalse($filter->apply(new \Nimbles\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_INFO
        ))));
    }

    /**
     * Tests that only a single log level is excluded
     * @return void
     */
    public function testExcludeSingle() {
        $filter = new \Nimbles\Core\Log\Filter\Level(array(
            'type' => \Nimbles\Core\Log\Filter\Level::LEVEL_EXCLUDE,
            'level' => LOG_NOTICE
        ));

        $this->assertTrue($filter->apply(new \Nimbles\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_INFO
        ))));

        $this->assertFalse($filter->apply(new \Nimbles\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_NOTICE
        ))));
    }

    /**
     * Tests that only an array log level is included
     * @return void
     */
    public function testIncludeArray() {
        $filter = new \Nimbles\Core\Log\Filter\Level(array(
            'type' => \Nimbles\Core\Log\Filter\Level::LEVEL_INCLUDE,
            'level' => array(LOG_INFO, LOG_NOTICE, LOG_CRIT)
        ));

        $this->assertTrue($filter->apply(new \Nimbles\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_INFO
        ))));

        $this->assertTrue($filter->apply(new \Nimbles\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_NOTICE
        ))));

        $this->assertTrue($filter->apply(new \Nimbles\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_CRIT
        ))));

        $this->assertFalse($filter->apply(new \Nimbles\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_DEBUG
        ))));

        $this->assertFalse($filter->apply(new \Nimbles\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_WARNING
        ))));

        $this->assertFalse($filter->apply(new \Nimbles\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_ERR
        ))));
    }

    /**
     * Tests that only an array log level is excluded
     * @return void
     */
    public function testExcludeArray() {
        $filter = new \Nimbles\Core\Log\Filter\Level(array(
            'type' => \Nimbles\Core\Log\Filter\Level::LEVEL_EXCLUDE,
            'level' => array(LOG_INFO, LOG_NOTICE, LOG_CRIT)
        ));

        $this->assertFalse($filter->apply(new \Nimbles\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_INFO
        ))));

        $this->assertFalse($filter->apply(new \Nimbles\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_NOTICE
        ))));

        $this->assertFalse($filter->apply(new \Nimbles\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_CRIT
        ))));

        $this->assertTrue($filter->apply(new \Nimbles\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_DEBUG
        ))));

        $this->assertTrue($filter->apply(new \Nimbles\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_WARNING
        ))));

        $this->assertTrue($filter->apply(new \Nimbles\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_ERR
        ))));
    }

    /**
     * Tests that the log levels above are included
     * @return void
     */
    public function testAbove() {
        $filter = new \Nimbles\Core\Log\Filter\Level(array(
            'type' => \Nimbles\Core\Log\Filter\Level::LEVEL_ABOVE,
            'level' => LOG_INFO
        ));

        $this->assertTrue($filter->apply(new \Nimbles\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_INFO
        ))));

        $this->assertTrue($filter->apply(new \Nimbles\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_NOTICE
        ))));

        $this->assertFalse($filter->apply(new \Nimbles\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_DEBUG
        ))));
    }

    /**
     * Tests that the log levels below are included
     * @return void
     */
    public function testBelow() {
        $filter = new \Nimbles\Core\Log\Filter\Level(array(
            'type' => \Nimbles\Core\Log\Filter\Level::LEVEL_BELOW,
            'level' => LOG_NOTICE
        ));

        $this->assertTrue($filter->apply(new \Nimbles\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_INFO
        ))));

        $this->assertTrue($filter->apply(new \Nimbles\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_NOTICE
        ))));

        $this->assertFalse($filter->apply(new \Nimbles\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_CRIT
        ))));
    }

    /**
     * Tests that the \Nimbles\Core\Log\Filter\Exception\InvalidLevel exception is thrown
     * when invalid levels are given
     * @dataProvider invalidProvider
     * @param int $type
     * @param int $levels
     * @return void
     */
    public function testInvalid($type, $levels) {
        $this->setExpectedException('\Nimbles\Core\Log\Filter\Exception\InvalidLevel');

        $filter = new \Nimbles\Core\Log\Filter\Level(array(
            'type' => \Nimbles\Core\Log\Filter\Level::LEVEL_ABOVE,
            'level' => -1
        ));

        $filter->apply(new \Nimbles\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_DEBUG
        )));
    }

    /**
     * Data provider for invalid levels
     * @return array
     */
    public function invalidProvider() {
        return array(
            array(\Nimbles\Core\Log\Filter\Level::LEVEL_ABOVE, -1),
            array(\Nimbles\Core\Log\Filter\Level::LEVEL_ABOVE, 8),
            array(\Nimbles\Core\Log\Filter\Level::LEVEL_BELOW, -1),
            array(\Nimbles\Core\Log\Filter\Level::LEVEL_BELOW, 8),
            array(\Nimbles\Core\Log\Filter\Level::LEVEL_INCLUDE, -1),
            array(\Nimbles\Core\Log\Filter\Level::LEVEL_INCLUDE, 8),
            array(\Nimbles\Core\Log\Filter\Level::LEVEL_EXCLUDE, -1),
            array(\Nimbles\Core\Log\Filter\Level::LEVEL_EXCLUDE, 8),
            array(\Nimbles\Core\Log\Filter\Level::LEVEL_INCLUDE, array(-1, 8)),
            array(\Nimbles\Core\Log\Filter\Level::LEVEL_EXCLUDE, array(-1, 8)),
        );
    }
}
