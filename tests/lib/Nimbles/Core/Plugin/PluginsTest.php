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

namespace Tests\Lib\Nimbles\Core\Plugin;

require_once 'PluginMock.php';

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
class PluginsTest extends TestCase {
    /**
     * Tests the construct of a plugins class of simple plugin types
     * @return void
     */
    public function testSingleSimpleType() {
        $plugins = new \Nimbles\Core\Plugin\Plugins(array(
            'types' => array(
                'helpers'
            )
        ));

        $this->assertType('\Nimbles\Core\Plugin', $plugins->getType('helpers'));
        $this->assertType('\Nimbles\Core\Plugin', $plugins->helpers);
        $this->assertTrue(isset($plugins->helpers));

        $plugins->helpers->attach('simple', new PluginSingle());
    }

    /**
     * Tests the construct of a plugin class with restricted to abstract type
     * @return void
     */
    public function testSingleRestrictedType() {
        $plugins = new \Nimbles\Core\Plugin\Plugins(array(
            'types' => array(
                'helpers' => array(
                    'abstract' => '\Tests\Lib\Nimbles\Core\Plugin\PluginAbstract',
                )
            )
        ));

        $this->assertType('\Nimbles\Core\Plugin', $plugins->getType('helpers'));
        $this->assertType('\Nimbles\Core\Plugin', $plugins->helpers);
        $this->assertTrue(isset($plugins->helpers));

        $plugins->helpers->attach('concrete', new PluginConcrete());

        $this->setExpectedException('\Nimbles\Core\Plugin\Exception\InvalidAbstract');
        $plugins->helpers->attach('simple', new PluginSingle());
    }

    /**
     * Tests the construct of a plugin class mutliple plugin types
     * @return void
     */
    public function testMultipleTypes() {
        $plugins = new \Nimbles\Core\Plugin\Plugins(array(
            'types' => array(
                'simple',
                'helpers' => array(
                    'abstract' => '\Tests\Lib\Nimbles\Core\Plugin\PluginAbstract',
                )
            )
        ));

        $this->assertType('\Nimbles\Core\Plugin', $plugins->getType('simple'));
        $this->assertType('\Nimbles\Core\Plugin', $plugins->simple);
        $this->assertTrue(isset($plugins->helpers));
        $plugins->simple->attach('simple', new PluginSingle());

        $this->assertType('\Nimbles\Core\Plugin', $plugins->getType('helpers'));
        $this->assertType('\Nimbles\Core\Plugin', $plugins->helpers);
        $this->assertTrue(isset($plugins->simple));

        $plugins->helpers->attach('concrete', new PluginConcrete());

        $this->setExpectedException('\Nimbles\Core\Plugin\Exception\InvalidAbstract');
        $plugins->helpers->attach('simple', new PluginSingle());
    }
}
