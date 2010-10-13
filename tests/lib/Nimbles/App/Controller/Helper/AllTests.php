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

namespace Tests\Lib\Nimbles\App\Controller\Helper;

require_once 'HelperTest.php';

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
     * Creates the Test Suite for Nimbles Framework - App - Controller - Helper
     * @return \Nimbles\App\TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('Nimbles Framework - App - Controller - Helper');

        $suite->addTestSuite('\Tests\Lib\Nimbles\App\Controller\Helper\HelperTest');
        return $suite;
    }
}
