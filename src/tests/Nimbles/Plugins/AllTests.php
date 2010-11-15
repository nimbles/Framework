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
 * @package    Nimbles-Plugins
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Plugins;

require_once 'PluginTest.php';
require_once 'CollectionTest.php';

use Nimbles\Plugins\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles-Plugins
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Plugins\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Plugins
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - Plugins
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('Nimbles Framework - Plugins');
        
        $suite->addTestSuite('\Tests\Lib\Nimbles\Plugins\PluginTest');
        $suite->addTestSuite('\Tests\Lib\Nimbles\Plugins\CollectionTest');
        
        return $suite;
    }
}
