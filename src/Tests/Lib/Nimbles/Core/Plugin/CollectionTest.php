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

namespace Tests\lib\Nimbles\Core\Plugin;

use Nimbles\Core\TestCase,
    Nimbles\Core\Plugin,
    Nimbles\Core\Plugin\Collection;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Core
 * @group      Nimbles-Core-Plugin
 */
class CollectionTest extends TestCase {
/**
     * Test that the collection object extends a Nimbles\Core\Collection
     * @return void
     */
    public function testAbstract() {
        $collection = new Collection();
        $this->assertInstanceOf('Nimbles\Core\Collection', $collection);
        $this->assertEquals(Collection::INDEX_ASSOCIATIVE, $collection->getIndexType());
    }
    
    /**
     * Tests that changing index type and readonly cannot be overriden
     * @return void
     */
    public function testFixedOptions() {
        $collection = new Collection(null, array(
            'type'		=> 'string',
            'indexType' => Collection::INDEX_MIXED,
            'readonly'  => true
        ));
        
        $this->assertEquals('Nimbles\Core\Plugin', $collection->getType());
        $this->assertEquals(Collection::INDEX_ASSOCIATIVE, $collection->getIndexType());
        $this->assertTrue($collection->isReadOnly());
    }
    
    /**
     * Tests defining a collection
     * @return void
     */
    public function testConstruct() {
        $collection = new Collection(array(
            'foo' => 'foo',
            'bar' => array(
                'name' => 'bar',
                'type' => 'string'
            ),
            'baz' => new Plugin()
        ));
        
        $this->assertInstanceOf('Nimbles\Core\Plugin', $collection->foo);
        $this->assertInstanceOf('Nimbles\Core\Plugin', $collection->bar);
        $this->assertInstanceOf('Nimbles\Core\Plugin', $collection->baz);
        
        $this->setExpectedException('Nimbles\Core\Collection\Exception\ReadOnly');
        $collection['test'] = new Plugin();
    }
    
    /**
     * Tests the factory method for the plugin collection
     * @param string|int $index
     * @param mixed $value
     * @param string|null $expectedType
     * 
     * @dataProvider factoryProvider
     */
    public function testFactory($index, $value, $expectedType) {
        $plugin = Collection::factory($index, $value);
        if (null !== $expectedType) {
            $this->assertInstanceOf($expectedType, $plugin);
        } else {
            $this->assertNull($plugin);
        }
    }
    
    public function factoryProvider() {
        return array(
            array('foo', 'foo', 'Nimbles\Core\Plugin'),
            array('bar', array(
                'name' => 'bar',
                'type' => 'string'
            ), 'Nimbles\Core\Plugin')
        );
    }
}