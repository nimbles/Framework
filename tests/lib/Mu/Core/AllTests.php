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
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\lib\Mu\Core;

require_once 'Mixin/AllTests.php';
require_once 'Plugin/AllTests.php';

require_once 'ConfigTest.php';
require_once 'Config/AllTests.php';
require_once 'DelegatesTest.php';
require_once 'Delegates/AllTests.php';
require_once 'LogTest.php';
require_once 'Log/AllTests.php';

use Mu\Core\TestSuite;

/**
 * @category   Mu
 * @package    Mu-Core
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestSuite
 *
 * @group      Mu
 * @group      Mu-Core
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Mu Framework - Core
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('Mu Framework - Core');

        /*$suite->addTest(Config\AllTests::suite());
        $suite->addTest(Mixin\AllTests::suite());
        $suite->addTest(Plugin\AllTests::suite());
        */

        $suite->addTestSuite('\Tests\Lib\Mu\Core\ConfigTest');
        $suite->addTest(Config\AllTests::suite());

        $suite->addTestSuite('\Tests\Lib\Mu\Core\DelegatesTest');
        $suite->addTest(Delegates\AllTests::suite());

        $suite->addTestSuite('\Tests\Lib\Mu\Core\LogTest');
        $suite->addTest(Log\AllTests::suite());

        return $suite;
    }
}
