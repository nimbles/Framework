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
 * @package    Mu
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu;

require_once 'MuTest.php';
require_once 'Core/AllTests.php';
require_once 'Cli/AllTests.php';
require_once 'Http/AllTests.php';

use Mu\Core\TestSuite;

/**
 * @category   Mu
 * @package    Mu
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestSuite
 *
 * @group      Mu
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for All Tests
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('Mu Framework');

        $suite->addTestSuite('\Tests\Lib\Mu\MuTest');

        $suite->addTest(Core\AllTests::suite());
        //$suite->addTest(Cli\AllTests::suite());
        $suite->addTest(Http\AllTests::suite());

        return $suite;
    }
}
