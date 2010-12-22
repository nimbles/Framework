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
 * @package    Nimbles-Service
 * @subpackage Http
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Service\Http\Header;

use Nimbles\Service\TestCase,
    Nimbles\Service\Http\Header,
    Nimbles\Service\Http\Header\Collection;

/**
 * @category   Nimbles
 * @package    Nimbles-Service
 * @subpackage Http
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Service\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Service
 * @group      Nimbles-Service-Http
 */
class CollectionTest extends TestCase {
    /**
     * Tests that a header collection object extends a Nimbles\Core\Collection
     * @return void
     */
    public function testAbstract() {
        $collection = new Collection();
        $this->assertType('Nimbles\Core\Collection', $collection);
    }
    
    /**
     * Tests that a header collection has the correct default options
     * @return void
     */
    public function testDefaults() {
        $collection = new Collection();
        
        $this->assertEquals('Nimbles\Service\Http\Header', $collection->getType());
        $this->assertEquals(Collection::INDEX_ASSOCIATIVE, $collection->getIndexType());
        $this->assertFalse($collection->isReadOnly());
        
        $collection = new Collection(null, array(
            'type' => 'string',
            'indexType' => Collection::INDEX_MIXED,
            'readonly' => true
        ));
        
        $this->assertEquals('Nimbles\Service\Http\Header', $collection->getType());
        $this->assertEquals(Collection::INDEX_ASSOCIATIVE, $collection->getIndexType());
        $this->assertTrue($collection->isReadOnly());
    }
    
    /**
     * Tests the factory method for the collection
     * @param string|int $index
     * @param mixed      $value
     * @param bool       $valid
     * @return void
     * 
     * @dataProvider factoryProvider
     */
    public function testFactory($index, $value, $valid = true) {
        $header = Collection::factory($index, $value);
        
        if (!$valid) {
            $this->assertNull($header);
            return;
        }
        
        $this->assertType('Nimbles\Service\Http\Header', $header);
        $this->assertEquals($index, $header->getName());
    }
    
    /**
     * Data provider for the factory test
     * @return array
     */
    public function factoryProvider() {
        return array(
            array('Foo', 'Bar'),
            array('Foo', array('Bar1', 'Bar2')),
            array('Foo', new Header()),
            array('Foo', null, false)
        );
    }
}