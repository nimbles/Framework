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
namespace Tests\Lib\Nimbles\Http\Client\Adapter;

require_once 'CurlTest.php';

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
 * @group      Nimbles-Http-Client-Adapter
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - Http - Client - Adapter
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('Nimbles Framework - Http - Client - Adapter');

        $suite->addTestSuite('\Tests\Lib\Nimbles\Http\Client\Adapter\CurlTest');

        return $suite;
    }
}
