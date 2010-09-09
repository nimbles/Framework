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
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Core;

use Mu\Core\TestCase,
    Mu\Core\Config;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestCase
 *
 * @group      Mu
 * @group      Mu-Core
 * @group      Mu-Core-Config
 */
class ConfigTest extends TestCase {
    /**
     * Tests getting an instance of the config
     * @return void
     */
    public function testGetInstance() {
        $this->assertType('Mu\Core\Config', Config::getInstance());
    }

    /**
     * Tests construct of config without any parameters
     * @return void
     */
    public function testConstructWithNoParameters() {
        $config = new Config();
        $this->assertType('\Mu\Core\Config', $config);
    }

    /**
     * Tests construct of config with an empty array as first parameter
     * @return void
     */
    public function testConstructWithEmptyArray() {
        $config = new Config(array());
        $this->assertType('\Mu\Core\Config', $config);
    }

    /**
     * Tests construct with a string as first parameter and no config
     * @return void
     */
    public function testConstructWithNonArray() {
        $this->setExpectedException('\Mu\Core\Config\Exception\InvalidConfig');
        $config = new Config('test');
    }

    /**
     * Tests construct with a string as first and second parameter
     * @return void
     */
    public function testConstructWithSectionAndValue() {
        $config = new Config('section', 'value');
        $this->assertEquals('value', $config->section);
    }

    /**
     * Tests accesses with a string as first and second parameter
     * @return void
     */
    public function testAccessesWithSectionAndValue() {
        $config = new Config('section', 'value');
        $this->assertEquals('value', $config->section);

        $config->section = 'value2';
        $this->assertEquals('value2', $config->section);
    }

    /**
     * Tests array access with a string as first and second parameter
     * @return void
     */
    public function testArrayAccessWithSectionAndValue() {
        $config = new Config('section', 'value');
        $this->assertEquals('value', $config['section']);

        $config['section'] = 'value2';
        $this->assertEquals('value2', $config['section']);
    }

    /**
     * Tests getConfig and setConfig with a string as first and second parameter
     * @return void
     */
    public function testGetSetConfigWithSectionAndValue() {
        $config = new Config('section', 'value');
        $this->assertEquals('value', $config->getConfig('section'));

        $config->setConfig('section', 'value2');
        $this->assertEquals('value2', $config->section);
    }

    /**
     * Tests construct with a populated array as first parameter
     * @dataProvider configArrayProvider
     * @param array $testdata
     * @return void
     */
    public function testConstructWithPopulatedArray(array $testdata) {
        $config = new Config($testdata);
        $this->assertType('\Mu\Core\Config', $config);
    }

    /**
     * Tests the accesses with a populated array as first parameter
     * @dataProvider configArrayProvider
     * @param array $testdata
     * @return void
     */
    public function testAccessesPopulatedArray(array $testdata) {
        $config = new Config($testdata);
        $this->assertType('\Mu\Core\Config', $config);

        $this->assertEquals(1, $config->a);
        $this->assertEquals(2, $config->b);
        $this->assertEquals(3, $config->c);
        $this->assertType('\Mu\Core\Config', $config->d);
        $this->assertEquals(4, $config->d->e);
        $this->assertEquals(4, $config->{'d.e'});
        $this->assertEquals(5, $config->d->f);
        $this->assertEquals(5, $config->{'d.f'});
        $this->assertType('\Mu\Core\Config', $config->d->g);
        $this->assertType('\Mu\Core\Config', $config->{'d.g'});
        $this->assertEquals(6, $config->d->g->h);
        $this->assertEquals(6, $config->{'d.g.h'});
        $this->assertNull($config->e);
    }

    /**
     * Tests the getConfig with a populated array as first parameter
     * @dataProvider configArrayProvider
     * @param array $testdata
     * @return void
     */
    public function testGetSetConfigPopulatedArray(array $testdata) {
        $config = new Config($testdata);
        $this->assertType('\Mu\Core\Config', $config);

        $this->assertEquals(1, $config->getConfig('a'));
        $this->assertEquals(2, $config->getConfig('b'));
        $this->assertEquals(3, $config->getConfig('c'));
        $this->assertType('\Mu\Core\Config', $config->getConfig('d'));
        $this->assertEquals(4, $config->getConfig('d.e'));
        $this->assertEquals(5, $config->getConfig('d.f'));
        $this->assertType('\Mu\Core\Config', $config->getConfig('d.g'));
        $this->assertEquals(6, $config->getConfig('d.g.h'));
        $this->assertNull($config->getConfig('e'));
    }

    /**
     * Tests the merge with other config works as expected
     * @return void
     */
    public function testMerge() {
        $config = new Config(array(
            'a' => 1,
            'b' => 2
        ));

        $this->assertEquals(1, $config->a);
        $this->assertEquals(2, $config->b);

        $config->merge(array(
            'b' => 3,
            'c' => 4
        ));

        $this->assertEquals(1, $config->a);
        $this->assertEquals(3, $config->b);
        $this->assertEquals(4, $config->c);

        $config->merge(new Config(array(
            'a' => 5,
            'c' => 6,
            'd' => 7
        )));

        $this->assertEquals(5, $config->a);
        $this->assertEquals(3, $config->b);
        $this->assertEquals(6, $config->c);
        $this->assertEquals(7, $config->d);

        $this->setExpectedException('\Mu\Core\Config\Exception\InvalidConfig');
        $config->merge(true);
    }

    /**
     * Tests when not passing a key, the same config object is returned
     * @return void
     */
    public function testGetSelf() {
        $config = new Config();
        $this->assertSame($config, $config->getConfig());

        $config = Config::getInstance();
        $this->assertSame($config, Config::getConfig());
    }

    /**
     * Tests using the config statically
     * @return void
     */
    public function testGetSetStatic() {
        Config::setConfig('foo', 'bar');
        $this->assertEquals('bar', Config::getConfig('foo'));
    }

    /**
     * Tests that a \BadMethodCallException exception is thrown when trying to call a none
     * existing method
     * @retrun void
     */
    public function testBadMethod() {
        $this->setExpectedException('BadMethodCallException');
        $config = new Config();
        $config->foo();
    }

    /**
     * Tests that a \BadMethodCallException exception is thrown when trying to call a none
     * existing static method
     * @retrun void
     */
    public function testBadMethodStatic() {
        $this->setExpectedException('BadMethodCallException');
        Config::foo();
    }

    /**
     * Gets the array data for tests
     * @return array
     */
    public function configArrayProvider() {
        return array(array(array(
            'a' => 1,
            'b' => 2,
            'c' => 3,
            'd' => array(
                'e' => 4,
                'f' => 5,
                'g' => array(
                    'h' => 6
                )
            )
        )));
    }
}
