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
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\App\Controller;

require_once 'ControllerTest.php';

use Mu\App\TestSuite;

/**
 * @category   Mu
 * @package    Mu-App
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\App\TestSuite
 *
 * @group      Mu
 * @group      Mu-App
 * @group      Mu-App-Controller
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Mu Framework - App - Controller
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new \PHPUnit_Framework_TestSuite('Mu Framework - App - Controller');

        $suite->addTestSuite('\Tests\Lib\Mu\App\Controller\ControllerTest');
        return $suite;
    }
}
