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
 * @package    Nimbles-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Adapter;

require_once 'AdaptableTest.php';

use Nimbles\Core\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Core
 * @group      Nimbles-Core-Adapter
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - Core - Config
     * @return \Nimbles\Core\TestSuite
     */
    public static function suite() {
        $suite = new TestSuite('Nimbles Framework - Core - Adapter');

        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\Adapter\AdaptableTest');

        return $suite;
    }
}
