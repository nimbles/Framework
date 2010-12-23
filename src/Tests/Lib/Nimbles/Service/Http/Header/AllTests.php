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
 * @package    Nimbles-Service
 * @subpackage Http
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Service\Http\Header;

require_once 'CollectionTest.php';

use Nimbles\Service\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles-Service
 * @subpackage Http
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Service\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Service
 * @group      Nimbles-Service-Http
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - Service - Http
     * @return \Nimbles\Service\TestSuite
     */
    public static function suite() {
        $suite = new TestSuite('Nimbles Framework - Service - Http - Header');
        
        $suite->addTestSuite('Tests\Lib\Nimbles\Service\Http\Header\CollectionTest');
        
        return $suite;
    }
}