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
 * @category   Mu
 * @package    Mu
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib;

require_once 'PHPUnit/Framework.php';
require_once 'Mu/AllTests.php';

use Mu\Core\TestSuite;

/**
 * @category   Mu
 * @package    Mu
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestSuite
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for All Tests
     * @return \Mu\Core\TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('All Tests');
        $suite->addTest(Mu\AllTests::suite());
        return $suite;
    }
}
