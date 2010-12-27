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
 * @subpackage Options
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Options
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 */
trait Options {
    /**
     * Tests that the instance implements the expected options methods
     * @return void
     * 
     * @dataProvider optionsInstanceProvider
     */
    public function testMethods($instance) {
        $this->assertHasMethod($instance, 'getOption');
        $this->assertHasMethod($instance, 'setOption');
        $this->assertHasMethod($instance, 'getOptions');
        $this->assertHasMethod($instance, 'setOptions');
        
        $this->assertInstanceOf(get_class($instance), $instance->setOptions(null));
        
        try {
            $instance->setOptions('foo');
            $this->fail('Expected exception BadMethodCallException');
        } catch (\Exception $ex) {
            $this->assertInstanceOf('BadMethodCallException', $ex, 'Expected exception BadMethodCallException');
        }
        
        $this->assertNull($instance->getOption('foo'));
        $instance->options = new \stdClass();
        
        try {
            $instance->getOption('foo');
            $this->fail('Expected exception Nimbles\Core\Options\Exception\InvalidInstance');
        } catch (\Exception $ex) {
            $this->assertInstanceOf('Nimbles\Core\Options\Exception\InvalidInstance', $ex, 'Expected exception Nimbles\Core\Options\Exception\InvalidInstance');
        }
        
        unset($instance->options);
        $this->assertNull($instance->getOption('foo'));
        
        unset($instance->options);
        $instance->setOption('foo', 'bar');
        $this->assertEquals('bar', $instance->getOption('foo'));
        
        try {
            $instance->options = new \stdClass();
            $instance->setOption('foo', 'bar');
            $this->fail('Expected exception Nimbles\Core\Options\Exception\InvalidInstance');
        } catch (\Exception $ex) {
            $this->assertInstanceOf('Nimbles\Core\Options\Exception\InvalidInstance', $ex, 'Expected exception Nimbles\Core\Options\Exception\InvalidInstance');
        }
        
        unset($instance->options);
        $this->assertSame(array(), $instance->getOptions());
        
        try {
            $instance->options = new \stdClass();
            $instance->getOptions();
            $this->fail('Expected exception Nimbles\Core\Options\Exception\InvalidInstance');
        } catch (\Exception $ex) {
            $this->assertInstanceOf('Nimbles\Core\Options\Exception\InvalidInstance', $ex, 'Expected exception Nimbles\Core\Options\Exception\InvalidInstance');
        }
        
        unset($instance->options);
        $instance->setOptions(array(), null, array('foo' => 'bar'));
        $this->assertEquals('bar', $instance->getOption('foo'));
        
        unset($instance->options);
        $instance->setOptions(new \ArrayObject(), null, array('foo' => 'bar'));
        $this->assertEquals('bar', $instance->getOption('foo'));
        
        try {
            unset($instance->options);
            $instance->setOptions(
                array(
                	'foo' => 123
                ),
                array (
                    'foo',
                    'bar',
                    'baz'
                ), array(
                    'bar' => 456
                )
            );
            $this->fail('Expected exception Nimbles\Core\Options\Exception\MissingOption');
        }  catch (\Exception $ex) {
            $this->assertInstanceOf('Nimbles\Core\Options\Exception\MissingOption', $ex, 'Expected exception Nimbles\Core\Options\Exception\MissingOption');
        }
        
        unset($instance->options);
        $instance->setOptions(
            array(
            	'foo' => 123
            ),
            array (
                'foo',
                'bar'
            ), array(
                'bar' => 456
            )
        );
        $this->assertEquals(123, $instance->getOption('foo'));
        $this->assertEquals(456, $instance->getOption('bar'));
    }    
    
    /**
     * Tests getting and setting an option on a given instance
     * @return void
     * 
     * @dataProvider getSetOptionProvider
     */
    public function testGetSetOption($instance, $option, $value, $initialValue = null) {
        $this->assertEquals($initialValue, $instance->getOption($option));
        $instance->setOption($option, $value);
        $this->assertEquals($value, $instance->getOption($option));
    }
    
    /**
     * Tests getting and setting options on a given instance
     * @return void
     * 
     * @dataProvider getSetOptionsProvider
     */
    public function testGetSetOptions($instance, $options, $initialOptions = array(), $dynamicOptions = array()) {
        $this->assertSame($initialOptions, $instance->getOptions(), 'Initial options do not match expected');
        $instance->setOptions($options);
        
        foreach ($options as $option => $value) {
            $this->assertEquals($value, $instance->getOption($option), 'Option ' . $option . ' does not match expected value');
        }
        
        $this->assertSame($dynamicOptions, $instance->getOptions(), 'Dynamic options do not match expected');
    }
}