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
class CategoryTest extends TestCase {
    /**
     * Tests the hit/miss based on category
     * @param \Nimbles\Core\Log\Entry $entry
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
     * Tests that the \Nimbles\Core\Log\Filter\Exception\InvalidCategory exception is thrown
     * when no category is given
     * @return void
     */
    public function testMissingCategory() {
        $this->setExpectedException('\Nimbles\Core\Log\Filter\Exception\InvalidCategory');

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
