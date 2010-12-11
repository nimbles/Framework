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
 * @package    Nimbles-App
 * @subpackage Http
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\App\Http\Header;

require_once 'CollectionTest.php';

use Nimbles\App\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Http
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\App\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-App
 * @group      Nimbles-App-Http
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - App - Http
     * @return \Nimbles\App\TestSuite
     */
    public static function suite() {
        $suite = new TestSuite('Nimbles Framework - App - Http - Header');
        
        $suite->addTestSuite('Tests\Lib\Nimbles\App\Http\Header\CollectionTest');
        
        return $suite;
    }
}
