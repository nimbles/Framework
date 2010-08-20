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
 * @package    Mu-Core
 * @subpackage Delegates
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Core;

use \Mu\Core\TestCase,
    Mu\Core\Delegates;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Delegates
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestCase
 *
 * @group      Mu
 * @group      Mu-Core
 * @group      Mu-Core-Delegates
 */
class DelegatesTest extends TestCase {
    /**
     * Tests that the Delegates class extends the Mixin abstract
     * @return void
     */
    public function testAbstract() {
        $delegates = new Delegates();
        $this->assertType('\Mu\Core\Mixin\MixinAbstract', $delegates);
    }

    /**
     * Test getting and setting delegates
     * @return void
     */
    public function testGetSetDelegates() {
        $delegates = new Delegates();
        $this->assertType('\ArrayObject', $delegates->getDelegates());
        $this->assertEquals(0, $delegates->getDelegates()->count());

        $delegates->setDelegates(array(
            'method1' => function($arg1) {
                return true;
            },
            'method2' => function($arg1, $arg2) {
                return false;
            }
        ));

        $this->assertType('\ArrayObject', $delegates->getDelegates());
        $this->assertEquals(2, $delegates->getDelegates()->count());
        $this->assertTrue($delegates->hasDelegate('method1'));
        $this->assertTrue($delegates->hasDelegate('method2'));

        $func1 = $delegates->getDelegate('method1');
        $this->assertType('\Closure', $func1);
        $this->assertTrue($func1(1));

        $func2 = $delegates->getDelegate('method2');
        $this->assertType('\Closure', $func2);
        $this->assertFalse($func2(1, 2));

        $delegates->setDelegate('method1', $func2);
        $func1 = $delegates->getDelegate('method1');

        $this->assertType('\Closure', $func1);
        $this->assertFalse($func1(1, 2));

        $this->setExpectedException('Mu\Core\Delegates\Exception\DelegateCreationNotAllowed');
        $delegates->setDelegate('method3', $func1);
    }

    /**
     * Tests that setting a numeric array as delegates throws the
     * Mu\Core\Delegates\Exception\InvalidDelegateName exception
     * @return void
     */
    public function testSetDeletagesInvalidDelegateName() {
        $delegates = new Delegates();
        $this->setExpectedException('Mu\Core\Delegates\Exception\InvalidDelegateName');
        $delegates->setDelegates(array('foo'));
    }

    public function testSetDelegatesInvalidDelegate() {
        $delegates = new Delegates();
        $this->setExpectedException('Mu\Core\Delegates\Exception\InvalidDelegate');
        $delegates->setDelegates(array('foo' => null));
    }
}