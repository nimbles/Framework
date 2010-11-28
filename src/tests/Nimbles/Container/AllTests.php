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
 * @package    Nimbles-Container
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Container;

require_once 'ContainerTest.php';

use Nimbles\Container\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles-Container
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Container\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Container
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - Container
     * @return \PHPUnit_Framework_TestSuite
     */
    public static function suite() {
        $suite = new TestSuite('Nimbles Framework - Container');
        
        $suite->addTestSuite('\Tests\Lib\Nimbles\Container\ContainerTest');
        
        return $suite;
    }
}
