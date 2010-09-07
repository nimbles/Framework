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

namespace Tests\Lib\Mu\Core;

require_once 'Plugin/PluginMock.php';

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
class PluginTest extends TestCase {
    /**
     * Tests that the plugin system implements the observer pattern
     * @return void
     */
    public function testPluginsAreUpdated() {
        $plugin1 = $this->getMock('\Tests\Lib\Mu\Core\Plugin\PluginObserver', array('update'));
        $plugin1->expects($this->once())
            ->method('update')
            ->with($this->equalTo(true));

        $plugin2 = $this->getMock('\Tests\Lib\Mu\Core\Plugin\PluginObserver', array('update'));
        $plugin2->expects($this->once())
            ->method('update')
            ->with($this->equalTo(true));

        $plugins = new \Mu\Core\Plugin();
        $plugins->attach('plugin1', $plugin1);
        $plugins->attach('plugin2', $plugin2);

        $plugins->notify(true);
    }

    /**
     * Tests that the plugin class provides accesses methods for the plugins
     * @return void
     */
    public function testPluginAccesses() {
        $plugins = new \Mu\Core\Plugin();
        $plugins->plugin = new Plugin\PluginSingle();

        $this->assertType('\Tests\Lib\Mu\Core\Plugin\PluginSingle', $plugins->plugin);
        $this->assertTrue(isset($plugins->plugin));
        unset($plugins->plugin);
        $this->assertFalse(isset($plugins->plugin));
    }

    /**
     * Tests getting a plugin by its name
     * @return void
     */
    public function testPluginGetter() {
        $plugins = new \Mu\Core\Plugin();
        $plugins->plugin = new Plugin\PluginSingle();

        $this->assertType('\Tests\Lib\Mu\Core\Plugin\PluginSingle', $plugins->getPlugin('plugin'));
        $this->assertNull($plugins->getPlugin('foo'));
    }

    /**
     * Tests that an unknown error is raised
     * @return void
     */
    public function testAttachUnknownError() {
        $plugins = new \Mu\Core\Plugin();

        $this->setExpectedException('Mu\Core\Plugin\Exception');
        $plugins->attach('foo', null);
    }

    /**
     * Tests the plugins system rejects plugins which do not extend a given abstract
     * @return void
     */
    public function testPluginOptionsInvalidAbstract() {
        $plugins = new \Mu\Core\Plugin(array(
            'abstract' => '\Tests\Lib\Mu\Core\Plugin\PluginAbstract'
        ));

        $plugins->attach('plugin', new Plugin\PluginConcrete());
        $this->assertType('\Tests\Lib\Mu\Core\Plugin\PluginAbstract', $plugins->getPlugin('plugin'));

        $this->setExpectedException('\Mu\Core\Plugin\Exception\InvalidAbstract');
        $plugins->plugin = new Plugin\PluginSingle();
    }

    /**
     * Tests the plugins system rejects plugins which do not implement a given interface
     * @return void
     */
    public function testPluginOptionsInvalidInterface() {
        $plugins = new \Mu\Core\Plugin(array(
            'interface' => '\Tests\Lib\Mu\Core\Plugin\PluginInterface'
        ));

        $plugins->attach('plugin', new Plugin\PluginImplementor());
        $this->assertType('\Tests\Lib\Mu\Core\Plugin\PluginInterface', $plugins->getPlugin('plugin'));

        $this->setExpectedException('\Mu\Core\Plugin\Exception\InvalidInterface');
        $plugins->plugin = new Plugin\PluginSingle();
    }

    /**
     * Tests loading a plugin by a string
     * @return void
     */
    public function testPluginLoadingByString() {
        $plugins = new \Mu\Core\Plugin();
        $plugins->attach('plugin', '\Tests\Lib\Mu\Core\Plugin\PluginSingle');
        $this->assertType('\Tests\Lib\Mu\Core\Plugin\PluginSingle', $plugins->getPlugin('plugin'));
    }

    /**
     * Tests plugin not found when loading by string
     * @return void
     */
    public function testPluginNotFound() {
        $plugins = new \Mu\Core\Plugin();
        $this->setExpectedException('\Mu\Core\Plugin\Exception\PluginNotFound');

        $plugins->attach('plugin', '\Tests\Lib\Mu\Core\Plugin\MissingPlugin');
    }
}
