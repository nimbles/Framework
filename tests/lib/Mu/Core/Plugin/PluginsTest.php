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
 * @package   \Mu\Core\Plugin
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     \Mu\Core\Plugin
 */

namespace Tests\Mu\Core\Plugin;

require_once 'PluginMock.php';

/**
 * @category  Mu
 * @package   \Mu\Core\Plugin
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     \Mu\Core\Plugin
 */
class PluginsTest extends \Mu\Core\TestCase {
    /**
     * Tests the construct of a plugins class of simple plugin types
     * @return void
     */
    public function testSingleSimpleType() {
        $plugins = new \Mu\Core\Plugin\Plugins(array(
            'types' => array(
                'helpers'
            )
        ));

        $this->assertType('\Mu\Core\Plugin', $plugins->getType('helpers'));
        $this->assertType('\Mu\Core\Plugin', $plugins->helpers);
        $this->assertTrue(isset($plugins->helpers));

        $plugins->helpers->attach('simple', new PluginSingle());
    }

    /**
     * Tests the construct of a plugin class with restricted to abstract type
     * @return void
     */
    public function testSingleRestrictedType() {
        $plugins = new \Mu\Core\Plugin\Plugins(array(
            'types' => array(
                'helpers' => array(
                    'abstract' => '\Tests\Mu\Core\Plugin\PluginAbstract',
                )
            )
        ));

        $this->assertType('\Mu\Core\Plugin', $plugins->getType('helpers'));
        $this->assertType('\Mu\Core\Plugin', $plugins->helpers);
        $this->assertTrue(isset($plugins->helpers));

        $plugins->helpers->attach('concrete', new PluginConcrete());

        $this->setExpectedException('\Mu\Core\Plugin\Exception\InvalidAbstract');
        $plugins->helpers->attach('simple', new PluginSingle());
    }

    /**
     * Tests the construct of a plugin class mutliple plugin types
     * @return void
     */
    public function testMultipleTypes() {
        $plugins = new \Mu\Core\Plugin\Plugins(array(
            'types' => array(
                'simple',
                'helpers' => array(
                    'abstract' => '\Tests\Mu\Core\Plugin\PluginAbstract',
                )
            )
        ));

        $this->assertType('\Mu\Core\Plugin', $plugins->getType('simple'));
        $this->assertType('\Mu\Core\Plugin', $plugins->simple);
        $this->assertTrue(isset($plugins->helpers));
        $plugins->simple->attach('simple', new PluginSingle());

        $this->assertType('\Mu\Core\Plugin', $plugins->getType('helpers'));
        $this->assertType('\Mu\Core\Plugin', $plugins->helpers);
        $this->assertTrue(isset($plugins->simple));

        $plugins->helpers->attach('concrete', new PluginConcrete());

        $this->setExpectedException('\Mu\Core\Plugin\Exception\InvalidAbstract');
        $plugins->helpers->attach('simple', new PluginSingle());
    }
}
