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

namespace Tests\Lib\Nimbles\Core;

use \Nimbles\Core\TestCase,
    Nimbles\Core\Delegates;

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
class DelegatesTest extends TestCase {
    /**
     * Tests that the Delegates class extends the Mixin abstract
     * @return void
     */
    public function testAbstract() {
        $delegates = new Delegates();
        $this->assertType('\Nimbles\Core\Mixin\MixinAbstract', $delegates);
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

        $this->setExpectedException('Nimbles\Core\Delegates\Exception\DelegateCreationNotAllowed');
        $delegates->setDelegate('method3', $func1);
    }

    /**
     * Tests that setting a numeric array as delegates throws the
     * Nimbles\Core\Delegates\Exception\InvalidDelegateName exception
     * @return void
     */
    public function testSetDeletagesInvalidDelegateName() {
        $delegates = new Delegates();
        $this->setExpectedException('Nimbles\Core\Delegates\Exception\InvalidDelegateName');
        $delegates->setDelegates(array('foo'));
    }

    public function testSetDelegatesInvalidDelegate() {
        $delegates = new Delegates();
        $this->setExpectedException('Nimbles\Core\Delegates\Exception\InvalidDelegate');
        $delegates->setDelegates(array('foo' => null));
    }
}