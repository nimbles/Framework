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
 * @package    Nimbles-App
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\App;

require_once 'ConfigTest.php';
require_once 'Config/AllTests.php';

use Nimbles\App\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\App\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-App
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - App
     * @return \Nimbles\App\TestSuite
     */
    public static function suite() {
        $suite = new TestSuite('Nimbles Framework - App');
        
        $suite->addTestSuite('Tests\Lib\Nimbles\App\ConfigTest');
        $suite->addTest(Config\AllTests::suite());

        return $suite;
    }
}
