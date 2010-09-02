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
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */
namespace Tests\Lib\Mu\Http\Client;

require_once 'Adapter/AllTests.php';
require_once 'RequestTest.php';
require_once 'ResponseTest.php';

use Mu\Http\TestSuite;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Http\TestSuite
 *
 * @group      Mu
 * @group      Mu-Http
 * @group      Mu-Http-Client
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Mu Framework - Http - Client
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('Mu Framework - Http - Client');

        $suite->addTest(Adapter\AllTests::suite());
        $suite->addTestSuite('\Tests\Lib\Mu\Http\Client\RequestTest');
        $suite->addTestSuite('\Tests\Lib\Mu\Http\Client\ResponseTest');

        return $suite;
    }
}
