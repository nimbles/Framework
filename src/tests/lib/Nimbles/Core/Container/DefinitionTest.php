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
 * @subpackage Container
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Container;

use Nimbles\Core\TestCase,
    Nimbles\Core\Container\Definition;

require_once 'ContainerMock.php';

/**
 * @category   Nimbles
 * @package    Nimbles-Container
 * @subpackage DefinitionTest
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
class DefinitionTest extends TestCase {
    /**
     * Tests that when creating a construct without require parameters an
     * @param mixed  $options
     * @param string $exception
     * @return void
     * 
     * @dataProvider invalidOptionsProvider
     */
    public function testConstruct($options, $exception) {
        $this->setExpectedException($exception);
        $definition = new Definition($options);
    }
    
    /**
     * Tests getting and setting parameters on a defintion
     * @return void
     */
    public function testGetSetParamaters() {
        $definition = new Definition(array(
            'id' => 'mock',
            'class' => 'Tests\Lib\Nimbles\Core\Container\ContainerMock'
        ));
        
        $this->assertType('array', $definition->getParameters());
        
        $definition->setParameters(array('param1' => 1));
        $this->assertType('array', $definition->getParameters());
        $this->assertSame(array('param1' => 1), $definition->getParameters());
        
        $definition->setParameters(new \ArrayObject(array('param1' => 1)));
        $this->assertType('array', $definition->getParameters());
        $this->assertSame(array('param1' => 1), $definition->getParameters());
        
        $this->setExpectedException('Nimbles\Core\Container\Exception\InvalidParameters');
        $definition->setParameters(123);
    }
    
    /**
     * Tests creating the mocks
     * @param array $options
     * @return void
     * 
     * @dataProvider mockProvider
     */
    public function testMock(array $options) {
        $definition = new Definition($options);
        
        $this->assertEquals($options['id'], $definition->getId());
        $this->assertEquals($options['class'], $definition->getClass());
        $this->assertSame($options['parameters'], $definition->getParameters());
        $this->assertSame($options['shared'], $definition->isShared());
        
        $instance = $definition->getInstance();
        $this->assertType($options['class'], $instance);
        
        $count = call_user_func(array($options['class'], 'getInstanceCount'));
        
        $instance = $definition(); // check that definition is invokable
        $this->assertType($options['class'], $instance);
        $this->assertSame($options['parameters'], $instance->getParameters());
        
        $newCount = call_user_func(array($options['class'], 'getInstanceCount'));
        if ($options['shared']) {
            $this->assertEquals($count, $newCount, 'New instance of class was created when meant to be shared');
        } else {
            $this->assertGreaterThan($count, $newCount, 'No new instance of class was created when not meant to be shared');
            
            if (!empty($options['parameters'])) {
                $this->setExpectedException('Nimbles\Core\Container\Exception\CreateInstanceFailure');
                $definition->setParameters(array());
                $instance = $definition();
            }
        }
    }
    
    /**
     * Data provider for invalid options
     * @return array
     */
    public function invalidOptionsProvider() {
        return array(
            array('foo', 'BadMethodCallException'),
            array(array('id' => 'foo'), 'Nimbles\Core\Options\Exception\MissingOption'),
            array(array('class' => 'foo'), 'Nimbles\Core\Options\Exception\MissingOption'),
            array(array('id' => 'foo', 'class' => 'bar'), 'Nimbles\Core\Container\Exception\InvalidClass'),
            array(array('id' => '', 'class' => 'bar'), 'Nimbles\Core\Container\Exception\InvalidId'),
            array(array('id' => 'foo', 'class' => 'stdClass', 'parameters' => null), 'Nimbles\Core\Container\Exception\InvalidParameters'),
        );
    }
    
    /**
     * Data provider for mock options
     * @return array
     */
    public function mockProvider() {
        return array(
            array(array(
                'id' => 'mock1',
                'class' => 'Tests\Lib\Nimbles\Core\Container\ContainerMock',
                'parameters' => array(),
                'shared' => false
            )),
            array(array(
                'id' => 'mock2',
                'class' => 'Tests\Lib\Nimbles\Core\Container\ContainerMock',
                'parameters' => array(),
                'shared' => true
            )),
            array(array(
                'id' => 'mock3',
                'class' => 'Tests\Lib\Nimbles\Core\Container\ContainerParametersMock',
                'parameters' => array('param1' => 1, 'param2' => 2),
                'shared' => false
            )),
            array(array(
                'id' => 'mock4',
                'class' => 'Tests\Lib\Nimbles\Core\Container\ContainerParametersMock',
                'parameters' => array('param1' => 1, 'param2' => 2),
                'shared' => true
            )),
        );
    }
}