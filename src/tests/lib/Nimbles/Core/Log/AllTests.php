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

namespace Tests\Lib\Nimbles\Core\Log;

require_once 'EntryTest.php';
require_once 'LoggableTest.php';
require_once 'Filter/AllTests.php';
require_once 'Formatter/AllTests.php';
require_once 'Writer/AllTests.php';

use Nimbles\Core\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Core
 * @group      Nimbles-Core-Log
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - Core - Log
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('Nimbles Framework - Core - Log');

        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\Log\EntryTest');
        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\Log\LoggableTest');

        $suite->addTest(Filter\AllTests::suite());
        $suite->addTest(Formatter\AllTests::suite());
        $suite->addTest(Writer\AllTests::suite());

        return $suite;
    }
}
