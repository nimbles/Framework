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
 * @package    Mu-Http
 * @subpackage Cookie
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Http\Cookie;

require_once 'JarTest.php';

use Mu\Http\TestSuite;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Cookie
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestSuite
 *
 * @group      Mu
 * @group      Mu-Http
 * @group      Cookie
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Mu Framework - Http
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('Mu Framework - Http - Cookie');

        $suite->addTestSuite('\Tests\Lib\Mu\Http\Cookie\JarTest');

        return $suite;
    }
}
