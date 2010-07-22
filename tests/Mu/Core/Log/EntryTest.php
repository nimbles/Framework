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
class EntryTest extends \Mu\Core\TestCase {
	/**
	 * Tests constructing a log entry from just a string
	 * @return void
	 */
	public function testConstructJustMessage() {
		$entry = new \Mu\Core\Log\Entry('Hello world');

		$this->assertEquals('Hello world', $entry->getOption('message'));
		$this->assertEquals(getmypid(), $entry->getOption('pid'));
		$this->assertEquals(LOG_INFO, $entry->getOption('level'));
		$this->assertNull($entry->getOption('category'));
	}

	/**
	 * Tests constructing a log entry from an array
	 */
	public function testConstructArray() {
		$ts = new \Mu\Core\DateTime();

		$entry = new \Mu\Core\Log\Entry(array(
			'message' => 'Hello world',
			'timestamp' => $ts,
			'extra' => 'test'
		));

		$this->assertEquals('Hello world', $entry->getOption('message'));
		$this->assertEquals(getmypid(), $entry->getOption('pid'));
		$this->assertEquals(LOG_INFO, $entry->getOption('level'));
		$this->assertEquals($ts, $entry->getOption('timestamp'));
		$this->assertNull($entry->getOption('category'));
		$this->assertEquals('test', $entry->getOption('extra'));
	}
}