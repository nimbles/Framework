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

namespace Tests\Lib\Mu\Cli\Opt;

require_once 'CollectionTest.php';

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
 * @group      Mu-Cli-Opt
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Mu Framework - Cli - Opt - Collection
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('Mu Framework - Cli - Opt - Collection');

        $suite->addTestSuite('\Tests\Lib\Mu\Cli\CollectionTest');

        return $suite;
    }
}
