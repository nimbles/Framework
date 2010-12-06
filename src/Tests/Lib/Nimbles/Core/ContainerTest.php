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
 * @subpackage ContainerTest
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core;

use Nimbles\Cli\Opt\Collection;

use Nimbles\Core\TestCase,
    Nimbles\Core\Container,
    Nimbles\Core\Container\Definition;

require_once 'Container/ContainerMock.php';

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage ContainerTest
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Core
 * @group      Nimbles-Core-Container
 */
class ContainerTest extends TestCase {
    /**
     * Tests that the container extens a collection and has the correct default settings
     * @return void
     */
    public function testContainerDefaults() {
        $container = new Container();
        
        $this->assertType('Nimbles\Core\Collection', $container);
        
        $this->assertEquals('Nimbles\Core\Container\Definition', $container->getType());
        $this->assertEquals(Container::INDEX_ASSOCIATIVE, $container->getIndexType());
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
        
        $this->assertEquals('Nimbles\Core\Container\Definition', $container->getType());
        $this->assertEquals(Container::INDEX_ASSOCIATIVE, $container->getIndexType());
        $this->assertFalse($container->isReadOnly());
    }
    
    /**
     * Tests the factory method for the factory
     * @param mixed $options
     * @param bool  $valid   If FALSE, then returned value from factory should be null
     * @return void
     * 
     * @dataProvider factoryProvider
     */
    public function testFactory($value, $valid = true) {
        $definition = Container::factory('foo', $value);
                
        if ($valid) {
            $this->assertType('Nimbles\Core\Container\Definition', $definition);
            $this->assertEquals('foo', $definition->getId());
        } else {
            $this->assertNull($definition);
        }
    }
    
    /**
     * Tests using a collection
     * @return 
     */
    public function testContainer() {
        $container = new Container(
            array(
            	'foo' => array(
                	'class' => 'Tests\Lib\Nimbles\Core\Container\ContainerMock'
                ),
                'bar' => 'Tests\Lib\Nimbles\Core\Container\ContainerMock',
                'baz' => new Definition(array(
                    'id' => 'baz',
                    'class' => 'Tests\Lib\Nimbles\Core\Container\ContainerMock'
                ))
            )
        );
        
        $this->assertType('Nimbles\Core\Container\Definition', $container->foo);
        $this->assertType('Nimbles\Core\Container\Definition', $container->bar);
        $this->assertType('Nimbles\Core\Container\Definition', $container->baz);
        
        $container->quz = 'Tests\Lib\Nimbles\Core\Container\ContainerMock';
        $this->assertType('Nimbles\Core\Container\Definition', $container->quz);
        
        
        $instance = $container->foo->getInstance();
        $this->assertType('Tests\Lib\Nimbles\Core\Container\ContainerMock', $instance);
        
        /*
         * due a limitation in php, this cannot be done
         * $instance = $container->foo();
         */
                
        $definition = $container->foo;
        $instance = $definition();
        $this->assertType('Tests\Lib\Nimbles\Core\Container\ContainerMock', $instance);
    }
    
    /**
     * Data provider for the factory method
     * @return void
     */
    public function factoryProvider() {
        return array(
            array(array(
                'id' => 'bar',
                'class' => 'Tests\Lib\Nimbles\Core\Container\ContainerMock'
            )),
            array('Tests\Lib\Nimbles\Core\Container\ContainerMock'),
            array(
                new Definition(array(
                    'id' => 'bar',
                    'class' => 'Tests\Lib\Nimbles\Core\Container\ContainerMock'
                ))
            ),
            array(1, false)
        );
    }
}