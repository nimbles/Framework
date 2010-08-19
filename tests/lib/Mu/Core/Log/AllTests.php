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

namespace Tests\Lib\Mu\Core\Log;

require_once 'EntryTest.php';
require_once 'LoggableTest.php';
require_once 'Filter/AllTests.php';
require_once 'Formatter/AllTests.php';
require_once 'Writer/AllTests.php';

use Mu\Core\TestSuite;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestSuite
 *
 * @group      Mu
 * @group      Mu-Core
 * @group      Mu-Core-Log
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Mu Framework - Core - Log
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('Mu Framework - Core - Log');

        $suite->addTestSuite('\Tests\Lib\Mu\Core\Log\EntryTest');
        $suite->addTestSuite('\Tests\Lib\Mu\Core\Log\LoggableTest');

        $suite->addTest(Filter\AllTests::suite());
        $suite->addTest(Formatter\AllTests::suite());
        $suite->addTest(Writer\AllTests::suite());

        return $suite;
    }
}
