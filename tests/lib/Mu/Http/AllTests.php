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
 * @package    Mu-Http
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Http;

require_once 'ClientTest.php';
require_once 'CookieTest.php';
require_once 'Cookie/AllTests.php';
require_once 'HeaderTest.php';
require_once 'StatusTest.php';
require_once 'RequestTest.php';
require_once 'ResponseTest.php';

use Mu\Http\TestSuite;

/**
 * @category   Mu
 * @package    Mu-Http
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestSuite
 *
 * @group      Mu
 * @group      Mu-Http
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Mu Framework - Http
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('Mu Framework - Http');

        $suite->addTestSuite('\Tests\Lib\Mu\Http\ClientTest');
        $suite->addTestSuite('\Tests\Lib\Mu\Http\CookieTest');
        $suite->addTest(Cookie\AllTests::suite());
        $suite->addTestSuite('\Tests\Lib\Mu\Http\HeaderTest');
        $suite->addTestSuite('\Tests\Lib\Mu\Http\StatusTest');
        $suite->addTestSuite('\Tests\Lib\Mu\Http\RequestTest');
        $suite->addTestSuite('\Tests\Lib\Mu\Http\ResponseTest');

        return $suite;
    }
}
