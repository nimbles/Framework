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
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core;

require_once 'Plugin/PluginMock.php';

use Nimbles\Core\TestCase;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Core
 * @group      Nimbles-Core-Plugin
 */
class PluginTest extends TestCase {
    /**
     * Tests that the plugin system implements the observer pattern
     * @return void
     */
    public function testPluginsAreUpdated() {
        $plugin1 = $this->getMock('\Tests\Lib\Nimbles\Core\Plugin\PluginObserver', array('update'));
        $plugin1->expects($this->once())
            ->method('update')
            ->with($this->equalTo(true));

        $plugin2 = $this->getMock('\Tests\Lib\Nimbles\Core\Plugin\PluginObserver', array('update'));
        $plugin2->expects($this->once())
            ->method('update')
            ->with($this->equalTo(true));

        $plugins = new \Nimbles\Core\Plugin();
        $plugins->attach('plugin1', $plugin1);
        $plugins->attach('plugin2', $plugin2);

        $plugins->notify(true);
    }

    /**
     * Tests that the plugin class provides accesses methods for the plugins
     * @return void
     */
    public function testPluginAccesses() {
        $plugins = new \Nimbles\Core\Plugin();
        $plugins->plugin = new Plugin\PluginSingle();

        $this->assertType('\Tests\Lib\Nimbles\Core\Plugin\PluginSingle', $plugins->plugin);
        $this->assertTrue(isset($plugins->plugin));
        unset($plugins->plugin);
        $this->assertFalse(isset($plugins->plugin));
    }

    /**
     * Tests getting a plugin by its name
     * @return void
     */
    public function testPluginGetter() {
        $plugins = new \Nimbles\Core\Plugin();
        $plugins->plugin = new Plugin\PluginSingle();

        $this->assertType('\Tests\Lib\Nimbles\Core\Plugin\PluginSingle', $plugins->getPlugin('plugin'));
        $this->assertNull($plugins->getPlugin('foo'));
    }

    /**
     * Tests that an unknown error is raised
     * @return void
     */
    public function testAttachUnknownError() {
        $plugins = new \Nimbles\Core\Plugin();

        $this->setExpectedException('Nimbles\Core\Plugin\Exception');
        $plugins->attach('foo', null);
    }

    /**
     * Tests the plugins system rejects plugins which do not extend a given abstract
     * @return void
     */
    public function testPluginOptionsInvalidAbstract() {
        $plugins = new \Nimbles\Core\Plugin(array(
            'abstract' => '\Tests\Lib\Nimbles\Core\Plugin\PluginAbstract'
        ));

        $plugins->attach('plugin', new Plugin\PluginConcrete());
        $this->assertType('\Tests\Lib\Nimbles\Core\Plugin\PluginAbstract', $plugins->getPlugin('plugin'));

        $this->setExpectedException('\Nimbles\Core\Plugin\Exception\InvalidAbstract');
        $plugins->plugin = new Plugin\PluginSingle();
    }

    /**
     * Tests the plugins system rejects plugins which do not implement a given interface
     * @return void
     */
    public function testPluginOptionsInvalidInterface() {
        $plugins = new \Nimbles\Core\Plugin(array(
            'interface' => '\Tests\Lib\Nimbles\Core\Plugin\PluginInterface'
        ));

        $plugins->attach('plugin', new Plugin\PluginImplementor());
        $this->assertType('\Tests\Lib\Nimbles\Core\Plugin\PluginInterface', $plugins->getPlugin('plugin'));

        $this->setExpectedException('\Nimbles\Core\Plugin\Exception\InvalidInterface');
        $plugins->plugin = new Plugin\PluginSingle();
    }

    /**
     * Tests that only a single instance of the same class can be registered when singleInstance
     * option is set to true.
     * @return void
     */
    public function testPluginSingleInstance() {
        $plugins = new \Nimbles\Core\Plugin(array(
            'singleInstance' => true
        ));

        $plugins->attach('plugin1', new \stdClass());

        $this->setExpectedException('\Nimbles\Core\Plugin\Exception\PluginAlreadyRegistered');
        $plugins->attach('plugin2', new \stdClass());
    }

    /**
     * Tests loading a plugin by a string
     * @return void
     */
    public function testPluginLoadingByString() {
        $plugins = new \Nimbles\Core\Plugin();
        $plugins->attach('plugin', '\Tests\Lib\Nimbles\Core\Plugin\PluginSingle');
        $this->assertType('\Tests\Lib\Nimbles\Core\Plugin\PluginSingle', $plugins->getPlugin('plugin'));
    }

    /**
     * Tests plugin not found when loading by string
     * @return void
     */
    public function testPluginNotFound() {
        $plugins = new \Nimbles\Core\Plugin();
        $this->setExpectedException('\Nimbles\Core\Plugin\Exception\PluginNotFound');

        $plugins->attach('plugin', '\Tests\Lib\Nimbles\Core\Plugin\MissingPlugin');
    }
}
