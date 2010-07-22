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
 * @package   Mu\Core\Log\Writer
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Core\Log
 * @group     Mu\Core\Log\Writer
 */

namespace Tests\Mu\Core\Log\Writer;

require_once 'StreamTest.php';
require_once 'MockTest.php';

/**
 * @category  Mu
 * @package   Mu\Core\Log\Writer
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Core\Log
 * @group     Mu\Core\Log\Writer
 */
class AllTests {
	/**
	 * Creates the Test Suite for Mu Framework - Core - Log - Writer
	 * @return \PHPUnit_Framework_TestSuite
	 */
	static public function suite() {
		$suite = new \PHPUnit_Framework_TestSuite('Mu Framework - Core - Log - Writer');
		$suite->addTestSuite('\Tests\Mu\Core\Log\Writer\StreamTest');
		$suite->addTestSuite('\Tests\Mu\Core\Log\Writer\MockTest');
		return $suite;
	}
}