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
 * @package    Mu-App
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\lib\Mu\App;

require_once 'Controller/AllTests.php';

use Mu\App\TestSuite;

/**
 * @category   Mu
 * @package    Mu-App
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\App\TestSuite
 *
 * @group      Mu
 * @group      Mu-App
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Mu Framework - App
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('Mu Framework - App');

        $suite->addTest(Controller\AllTests::suite());

        return $suite;
    }
}
