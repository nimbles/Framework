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

namespace Tests\Lib\Mu\Core\Log\Filter;

use Mu\Core\TestCase,
    Mu\Core\Log;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestCase
 *
 * @group      Mu
 * @group      Mu-Core
 * @group      Mu-Core-Log
 */
class CategoryTest extends TestCase {
    /**
     * Tests the hit/miss based on category
     * @param \Mu\Core\Log\Entry $entry
     * @param bool               $hit
     * @return void
     * @dataProvider categoryProvider
     */
    public function testCategory(Log\Entry $entry, $hit) {
        $filter = new Log\Filter\Category(array(
            'category' => 'hit'
        ));

        $this->assertEquals($hit, $filter->apply($entry));
    }

    /**
     * Tests that the \Mu\Core\Log\Filter\Exception\InvalidCategory exception is thrown
     * when no category is given
     * @return void
     */
    public function testMissingCategory() {
        $this->setExpectedException('\Mu\Core\Log\Filter\Exception\InvalidCategory');

        $filter = new Log\Filter\Category(array());

        $filter->apply(new Log\Entry(array(
            'message' => 'This is a test message',
            'category' => 'hit'
        )));
    }

    /**
     * Data provider for category hit and misses
     * @return array
     */
    public function categoryProvider() {
        return array(
            array(new Log\Entry(array(
	            'message' => 'This is a test message',
	            'category' => 'hit'
	        )), true),
	        array(new Log\Entry(array(
                'message' => 'This is a test message',
                'category' => 'miss'
            )), false),
            array(new Log\Entry(array(
                'message' => 'This is a test message'
            )), false)
        );
    }
}
