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
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Core\Adapter;

require_once 'AdaptableTest.php';

use Mu\Core\TestSuite;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestSuite
 *
 * @group      Mu
 * @group      Mu-Core
 * @group      Mu-Core-Adapter
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Mu Framework - Core - Config
     * @return \Mu\Core\TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('Mu Framework - Core - Adapter');

        $suite->addTestSuite('\Tests\Lib\Mu\Core\Adapter\AdaptableTest');

        return $suite;
    }
}
