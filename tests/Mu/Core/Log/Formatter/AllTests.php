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
 * @package   Mu\Core\Log\Formatter
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Core\Log
 * @group     Mu\Core\Log\Formatter
 */

namespace Tests\Mu\Core\Log\Formatter;

require_once 'SimpleTest.php';
require_once 'FormatterTest.php';

/**
 * @category  Mu
 * @package   Mu\Core\Log\Formatter
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Core\Log
 * @group     Mu\Core\Log\Formatter
 */
class AllTests {
	/**
	 * Creates the Test Suite for Mu Framework - Core - Log - Formatter
	 * @return \PHPUnit_Framework_TestSuite
	 */
	static public function suite() {
		$suite = new \PHPUnit_Framework_TestSuite('Mu Framework - Core - Log - Formatter');
		$suite->addTestSuite('\Tests\Mu\Core\Log\Formatter\SimpleTest');
		$suite->addTestSuite('\Tests\Mu\Core\Log\Formatter\FormatterTest');
		return $suite;
	}
}