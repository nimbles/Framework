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
 * @package   \Mu\Core\Delegates\Delegatable
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     \Mu\Core\Delegates
 */

namespace Tests\Mu\Core\Delegates;

require_once 'DelegatableMock.php';

/**
 * @category  Mu
 * @package   \Mu\Core\Delegates\Delegatable
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     \Mu\Core\Delegates
 */
class DelegatableTest extends \Mu\Core\TestCase {
    /**
     * Tests calling the delegates and replacing with another
     * @return void
     */
    public function testMockMethods() {
        $mock = new DelegatableMock();

        $this->assertTrue($mock->hasDelegate('method1'));
        $this->assertTrue($mock->hasDelegate('method2'));
        $this->assertFalse($mock->hasDelegate('method3'));

        $this->assertTrue($mock->method1());
        $this->assertFalse($mock->method2());

        $this->assertType('array', $mock->getDelegate('method1'));
        $this->assertType('array', $mock->getDelegate('method2'));

        $mock->setDelegate('method1', function() {
            return 'test';
        });

        $this->assertEquals('test', $mock->method1());
    }

    /**
     * Tests that the Mu\Core\Delegates\Exception\InvalidDelegate exception is thrown
     * when setting an invalid delegate
     * @return void
     */
    public function testInvalidDelegate() {
        $this->setExpectedException('\Mu\Core\Delegates\Exception\InvalidDelegate');

        $mock = new DelegatableMock();
        $mock->setDelegate('method1', 1);
    }
}