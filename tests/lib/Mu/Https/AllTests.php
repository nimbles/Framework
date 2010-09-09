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
 * @package    Mu-Https
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Https;

require_once 'RequestTest.php';
require_once 'ResponseTest.php';

use Mu\Http\TestSuite;

/**
 * @category   Mu
 * @package    Mu-Http
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Https\TestSuite
 *
 * @group      Mu
 * @group      Mu-Https
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Mu Framework - Https
     * @return \Mu\Https\TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('Mu Framework - Https');

        $suite->addTestSuite('\Tests\Lib\Mu\Https\RequestTest');
        $suite->addTestSuite('\Tests\Lib\Mu\Https\ResponseTest');

        return $suite;
    }
}
