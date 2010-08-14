<?php
/**
 * Mu Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://mu-framework.com/license/mit
 *
 * @category  Mu
 * @package   \Mu\Core\Config
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     \Mu\Core\Config
 */

namespace Tests\Mu\Core\Config;

require_once 'ConfigurableMock.php';
require_once 'OptionsMock.php';

/**
 * @category  Mu
 * @package   \Mu\Core\Config
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     \Mu\Core\Config
 */
class OptionsTest extends \Mu\Core\TestCase {
    /**
     * Tests the mixin properties are created and behave properly
     * @param \Tests\Mu\Core\Config\OptionsMock $mock
     * @return void
     *
     * @dataProvider mockProvider
     */
    public function testMixinProperties(OptionsMock $mock) {
        $this->assertType('\Mu\Core\Config', $mock->config);

        $mock->config->a = 1;
        $this->assertEquals(1, $mock->config->a);
    }

    /**
     * Tests the mixin methods are created and behave properly
     * @param \Tests\Mu\Core\Config\OptionsMock $mock
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
}
