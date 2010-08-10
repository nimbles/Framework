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
 * @package   \Mu\Core\Delegates
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     \Mu\Core\Delegates
 */

namespace Tests\Mu\Core\Delegates;

require_once 'DelegatableTest.php';

/**
 * @category  Mu
 * @package   \Mu\Core\Delegates
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     \Mu\Core\Delegates
 */
class AllTests {
    /**
     * Creates the Test Suite for Mu Framework - Core - Delegates
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new \PHPUnit_Framework_TestSuite('Mu Framework - Core - Delegates');

        $suite->addTestSuite('\Tests\Mu\Core\Delegates\DelegatableTest');
        return $suite;
    }
}
