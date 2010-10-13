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
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Config;

require_once 'FileTest.php';
require_once 'DirectoryTest.php';
require_once 'ConfigurableTest.php';
require_once 'OptionsTest.php';

use Nimbles\Core\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Core
 * @group      Nimbles-Core-Config
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - Core - Config
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('Nimbles Framework - Core - Config');

        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\Config\FileTest');
        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\Config\DirectoryTest');
        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\Config\ConfigurableTest');
        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\Config\OptionsTest');

        return $suite;
    }
}
