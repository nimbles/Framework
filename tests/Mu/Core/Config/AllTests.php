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
 * @category  Mu
 * @package   \Mu\Core\Config
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     \Mu\Core\Config
 */

namespace Tests\Mu\Core\Config;

require_once 'ConfigTest.php';
require_once 'FileTest.php';
require_once 'DirectoryTest.php';
require_once 'ConfigurableTest.php';
require_once 'OptionsTest.php';

/**
 * @category  Mu
 * @package   \Mu\Core\Config
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     \Mu\Core\Config
 */
class AllTests {
    /**
     * Creates the Test Suite for Mu Framework - Core - Config
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new \PHPUnit_Framework_TestSuite('Mu Framework - Core - Config');
        $suite->addTestSuite('\Tests\Mu\Core\Config\ConfigTest');
        $suite->addTestSuite('\Tests\Mu\Core\Config\FileTest');
        $suite->addTestSuite('\Tests\Mu\Core\Config\DirectoryTest');
        $suite->addTestSuite('\Tests\Mu\Core\Config\ConfigurableTest');
        $suite->addTestSuite('\Tests\Mu\Core\Config\OptionsTest');
        return $suite;
    }
}
