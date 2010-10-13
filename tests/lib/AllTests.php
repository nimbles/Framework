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

namespace Tests\Lib;

require_once 'PHPUnit/Framework.php';
require_once 'Nimbles/AllTests.php';

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
    static public function suite() {
        $suite = new TestSuite('All Tests');
        $suite->addTest(Nimbles\AllTests::suite());
        return $suite;
    }
}
