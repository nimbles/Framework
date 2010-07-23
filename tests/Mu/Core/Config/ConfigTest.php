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
 * @package   Mu\Core\Config
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Core\Config
 */

namespace Tests\Mu\Core\Config;


/**
 * @category  Mu
 * @package   Mu\Core\Config
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     Mu\Core\Config
 */
class ConfigTest extends \Mu\Core\TestCase {
    /**
     * Tests construct of config without any parameters
     * @return void
     */
    public function testConstructWithNoParameters() {
        $config = new \Mu\Core\Config();
        $this->assertType('\Mu\Core\Config', $config);
    }

    /**
     * Tests construct of config with an empty array as first parameter
     * @return void
     */
    public function testConstructWithEmptyArray() {
        $config = new \Mu\Core\Config(array());
        $this->assertType('\Mu\Core\Config', $config);
    }

    /**
     * Tests construct with a string as first parameter and no config
     * @return void
     */
    public function testConstructWithNonArray() {
        $this->setExpectedException('\Mu\Core\Config\Exception\InvalidConfig');
        $config = new \Mu\Core\Config('test');
    }

    /**
     * Tests construct with a string as first and second parameter
     * @return void
     */
    public function testConstructWithSectionAndValue() {
        $config = new \Mu\Core\Config('section', 'value');
        $this->assertEquals('value', $config->section);
    }

    /**
     * Tests accesses with a string as first and second parameter
     * @return void
     */
    public function testAccessesWithSectionAndValue() {
        $config = new \Mu\Core\Config('section', 'value');
        $this->assertEquals('value', $config->section);

        $config->section = 'value2';
        $this->assertEquals('value2', $config->section);
    }

    /**
     * Tests array access with a string as first and second parameter
     * @return void
     */
    public function testArrayAccessWithSectionAndValue() {
        $config = new \Mu\Core\Config('section', 'value');
        $this->assertEquals('value', $config['section']);

        $config['section'] = 'value2';
        $this->assertEquals('value2', $config['section']);
    }

    /**
     * Tests getConfig and setConfig with a string as first and second parameter
     * @return void
     */
    public function testGetSetConfigWithSectionAndValue() {
        $config = new \Mu\Core\Config('section', 'value');
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
        $config = new \Mu\Core\Config($testdata);
        $this->assertType('\Mu\Core\Config', $config);
    }

    /**
     * Tests the accesses with a populated array as first parameter
     * @dataProvider configArrayProvider
     * @param array $testdata
     * @return void
     */
    public function testAccessesPopulatedArray(array $testdata) {
        $config = new \Mu\Core\Config($testdata);
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
        $config = new \Mu\Core\Config($testdata);
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
