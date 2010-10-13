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
 * @package    Nimbles-Cli
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Cli\Opt;

require_once 'CollectionTest.php';

use Nimbles\Cli\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles-Cli
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Cli\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Cli
 * @group      Nimbles-Cli-Opt
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - Cli - Opt - Collection
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('Nimbles Framework - Cli - Opt - Collection');

        $suite->addTestSuite('\Tests\Lib\Nimbles\Cli\CollectionTest');

        return $suite;
    }
}
