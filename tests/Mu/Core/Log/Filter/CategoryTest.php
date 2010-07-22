<?php
/**
 * Mu Framework
 *
 * LICENSE
 *
 * This shouce file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://mu-framework.com/license/mit
 *
 * @category  Mu
 * @package   Mu\Core\Log\Filter
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Core\Log
 * @group     Mu\Core\Log\Filter
 */

namespace Tests\Mu\Core\Log\Filter;


/**
 * @category  Mu
 * @package   Mu\Core\Log\Filter
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Core\Log
 * @group     Mu\Core\Log\Filter
 */
class CategoryTest extends \Mu\Core\TestCase {
	/**
	 * Tests the hit/miss based on category
	 * @return void
	 */
	public function testCategory() {
		$filter = new \Mu\Core\Log\Filter\Category(array(
			'category' => 'hit'
		));

		$this->assertTrue($filter->apply(new \Mu\Core\Log\Entry(array(
			'message' => 'This is a test message',
			'category' => 'hit'
		))));

		$this->assertFalse($filter->apply(new \Mu\Core\Log\Entry(array(
			'message' => 'This is a test message',
			'category' => 'miss'
		))));

		$this->assertFalse($filter->apply(new \Mu\Core\Log\Entry(array(
			'message' => 'This is a test message'
		))));
	}

	/**
	 * Tests that the Mu\Core\Log\Filter\Exception\InvalidCategory exception is thrown
	 * when no category is given
	 * @return void
	 */
	public function testMissingCategory() {
		$this->setExpectedException('\Mu\Core\Log\Filter\Exception\InvalidCategory');

		$filter = new \Mu\Core\Log\Filter\Category(array());

		$filter->apply(new \Mu\Core\Log\Entry(array(
			'message' => 'This is a test message',
			'category' => 'hit'
		)));
	}
}