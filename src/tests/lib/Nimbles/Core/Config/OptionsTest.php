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
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Config;

require_once 'ConfigurableMock.php';
require_once 'OptionsMock.php';

use Nimbles\Core\TestCase;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Core
 * @group      Nimbles-Core-Config
 */
class OptionsTest extends TestCase {
    /**
     * Tests the mixin properties are created and behave properly
     * @param \Tests\Nimbles\Core\Config\OptionsMock $mock
     * @return void
     *
     * @dataProvider mockProvider
     */
    public function testMixinProperties(OptionsMock $mock) {
        $this->assertType('\Nimbles\Core\Config', $mock->config);

        $mock->config->a = 1;
        $this->assertEquals(1, $mock->config->a);
    }

    /**
     * Tests the mixin methods are created and behave properly
     * @param \Tests\Nimbles\Core\Config\OptionsMock $mock
     * @param string $initialState
     * @return void
     *
     * @dataProvider mockProvider
     */
    public function testMixinMethods(OptionsMock $mock, $initialState) {
        $mock->setOption('b', 2);
        $this->assertEquals(2, $mock->getOption('b'));

        $this->assertEquals($initialState, $mock->getTest());
        $this->assertEquals($initialState, $mock->getOption('test'));

        $mock->setOption('test', 'test2');
        $this->assertEquals('test2', $mock->getTest());
        $this->assertEquals('test2', $mock->getOption('test'));

        $mock->setOptions(array(
            'test' => 'test3',
            'c' => 3
        ));

        $this->assertEquals('test3', $mock->getTest());
        $this->assertEquals('test3', $mock->getOption('test'));
        $this->assertEquals(3, $mock->getOption('c'));
    }

    /**
     * Data provider for options mock
     * @return array
     */
    public function mockProvider() {
        return array(
            array(new OptionsMock(), 'test'),
            array(new OptionsMock(array('test' => 'hello world')), 'hello world'),
            array(new OptionsWithDefaultsMock(), 'hello world'),
            array(new OptionsWithDefaultsMock(array('test' => 'test')), 'test'),
        );
    }

    /**
     * Test getting and setting options on other mixins
     */
    public function testAccessingOtherMixins() {
        $options = new OptionsWithOtherMixinMock(
            array(
                'test' => 'value'
            )
        );
        $this->assertEquals('value', $options->getTest());
        $this->assertEquals($options, $options->setTest('new'));
        $this->assertEquals('new', $options->getTest());
    }
}
