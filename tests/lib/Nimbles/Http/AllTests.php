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
 * @package    Nimbles-Http
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Http;

require_once 'ClientTest.php';
require_once 'Client/AllTests.php';
require_once 'CookieTest.php';
require_once 'Cookie/AllTests.php';
require_once 'HeaderTest.php';
require_once 'SessionTest.php';
require_once 'StatusTest.php';
require_once 'RequestTest.php';
require_once 'ResponseTest.php';

use Nimbles\Http\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles-Http
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Http\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Http
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - Http
     * @return \Nimbles\Http\TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('Nimbles Framework - Http');

        $suite->addTestSuite('\Tests\Lib\Nimbles\Http\ClientTest');
        $suite->addTest(Client\AllTests::suite());
        $suite->addTestSuite('\Tests\Lib\Nimbles\Http\CookieTest');
        $suite->addTest(Cookie\AllTests::suite());
        $suite->addTestSuite('\Tests\Lib\Nimbles\Http\HeaderTest');
        $suite->addTestSuite('\Tests\Lib\Nimbles\Http\SessionTest');
        $suite->addTestSuite('\Tests\Lib\Nimbles\Http\StatusTest');
        $suite->addTestSuite('\Tests\Lib\Nimbles\Http\RequestTest');
        $suite->addTestSuite('\Tests\Lib\Nimbles\Http\ResponseTest');

        return $suite;
    }
}
