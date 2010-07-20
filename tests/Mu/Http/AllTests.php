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
 * @package   Mu\Http
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Mu\Http;

require_once 'PHPUnit/Framework.php';
require_once 'HeaderTest.php';
require_once 'RequestTest.php';

/**
 * @category  Mu
 * @package   Mu\Http
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Http
 */
class AllTests {
	/**
	 * Creates the Test Suite for Mu Framework - Http
	 * @return \PHPUnit_Framework_TestSuite
	 */
	static public function suite() {
		$suite = new \PHPUnit_Framework_TestSuite('Mu Framework - Http');
		$suite->addTestSuite('\Tests\Mu\Http\HeaderTest');
		$suite->addTestSuite('\Tests\Mu\Http\RequestTest');
		return $suite;
	}
}