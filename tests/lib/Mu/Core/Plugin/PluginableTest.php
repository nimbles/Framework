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
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Core\Plugin;

require_once 'PluginMock.php';
require_once 'PluginableMock.php';

use Mu\Core\TestCase;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestCase
 *
 * @group      Mu
 * @group      Mu-Core
 * @group      Mu-Core-Plugin
 */
class PluginableTest extends TestCase {
    /**
     * Tests that the pluginable mixin adds a plugins property that behaves as expected
     * @return void
     */
    public function testMixnProperties() {
        $pluginable = new PluginableMock();

        $this->assertType('\Mu\Core\Plugin', $pluginable->simple);
        $this->assertType('\Mu\Core\Plugin', $pluginable->restricted);

        $pluginable->simple->plugin = new PluginSingle();
        $this->assertType('\Tests\Lib\Mu\Core\Plugin\PluginSingle', $pluginable->simple->plugin);

        $pluginable->restricted->plugin = new PluginConcrete();
        $this->assertType('\Tests\Lib\Mu\Core\Plugin\PluginAbstract', $pluginable->restricted->plugin);

        $this->setExpectedException('\Mu\Core\Plugin\Exception\InvalidAbstract');
        $pluginable->restricted->plugin = new PluginSingle();
    }

    /**
     * Tests that the pluginable mixin adds attach and detach methods that behave as expected
     * @return void
     */
    public function testMixinMethods() {
        $pluginable = new PluginableMock();
        $pluginable->attach('restricted', 'plugin', new PluginConcrete());
        $this->assertType('\Tests\Lib\Mu\Core\Plugin\PluginAbstract', $pluginable->restricted->plugin);
        $pluginable->detach('restricted', 'plugin');

        $this->assertFalse(isset($pluginable->plugins->restricted->plugin));
    }

    /**
     * Tests that a pluginable is a subject and the plugins observe it
     * @return void
     */
    public function testMixinObserver() {
        $pluginable = new PluginableMock();

        $plugin = $this->getMock('\Tests\Lib\Mu\Core\Plugin\PluginObserver', array('update'));
        $plugin->expects($this->exactly(4))
            ->method('update')
            ->with($this->equalTo($pluginable));


        $pluginable->attach('restricted', 'plugin', $plugin);
        $pluginable->attach('simple', 'plugin', $plugin);

        $pluginable->notify('restricted');
        $pluginable->notify('simple');
        $pluginable->notify();
    }
}
