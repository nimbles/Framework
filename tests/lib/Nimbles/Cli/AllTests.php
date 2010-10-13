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
 * @package    Nimbles-Cli
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Cli;

require_once 'RequestTest.php';
require_once 'ResponseTest.php';
require_once 'OptTest.php';
require_once 'Opt/AllTests.php';

use Nimbles\Cli\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles-Cli
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Cli\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Cli
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - Cli
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('Nimbles Framework - Cli');

        $suite->addTestSuite('\Tests\Lib\Nimbles\Cli\RequestTest');
        $suite->addTestSuite('\Tests\Lib\Nimbles\Cli\ResponseTest');
        $suite->addTestSuite('\Tests\Lib\Nimbles\Cli\OptTest');

        $suite->addTest(Opt\AllTests::suite());

        return $suite;
    }
}
