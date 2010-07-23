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
 * @package   Mu
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Mu;

require_once 'PHPUnit/Framework.php';
require_once 'Core/AllTests.php';
require_once 'Cli/AllTests.php';
require_once 'Http/AllTests.php';

/**
 * @category  Mu
 * @package   Mu
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
class AllTests {
    /**
     * Creates the Test Suite for All Tests
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new \PHPUnit_Framework_TestSuite('Mu Framework');

        $suite->addTest(Core\AllTests::suite());
        $suite->addTest(Cli\AllTests::suite());
        $suite->addTest(Http\AllTests::suite());

        return $suite;
    }
}
