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
 * @package    Nimbles
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests;

require_once 'lib/AllTests.php';

use Nimbles\Core\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestSuite
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for All Tests
     * @return \Nimbles\Core\TestSuite
     */
    public static function suite() {
        $suite = new TestSuite('All Tests');
        $suite->addTest(Lib\AllTests::suite());
        return $suite;
    }
}
