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
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */
namespace Tests\Lib\Nimbles\Http\Client;

require_once 'Adapter/AllTests.php';
require_once 'RequestTest.php';
require_once 'ResponseTest.php';

use Nimbles\Http\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Http\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Http
 * @group      Nimbles-Http-Client
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - Http - Client
     * @return \PHPUnit_Framework_TestSuite
     */
    public static function suite() {
        $suite = new TestSuite('Nimbles Framework - Http - Client');

        $suite->addTest(Adapter\AllTests::suite());
        $suite->addTestSuite('\Tests\Lib\Nimbles\Http\Client\RequestTest');
        $suite->addTestSuite('\Tests\Lib\Nimbles\Http\Client\ResponseTest');

        return $suite;
    }
}
