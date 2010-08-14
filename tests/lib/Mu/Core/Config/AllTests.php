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
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Core\Config;

require_once 'FileTest.php';
require_once 'DirectoryTest.php';
require_once 'ConfigurableTest.php';
require_once 'OptionsTest.php';

use Mu\Core\TestSuite;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestSuite
 *
 * @group      Mu
 * @group      Mu-Core
 * @group      Mu-Core-Config
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Mu Framework - Core - Config
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('Mu Framework - Core - Config');

        $suite->addTestSuite('\Tests\Lib\Mu\Core\Config\FileTest');
        $suite->addTestSuite('\Tests\Lib\Mu\Core\Config\DirectoryTest');
        $suite->addTestSuite('\Tests\Lib\Mu\Core\Config\ConfigurableTest');
        $suite->addTestSuite('\Tests\Lib\Mu\Core\Config\OptionsTest');

        return $suite;
    }
}
