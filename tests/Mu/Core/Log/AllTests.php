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
 * @package   Mu\Core\Log
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Core\Log
 */

namespace Tests\Mu\Core\Log;

require_once 'Formatter/AllTests.php';
require_once 'Writer/AllTests.php';
require_once 'Filter/AllTests.php';
require_once 'EntryTest.php';
require_once 'LogTest.php';
require_once 'LoggableTest.php';

/**
 * @category  Mu
 * @package   Mu\Core\Log
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Core\Log
 */
class AllTests {
    /**
     * Creates the Test Suite for Mu Framework - Core - Log
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new \PHPUnit_Framework_TestSuite('Mu Framework - Core - Log');
        $suite->addTest(Formatter\AllTests::suite());
        $suite->addTest(Writer\AllTests::suite());
        $suite->addTest(Filter\AllTests::suite());

        $suite->addTestSuite('\Tests\Mu\Core\Log\EntryTest');
        $suite->addTestSuite('\Tests\Mu\Core\Log\LogTest');
        $suite->addTestSuite('\Tests\Mu\Core\Log\LoggableTest');
        return $suite;
    }
}
