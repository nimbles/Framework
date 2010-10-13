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
 * @subpackage Mixin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Mixin;

require_once 'MixinMock.php';

use Nimbles\Core\TestCase;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Mixin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Core
 * @group      Nimbles-Core-Mixin
 */
class MixinTest extends TestCase {
    /**
     * Tests that the \Nimbles\Core\Mixin\Exception\MixinableMissing exception is thrown
     * when trying to add a mixinable that does not exist
     * @return void
     */
    public function testInvalidMixin() {
        $this->setExpectedException('\Nimbles\Core\Mixin\Exception\MixinableMissing');
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
