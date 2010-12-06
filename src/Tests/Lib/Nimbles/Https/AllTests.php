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
 * @package    Nimbles-Https
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Https;

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
 * @uses       \Nimbles\Https\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Https
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - Https
     * @return \Nimbles\Https\TestSuite
     */
    public static function suite() {
        $suite = new TestSuite('Nimbles Framework - Https');

        $suite->addTestSuite('\Tests\Lib\Nimbles\Https\RequestTest');
        $suite->addTestSuite('\Tests\Lib\Nimbles\Https\ResponseTest');

        return $suite;
    }
}
