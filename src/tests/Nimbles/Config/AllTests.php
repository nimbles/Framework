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
 * @package    Nimbles-Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Config;

require_once 'ConfigTest.php';
require_once 'ConfigurableTest.php';
require_once 'File/AllTests.php';

use Nimbles\Config\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles-Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Config\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Config
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - Config
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('Nimbles Framework - Config');
        
        $suite->addTestSuite('\Tests\Lib\Nimbles\Config\ConfigTest');
        $suite->addTestSuite('\Tests\Lib\Nimbles\Config\ConfigurableTest');
        $suite->addTest(File\AllTests::suite());
        
        return $suite;
    }
}
