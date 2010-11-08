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
 * @package    Nimbles-Core
 * @subpackage Delegates
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Delegates;

require_once 'DelegatableMock.php';

use Nimbles\Core\TestCase;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Delegates
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Core
 * @group      Nimbles-Core-Delegates
 */
class DelegatableTest extends TestCase {
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

        $this->assertType('\Closure', $mock->getDelegate('method1'));
        $this->assertType('\Closure', $mock->getDelegate('method2'));

        $mock->setDelegate('method1', function() {
            return 'test';
        });

        $this->assertEquals('test', $mock->method1());
    }

    /**
     * Tests that the \Nimbles\Core\Delegates\Exception\InvalidDelegate exception is thrown
     * when setting an invalid delegate
     * @return void
     */
    public function testInvalidDelegate() {
        $this->setExpectedException('\Nimbles\Core\Delegates\Exception\InvalidDelegate');

        $mock = new DelegatableMock();
        $mock->setDelegate('method1', 1);
    }
}