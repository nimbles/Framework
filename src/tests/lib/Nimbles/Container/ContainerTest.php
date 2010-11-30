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
 * @package    Nimbles-Container
 * @subpackage ContainerTest
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Container;

use Nimbles\Cli\Opt\Collection;

use Nimbles\Container\TestCase,
    Nimbles\Container\Container,
    Nimbles\Container\Definition;

require_once 'ContainerMock.php';

/**
 * @category   Nimbles
 * @package    Nimbles-Container
 * @subpackage ContainerTest
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Container\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Container
 */
class ContainerTest extends TestCase {
    /**
     * Tests that the container extens a collection and has the correct default settings
     * @return void
     */
    public function testContainerDefaults() {
        $container = new Container();
        
        $this->assertType('Nimbles\Core\Collection', $container);
        
        $this->assertEquals('Nimbles\Container\Definition', $container->getType());
        $this->assertEquals(Container::INDEX_ASSOCITIVE, $container->getIndexType());
        $this->assertFalse($container->isReadOnly());
    }
    
    /**
     * Tests that when creating a container, the default options are retained
     * @return void
     */
    public function testContainerOptions() {
        $container = new Container(null, array(
            'type' => 'string',
            'indexType' => Container::INDEX_NUMERIC,
            'readonly' => false
        ));
        
        $this->assertEquals('Nimbles\Container\Definition', $container->getType());
        $this->assertEquals(Container::INDEX_ASSOCITIVE, $container->getIndexType());
        $this->assertFalse($container->isReadOnly());
    }
    
    /**
     * Tests the factory method for the factory
     * @param mixed $options
     * @return void
     * 
     * @dataProvider factoryProvider
     */
    public function testFactory($value) {
        $definition = Container::factory('foo', $value);
                
        $this->assertType('Nimbles\Container\Definition', $definition);
        $this->assertEquals('foo', $definition->getId());
    }
    
    /**
     * Tests using a collection
     * @return 
     */
    public function testContainer() {
        $container = new Container(
            array(
            	'foo' => array(
                	'class' => 'Tests\Lib\Nimbles\Container\ContainerMock'
                ),
                'bar' => 'Tests\Lib\Nimbles\Container\ContainerMock',
                'baz' => new Definition(array(
                    'id' => 'baz',
                    'class' => 'Tests\Lib\Nimbles\Container\ContainerMock'
                ))
            )
        );
        
        $this->assertType('Nimbles\Container\Definition', $container->foo);
        $this->assertType('Nimbles\Container\Definition', $container->bar);
        $this->assertType('Nimbles\Container\Definition', $container->baz);
        
        $container->quz = 'Tests\Lib\Nimbles\Container\ContainerMock';
        $this->assertType('Nimbles\Container\Definition', $container->quz);
        
        
        $instance = $container->foo->getInstance();
        $this->assertType('Tests\Lib\Nimbles\Container\ContainerMock', $instance);
        
        /*
         * due a limitation in php, this cannot be done
         * $instance = $container->foo();
         */
                
        $definition = $container->foo;
        $instance = $definition();
        $this->assertType('Tests\Lib\Nimbles\Container\ContainerMock', $instance);
    }
    
    /**
     * Data provider for the factory method
     * @return void
     */
    public function factoryProvider() {
        return array(
            array(array(
                'id' => 'bar',
                'class' => 'Tests\Lib\Nimbles\Container\ContainerMock'
            )),
            array('Tests\Lib\Nimbles\Container\ContainerMock'),
            array(
                new Definition(array(
                    'id' => 'bar',
                    'class' => 'Tests\Lib\Nimbles\Container\ContainerMock'
                ))
            )
        );
    }
}