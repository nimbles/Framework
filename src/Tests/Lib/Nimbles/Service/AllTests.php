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
 * @package    Nimbles-Service
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Service;

require_once 'Http/AllTests.php';
require_once 'Request/AllTests.php';
require_once 'Response/AllTests.php';

use Nimbles\Service\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles-Service
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Service\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Service
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - Service
     * @return \Nimbles\Service\TestSuite
     */
    public static function suite() {
        $suite = new TestSuite('Nimbles Framework - Service');
        
        $suite->addTest(Http\AllTests::suite());
        $suite->addTest(Request\AllTests::suite());
        $suite->addTest(Response\AllTests::suite());

        return $suite;
    }
}
