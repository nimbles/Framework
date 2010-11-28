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
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\App\Controller;

require_once 'ControllerTest.php';
require_once 'Helper/AllTests.php';
require_once 'Plugin/AllTests.php';
require_once 'Resource/AllTests.php';

use Nimbles\App\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\App\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-App
 * @group      Nimbles-App-Controller
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - App - Controller
     * @return \Nimbles\App\TestSuite
     */
    public static function suite() {
        $suite = new TestSuite('Nimbles Framework - App - Controller');

        $suite->addTestSuite('\Tests\Lib\Nimbles\App\Controller\ControllerTest');

        $suite->addTest(Helper\AllTests::suite());
        $suite->addTest(Plugin\AllTests::suite());
        $suite->addTest(Resource\AllTests::suite());

        return $suite;
    }
}
