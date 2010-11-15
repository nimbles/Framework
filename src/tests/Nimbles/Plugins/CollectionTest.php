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
 * @package    Nimbles-Plugins
 * @subpackage CollectionTest
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\lib\Nimbles\Plugins;

use Nimbles\Plugins\TestCase,
    Nimbles\Plugins\Collection,
    Nimbles\Plugins\Plugin;

/**
 * @category   Nimbles
 * @package    Nimbles-Plugins
 * @subpackage CollectionTest
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Plugins\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Plugins
 */
class CollectionTest extends TestCase {
/**
     * Test that the collection object extends a Nimbles\Core\Collection
     * @return void
     */
    public function testAbstract() {
        $collection = new Collection();
        $this->assertType('Nimbles\Core\Collection', $collection);
        $this->assertEquals(Collection::INDEX_ASSOCITIVE, $collection->getIndexType());
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
        
        $this->assertEquals('Nimbles\Plugins\Plugin', $collection->getType());
        $this->assertEquals(Collection::INDEX_ASSOCITIVE, $collection->getIndexType());
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
        
        $this->assertType('Nimbles\Plugins\Plugin', $collection->foo);
        $this->assertType('Nimbles\Plugins\Plugin', $collection->bar);
        $this->assertType('Nimbles\Plugins\Plugin', $collection->baz);
        
        $this->setExpectedException('Nimbles\Core\Collection\Exception\ReadOnly');
        $collection['test'] = new Plugin();
    }
}