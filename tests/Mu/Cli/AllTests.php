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
 * @package   \Mu\Cli
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     \Mu\Cli
 */

namespace Tests\Mu\Cli;

require_once 'PHPUnit/Framework.php';
require_once 'OptTest.php';
require_once 'RequestTest.php';
require_once 'ResponseTest.php';

/**
 * @category  Mu
 * @package   \Mu\Cli
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     \Mu\Cli
 */
class AllTests {
    /**
     * Creates the Test Suite for Mu Framework - Cli
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new \PHPUnit_Framework_TestSuite('Mu Framework - Cli');
        $suite->addTestSuite('\Tests\Mu\Cli\OptTest');
        $suite->addTestSuite('\Tests\Mu\Cli\RequestTest');
        $suite->addTestSuite('\Tests\Mu\Cli\ResponseTest');
        return $suite;
    }
}
