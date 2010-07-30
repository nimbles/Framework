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
 * @package   \Mu\Core\Log\Filter
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     \Mu\Core\Log
 * @group     \Mu\Core\Log\Filter
 */

namespace Tests\Mu\Core\Log\Filter;


/**
 * @category  Mu
 * @package   \Mu\Core\Log\Filter
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     \Mu\Core\Log
 * @group     \Mu\Core\Log\Filter
 */
class LevelTest extends \Mu\Core\TestCase {
    /**
     * Tests that only a single log level is included
     * @return void
     */
    public function testIncludeSingle() {
        $filter = new \Mu\Core\Log\Filter\Level(array(
            'type' => \Mu\Core\Log\Filter\Level::LEVEL_INCLUDE,
            'level' => LOG_NOTICE
        ));

        $this->assertTrue($filter->apply(new \Mu\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_NOTICE
        ))));

        $this->assertFalse($filter->apply(new \Mu\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_INFO
        ))));
    }

    /**
     * Tests that only a single log level is excluded
     * @return void
     */
    public function testExcludeSingle() {
        $filter = new \Mu\Core\Log\Filter\Level(array(
            'type' => \Mu\Core\Log\Filter\Level::LEVEL_EXCLUDE,
            'level' => LOG_NOTICE
        ));

        $this->assertTrue($filter->apply(new \Mu\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_INFO
        ))));

        $this->assertFalse($filter->apply(new \Mu\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_NOTICE
        ))));
    }

    /**
     * Tests that only an array log level is included
     * @return void
     */
    public function testIncludeArray() {
        $filter = new \Mu\Core\Log\Filter\Level(array(
            'type' => \Mu\Core\Log\Filter\Level::LEVEL_INCLUDE,
            'level' => array(LOG_INFO, LOG_NOTICE, LOG_CRIT)
        ));

        $this->assertTrue($filter->apply(new \Mu\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_INFO
        ))));

        $this->assertTrue($filter->apply(new \Mu\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_NOTICE
        ))));

        $this->assertTrue($filter->apply(new \Mu\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_CRIT
        ))));

        $this->assertFalse($filter->apply(new \Mu\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_DEBUG
        ))));

        $this->assertFalse($filter->apply(new \Mu\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_WARNING
        ))));

        $this->assertFalse($filter->apply(new \Mu\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_ERR
        ))));
    }

    /**
     * Tests that only an array log level is excluded
     * @return void
     */
    public function testExcludeArray() {
        $filter = new \Mu\Core\Log\Filter\Level(array(
            'type' => \Mu\Core\Log\Filter\Level::LEVEL_EXCLUDE,
            'level' => array(LOG_INFO, LOG_NOTICE, LOG_CRIT)
        ));

        $this->assertFalse($filter->apply(new \Mu\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_INFO
        ))));

        $this->assertFalse($filter->apply(new \Mu\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_NOTICE
        ))));

        $this->assertFalse($filter->apply(new \Mu\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_CRIT
        ))));

        $this->assertTrue($filter->apply(new \Mu\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_DEBUG
        ))));

        $this->assertTrue($filter->apply(new \Mu\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_WARNING
        ))));

        $this->assertTrue($filter->apply(new \Mu\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_ERR
        ))));
    }

    /**
     * Tests that the log levels above are included
     * @return void
     */
    public function testAbove() {
        $filter = new \Mu\Core\Log\Filter\Level(array(
            'type' => \Mu\Core\Log\Filter\Level::LEVEL_ABOVE,
            'level' => LOG_INFO
        ));

        $this->assertTrue($filter->apply(new \Mu\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_INFO
        ))));

        $this->assertTrue($filter->apply(new \Mu\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_NOTICE
        ))));

        $this->assertFalse($filter->apply(new \Mu\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_DEBUG
        ))));
    }

    /**
     * Tests that the log levels below are included
     * @return void
     */
    public function testBelow() {
        $filter = new \Mu\Core\Log\Filter\Level(array(
            'type' => \Mu\Core\Log\Filter\Level::LEVEL_BELOW,
            'level' => LOG_NOTICE
        ));

        $this->assertTrue($filter->apply(new \Mu\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_INFO
        ))));

        $this->assertTrue($filter->apply(new \Mu\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_NOTICE
        ))));

        $this->assertFalse($filter->apply(new \Mu\Core\Log\Entry(array(
            'message' => 'This is a test message',
            'level' => LOG_CRIT
        ))));
    }

    /**
     * Tests that the \Mu\Core\Log\Filter\Exception\InvalidLevel exception is thrown
     * when invalid levels are given
     * @dataProvider invalidProvider
     * @param int $type
     * @param int $levels
     * @return void
     */
    public function testInvalid($type, $levels) {
        $this->setExpectedException('\Mu\Core\Log\Filter\Exception\InvalidLevel');

        $filter = new \Mu\Core\Log\Filter\Level(array(
            'type' => \Mu\Core\Log\Filter\Level::LEVEL_ABOVE,
            'level' => -1
        ));

        $filter->apply(new \Mu\Core\Log\Entry(array(
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
            array(\Mu\Core\Log\Filter\Level::LEVEL_ABOVE, -1),
            array(\Mu\Core\Log\Filter\Level::LEVEL_ABOVE, 8),
            array(\Mu\Core\Log\Filter\Level::LEVEL_BELOW, -1),
            array(\Mu\Core\Log\Filter\Level::LEVEL_BELOW, 8),
            array(\Mu\Core\Log\Filter\Level::LEVEL_INCLUDE, -1),
            array(\Mu\Core\Log\Filter\Level::LEVEL_INCLUDE, 8),
            array(\Mu\Core\Log\Filter\Level::LEVEL_EXCLUDE, -1),
            array(\Mu\Core\Log\Filter\Level::LEVEL_EXCLUDE, 8),
            array(\Mu\Core\Log\Filter\Level::LEVEL_INCLUDE, array(-1, 8)),
            array(\Mu\Core\Log\Filter\Level::LEVEL_EXCLUDE, array(-1, 8)),
        );
    }
}
