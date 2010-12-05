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

require_once 'CollectionTest.php';
require_once 'ContainerTest.php';
require_once 'Container/AllTests.php';
require_once 'EventTest.php';
require_once 'Event/AllTests.php';
require_once 'LoaderTest.php';
require_once 'Pattern/AllTests.php';
require_once 'PluginTest.php';
require_once 'Plugin/AllTests.php';

/*
require_once 'DelegatesTest.php';
require_once 'Delegates/AllTests.php';

require_once 'LogTest.php';
require_once 'Log/AllTests.php';
require_once 'Mixin/AllTests.php';
*/

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
    public static function suite() {
        $suite = new TestSuite('Nimbles Framework - Core');

        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\CollectionTest');
        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\ContainerTest');
        $suite->addTest(Container\AllTests::suite());
        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\EventTest');
        $suite->addTest(Event\AllTests::suite());
        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\LoaderTest');
        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\PluginTest');
        $suite->addTest(Plugin\AllTests::suite());
        $suite->addTest(Pattern\AllTests::suite());
        
        return $suite;
    }
}
