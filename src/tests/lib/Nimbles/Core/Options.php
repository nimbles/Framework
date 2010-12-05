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
        $this->assertSame($initialOptions, $instance->getOptions());
        $instance->setOptions($options);
        
        foreach ($options as $option => $value) {
            $this->assertEquals($value, $instance->getOption($option));
        }
        
        $this->assertSame($dynamicOptions, $instance->getOptions());
    }
}