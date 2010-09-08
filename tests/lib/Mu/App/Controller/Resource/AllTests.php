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

namespace Tests\Lib\Mu\App\Controller\Resource;

require_once 'ResourceTest.php';

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
     * Creates the Test Suite for Mu Framework - App - Controller - Resource
     * @return \Mu\App\TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('Mu Framework - App - Controller - Resource');

        $suite->addTestSuite('\Tests\Lib\Mu\App\Controller\Resource\ResourceTest');
        return $suite;
    }
}
