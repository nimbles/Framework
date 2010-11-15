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
 * @package    Nimbles-Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Config\File;

require_once 'FileTest.php';

use Nimbles\Config\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles-Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Config\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Config
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - Config - File
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('Nimbles Framework - Config - File');
        
        $suite->addTestSuite('\Tests\Lib\Nimbles\Config\File\FileTest');
        
        return $suite;
    }
}
