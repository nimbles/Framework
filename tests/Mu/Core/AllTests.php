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
 * @package   Mu\Core
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Core
 */

namespace Tests\Mu\Core;

require_once 'Config/AllTests.php';
require_once 'Mixin/AllTests.php';
require_once 'Plugin/AllTests.php';
require_once 'Log/AllTests.php';

/**
 * @category  Mu
 * @package   Mu\Http
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Http
 */
class AllTests {
    /**
     * Creates the Test Suite for Mu Framework - Core
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new \PHPUnit_Framework_TestSuite('Mu Framework - Core');
        $suite->addTest(Config\AllTests::suite());
        $suite->addTest(Mixin\AllTests::suite());
        $suite->addTest(Plugin\AllTests::suite());
        $suite->addTest(Log\AllTests::suite());
        return $suite;
    }
}
