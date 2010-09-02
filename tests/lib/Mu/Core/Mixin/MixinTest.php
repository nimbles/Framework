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
 * @subpackage Mixin
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Core\Mixin;

require_once 'MixinMock.php';

use Mu\Core\TestCase;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Mixin
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestCase
 *
 * @group      Mu
 * @group      Mu-Core
 * @group      Mu-Core-Mixin
 */
class MixinTest extends TestCase {
    /**
     * Tests that the \Mu\Core\Mixin\Exception\MixinableMissing exception is thrown
     * when trying to add a mixinable that does not exist
     * @return void
     */
    public function testInvalidMixin() {
        $this->setExpectedException('\Mu\Core\Mixin\Exception\MixinableMissing');
        $invalidMixin = new MixinInvalid();
        $invalidMixin->getMixins();
    }

    /**
     * Tests that the SPL BadMethodCallException exception is thrown when
     * trying to call a method that does not exist
     * @return void
     */
    public function testBadCall() {
        $this->setExpectedException('\BadMethodCallException');
        $emptyMixin = new MixinEmpty();
        $emptyMixin->doSomething();
    }
}
