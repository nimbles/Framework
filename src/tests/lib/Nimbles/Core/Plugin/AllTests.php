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
 * @package    Nimbles-Core
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Plugin;

require_once 'PluginsTest.php';
require_once 'PluginableTest.php';

use Nimbles\Core\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Core
 * @group      Nimbles-Core-Plugin
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - Core - Plugin
     * @return \PHPUnit_Framework_TestSuite
     */
    public static function suite() {
        $suite = new \PHPUnit_Framework_TestSuite('Nimbles Framework - Core - Plugin');

        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\Plugin\PluginsTest');
        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\Plugin\PluginableTest');

        return $suite;
    }
}
