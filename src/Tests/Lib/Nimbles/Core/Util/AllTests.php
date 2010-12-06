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
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Util;

require_once 'InstanceTest.php';
require_once 'TypeTest.php';

use Nimbles\Core\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Plugin\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Core
 * @group      Nimbles-Core-Util
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - Core- Util
     * @return \PHPUnit_Framework_TestSuite
     */
    public static function suite() {
        $suite = new TestSuite('Nimbles Framework - Core- Util');
        
        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\Util\InstanceTest');
        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\Util\TypeTest');
        
        return $suite;
    }
}
