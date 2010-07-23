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
 * @package   Mu\Core\Plugin
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Core\Plugin
 */

namespace Tests\Mu\Core\Plugin;

require_once 'PluginTest.php';
require_once 'PluginsTest.php';
require_once 'PluginableTest.php';

/**
 * @category  Mu
 * @package   Mu\Core\Plugin
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Core\Plugin
 */
class AllTests {
    /**
     * Creates the Test Suite for Mu Framework - Core - Plugin
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new \PHPUnit_Framework_TestSuite('Mu Framework - Core - Plugin');
        $suite->addTestSuite('\Tests\Mu\Core\Plugin\PluginTest');
        $suite->addTestSuite('\Tests\Mu\Core\Plugin\PluginsTest');
        $suite->addTestSuite('\Tests\Mu\Core\Plugin\PluginableTest');
        return $suite;
    }
}
