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
 * @package   Mu\Core\Log\Filter
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Core\Log
 * @group     Mu\Core\Log\Filter
 */

namespace Tests\Mu\Core\Log\Filter;

require_once 'LevelTest.php';
require_once 'CategoryTest.php';

/**
 * @category  Mu
 * @package   Mu\Core\Log\Filter
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Core\Log
 * @group     Mu\Core\Log\Filter
 */
class AllTests {
    /**
     * Creates the Test Suite for Mu Framework - Core - Log - Filter
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new \PHPUnit_Framework_TestSuite('Mu Framework - Core - Log - Filter');
        $suite->addTestSuite('\Tests\Mu\Core\Log\Filter\LevelTest');
        $suite->addTestSuite('\Tests\Mu\Core\Log\Filter\CategoryTest');
        return $suite;
    }
}
