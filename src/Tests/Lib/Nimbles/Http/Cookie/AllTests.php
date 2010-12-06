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
 * @package    Nimbles-Http
 * @subpackage Cookie
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Http\Cookie;

require_once 'JarTest.php';

use Nimbles\Http\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Cookie
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Http
 * @group      Cookie
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - Http
     * @return \PHPUnit_Framework_TestSuite
     */
    public static function suite() {
        $suite = new TestSuite('Nimbles Framework - Http - Cookie');

        $suite->addTestSuite('\Tests\Lib\Nimbles\Http\Cookie\JarTest');

        return $suite;
    }
}
