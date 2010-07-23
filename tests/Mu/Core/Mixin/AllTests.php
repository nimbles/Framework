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
 * @category  Mu
 * @package   Mu\Core\Mixin
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Core\Mixin
 */

namespace Tests\Mu\Core\Mixin;

require_once 'MixinTest.php';
require_once 'MixinableTest.php';

/**
 * @category  Mu
 * @package   Mu\Core\Mixin
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Core\Mixin
 */
class AllTests {
    /**
     * Creates the Test Suite for Mu Framework - Core - Mixin
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new \PHPUnit_Framework_TestSuite('Mu Framework - Core - Mixin');
        $suite->addTestSuite('\Tests\Mu\Core\Mixin\MixinTest');
        $suite->addTestSuite('\Tests\Mu\Core\Mixin\MixinableTest');
        return $suite;
    }
}
