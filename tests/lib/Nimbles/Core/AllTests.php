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
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\lib\Nimbles\Core;

require_once 'Adapter/AllTests.php';
require_once 'CollectionTest.php';
require_once 'ConfigTest.php';
require_once 'Config/AllTests.php';
require_once 'DelegatesTest.php';
require_once 'Delegates/AllTests.php';
require_once 'LoaderTest.php';
require_once 'LogTest.php';
require_once 'Log/AllTests.php';
require_once 'Mixin/AllTests.php';
require_once 'PluginTest.php';
require_once 'Plugin/AllTests.php';

use Nimbles\Core\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Core
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - Core
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('Nimbles Framework - Core');

        $suite->addTest(Adapter\AllTests::suite());

        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\CollectionTest');

        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\ConfigTest');
        $suite->addTest(Config\AllTests::suite());

        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\DelegatesTest');
        $suite->addTest(Delegates\AllTests::suite());

        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\LoaderTest');

        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\LogTest');
        $suite->addTest(Log\AllTests::suite());

        $suite->addTest(Mixin\AllTests::suite());

        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\PluginTest');
        $suite->addTest(Plugin\AllTests::suite());

        return $suite;
    }
}
