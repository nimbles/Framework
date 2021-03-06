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
 * @package    Nimbles
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles;

require_once 'NimblesTest.php';
require_once 'Core/AllTests.php';
require_once 'App/AllTests.php';

use Nimbles\Core\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestSuite
 *
 * @group      Nimbles
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for All Tests
     * @return \Nimbles\Core\TestSuite
     */
    public static function suite() {
        $suite = new TestSuite('Nimbles Framework');

        $suite->addTestSuite('\Tests\Lib\Nimbles\NimblesTest');

        $suite->addTest(Core\AllTests::suite());
        $suite->addTest(App\AllTests::suite());

        return $suite;
    }
}
