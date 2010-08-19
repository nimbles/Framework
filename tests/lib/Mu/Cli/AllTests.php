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
 * @package    Mu-Cli
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Cli;

require_once 'RequestTest.php';
require_once 'ResponseTest.php';
require_once 'OptTest.php';

use Mu\Cli\TestSuite;

/**
 * @category   Mu
 * @package    Mu-Cli
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Cli\TestSuite
 *
 * @group      Mu
 * @group      Mu-Cli
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Mu Framework - Cli
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new \PHPUnit_Framework_TestSuite('Mu Framework - Cli');

        $suite->addTestSuite('\Tests\Lib\Mu\Cli\RequestTest');
        $suite->addTestSuite('\Tests\Lib\Mu\Cli\ResponseTest');
        $suite->addTestSuite('\Tests\Lib\Mu\Cli\OptTest');

        return $suite;
    }
}
