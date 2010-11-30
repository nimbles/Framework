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
 * @package    Nimbles-Adapter
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Adapter;

require_once 'AdapterTest.php';

use Nimbles\Adapter\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles-Adapter
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Adapter\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Adapter
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - Adapter
     * @return \PHPUnit_Framework_TestSuite
     */
    public static function suite() {
        $suite = new TestSuite('Nimbles Framework - Adapter');
        
        $suite->addTestSuite('\Tests\Lib\Nimbles\Adapter\AdapterTest');
        
        return $suite;
    }
}
