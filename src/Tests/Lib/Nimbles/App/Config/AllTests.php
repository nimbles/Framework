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
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\App\Config;

require_once 'ConfigurableTest.php';
require_once 'File/AllTests.php';

use Nimbles\App\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\App\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-App
 * @group      Nimbles-App-Config
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - App- Config
     * @return \PHPUnit_Framework_TestSuite
     */
    public static function suite() {
        $suite = new TestSuite('Nimbles Framework - App- Config');
        
        $suite->addTestSuite('\Tests\Lib\Nimbles\App\Config\ConfigurableTest');
        $suite->addTest(File\AllTests::suite());
        
        return $suite;
    }
}
