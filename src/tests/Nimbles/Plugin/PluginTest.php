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
 * @package    Nimbles-Plugin
 * @subpackage PluginTest
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\lib\Nimbles\Plugin;

use Nimbles\Plugin\TestCase,
    Nimbles\Plugin\Plugin;

/**
 * @category   Nimbles
 * @package    Nimbles-Plugin
 * @subpackage PluginTest
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Plugin\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Plugin
 */
class PluginTest extends TestCase {
    /**
     * Test that the plugin object extends a Nimbles\Core\Collection
     * @return void
     */
    public function testAbstract() {
        $plugin = new Plugin();
        $this->assertType('Nimbles\Core\Collection', $plugin);
        $this->assertEquals(Plugin::INDEX_ASSOCITIVE, $plugin->getIndexType());
    }
    
    /**
     * Tests that changing index type and readonly cannot be overriden
     * @return void
     */
    public function testFixedOptions() {
        $plugin = new Plugin(null, array(
            'indexType' => Plugin::INDEX_MIXED,
            'readonly'  => true
        ));
        
        $this->assertEquals(Plugin::INDEX_ASSOCITIVE, $plugin->getIndexType());
        $this->assertFalse($plugin->isReadOnly());
    }
    
    /**
     * Tests getting and setting the type
     * @return void
     */
    public function testName() {
        $plugin = new Plugin();
        $plugin->setName('foo');
        $this->assertEquals('foo', $plugin->getName());
        
        $plugin = new Plugin(null, array('name' => 'bar'));
        $this->assertEquals('bar', $plugin->getName());
    }
    
    /**
     * Tests attaching and detaching plugins
     * @return void
     */
    public function testAttachDetach() {
        $plugin = new Plugin(array(
            'foo' => 'bar'
        ), array(
            'type' => 'string'
        ));
                
        $this->assertEquals('bar', $plugin['foo']);
        $this->assertEquals('bar', $plugin->foo);
        $this->assertEquals(1, $plugin->count());
        
        $plugin->attach('baz', 'quz');
        
        $this->assertEquals('quz', $plugin['baz']);
        $this->assertEquals('quz', $plugin->baz);
        $this->assertEquals(2, $plugin->count());
        
        $plugin->detach('foo');
        $this->assertFalse($plugin->offsetExists('foo'));
        $this->assertEquals(1, $plugin->count());        
    }
}