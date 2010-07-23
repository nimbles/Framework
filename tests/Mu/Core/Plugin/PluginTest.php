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
 * @package   Mu\Core\Plugin
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Core\Plugin
 */

namespace Tests\Mu\Core\Plugin;

require_once 'PluginMock.php';

/**
 * @category  Mu
 * @package   Mu\Core\Plugin
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Core\Plugin
 */
class PluginTest extends \Mu\Core\TestCase {
    /**
     * Tests that the plugin system implements the observer pattern
     * @return void
     */
    public function testPluginsAreUpdated() {
        $plugin = $this->getMock('\Tests\Mu\Core\Plugin\PluginObserver', array('update'));
        $plugin->expects($this->once())
            ->method('update')
            ->with($this->equalTo(true));

        $plugins = new \Mu\Core\Plugin();
        $plugins->attach('plugin', $plugin);

        $plugins->notify(true);
    }

    /**
     * Tests that the plugin class provides accesses methods for the plugins
     * @return void
     */
    public function testPluginAccesses() {
        $plugins = new \Mu\Core\Plugin();
        $plugins->plugin = new PluginSingle();

        $this->assertType('\Tests\Mu\Core\Plugin\PluginSingle', $plugins->plugin);
        $this->assertTrue(isset($plugins->plugin));
        unset($plugins->plugin);
        $this->assertFalse(isset($plugins->plugin));
    }

    /**
     * Tests the plugins system rejects plugins which do not extend a given abstract
     * @return void
     */
    public function testPluginOptionsInvalidAbstract() {
        $plugins = new \Mu\Core\Plugin(array(
            'abstract' => '\Tests\Mu\Core\Plugin\PluginAbstract'
        ));

        $plugins->attach('plugin', new PluginConcrete());
        $this->assertType('\Tests\Mu\Core\Plugin\PluginAbstract', $plugins->getPlugin('plugin'));

        $this->setExpectedException('\Mu\Core\Plugin\Exception\InvalidAbstract');
        $plugins->plugin = new PluginSingle();
    }

    /**
     * Tests the plugins system rejects plugins which do not implement a given interface
     * @return void
     */
    public function testPluginOptionsInvalidInterface() {
        $plugins = new \Mu\Core\Plugin(array(
            'interface' => '\Tests\Mu\Core\Plugin\IPlugin'
        ));

        $plugins->attach('plugin', new PluginImplementor());
        $this->assertType('\Tests\Mu\Core\Plugin\IPlugin', $plugins->getPlugin('plugin'));

        $this->setExpectedException('\Mu\Core\Plugin\Exception\InvalidInterface');
        $plugins->plugin = new PluginSingle();
    }

    /**
     * Tests loading a plugin by a string
     * @return void
     */
    public function testPluginLoadingByString() {
        $plugins = new \Mu\Core\Plugin();
        $plugins->attach('plugin', '\Tests\Mu\Core\Plugin\PluginSingle');
        $this->assertType('\Tests\Mu\Core\Plugin\PluginSingle', $plugins->getPlugin('plugin'));
    }

    /**
     * Tests plugin not found when loading by string
     * @return void
     */
    public function testPluginNotFound() {
        $plugins = new \Mu\Core\Plugin();
        $this->setExpectedException('\Mu\Core\Plugin\Exception\PluginNotFound');

        $plugins->attach('plugin', '\Tests\Mu\Core\Plugin\MissingPlugin');
    }
}
