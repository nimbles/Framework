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
 * @package    Mu-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Core\Log\Filter;

require_once 'LevelTest.php';
require_once 'CategoryTest.php';

use Mu\Core\TestSuite;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestSuite
 *
 * @group      Mu
 * @group      Mu-Core
 * @group      Mu-Core-Log
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Mu Framework - Core - Log - Filter
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('Mu Framework - Core - Log - Filter');
        $suite->addTestSuite('\Tests\Lib\Mu\Core\Log\Filter\LevelTest');
        $suite->addTestSuite('\Tests\Lib\Mu\Core\Log\Filter\CategoryTest');
        return $suite;
    }
}
