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
 * @package    Nimbles-App
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\App\Config\File;

require_once 'Mock.php';

use Nimbles\App\TestCase,
    Nimbles\App\Config,
    Nimbles\App\Config\File\FileAbstract,
    Nimbles\App\Config\File\Mock;

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\App\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Config
 */
class FileTest extends TestCase {
    /**
     * Tests loading config from a .php file
     * @return void
     */
    public function testPhpConfig() {
        $this->_testFactory(realpath(dirname(__FILE__) . '/_files/data.php'), FileAbstract::TYPE_PHP);
        $this->_testFactory(realpath(dirname(__FILE__) . '/_files/data.inc'), FileAbstract::TYPE_PHP);
        $this->_testFactory(realpath(dirname(__FILE__) . '/_files/config.php'), FileAbstract::TYPE_PHP);
        
        $this->setExpectedException('Nimbles\App\Config\File\Exception\InvalidFormat');
        FileAbstract::factory(realpath(dirname(__FILE__) . '/_files/invalid.php'));
    }
    
    /**
     * Tests loading config from a .json file
     * @return void
     */
    public function testJsonConfig() {
        if (!extension_loaded('json')) {
            $this->markTestSkipped('The json extension is not available');
        }
        $this->_testFactory(realpath(dirname(__FILE__) . '/_files/data.json'), FileAbstract::TYPE_JSON);
        $this->_testFactory(realpath(dirname(__FILE__) . '/_files/data.js'), FileAbstract::TYPE_JSON);
        
        $this->setExpectedException('Nimbles\App\Config\File\Exception\InvalidFormat');
        FileAbstract::factory(realpath(dirname(__FILE__) . '/_files/invalid.json'));
    }
    
    /**
     * Tests loading config from a .yaml file
     * @return void
     */
    public function testYamlConfig() {
        if (!extension_loaded('yaml')) {
            $this->markTestSkipped('The yaml extension is not available');
        }
        $this->_testFactory(realpath(dirname(__FILE__) . '/_files/data.yml'), FileAbstract::TYPE_YAML);
        $this->setExpectedException('Nimbles\App\Config\File\Exception\InvalidFormat');
        FileAbstract::factory(realpath(dirname(__FILE__) . '/_files/invalid.yml'));
    }
    
    /**
     * Tests getting empty config
     * @return void
     */
    public function testGetConfig() {
        Mock::$data = null;
        $config = FileAbstract::factory(realpath(dirname(__FILE__) . '/_files/data.inc'), null, 'Mock');
        $this->assertSame(array(), $config->getArrayCopy());
    }
    
    /**
     * Tests loading in invalid section
     * @return void
     */
    public function testInvalidSection() {
        Mock::$data = array(
            'level1' => array(),
            'level4:level3' => array(),
        );
        
        $this->setExpectedException('Nimbles\App\Config\File\Exception\InvalidConfig');
        $config = FileAbstract::factory(realpath(dirname(__FILE__) . '/_files/data.inc'), 'section3', 'Mock');
    }
    
    /**
     * Tests getting config without finding the section
     * @return void
     */
    public function testNoSection() {
        Mock::$data = array('foo' => array('bar' => 123));
        $config = FileAbstract::factory(realpath(dirname(__FILE__) . '/_files/data.inc'), 'section3', 'Mock');
        
        $this->assertSame(array('bar' => 123), $config->getArrayCopy());
    }
    
    /**
     * Tests creating config from multiple file types
     * 
     * @param string $file
     * @param string|null $type
     * @return void
     */
    public function _testFactory($file, $type) {
        $config = FileAbstract::factory($file, null, $type);
        
        $this->assertEquals(1, $config->level1->a, 'Failed to load non section based config');
        $this->assertType('Nimbles\App\Config', $config->level1->b);
        $this->assertEquals(2, $config->level1->b->c);
        $this->assertEquals(4, $config->level1->d->e);
        
        $autoConfig = FileAbstract::factory($file);
        $this->assertEquals($config, $autoConfig);
        
        $config = FileAbstract::factory($file, 'level2');
        
        $this->assertEquals(2, $config->a, 'Failed to get level2 config');
        $this->assertType('Nimbles\App\Config', $config->b);
        $this->assertEquals(2, $config->b->c);
        $this->assertEquals(5, $config->d->e);
        $this->assertEquals(6, $config->d->f);
        
        try {
            $config = FileAbstract::factory(null, null, $type);
            $this->fail('Expected exception Nimbles\App\Config\File\Exception\InvalidFile');
        } catch (\Exception $ex) {
            $this->assertType('Nimbles\App\Config\File\Exception\InvalidFile', $ex, 'Expected exception Nimbles\App\Config\File\Exception\InvalidFile');
        }
        
        try {
            $config = FileAbstract::factory('', null, $type);
            $this->fail('Expected exception Nimbles\App\Config\File\Exception\InvalidFile');
        } catch (\Exception $ex) {
            $this->assertType('Nimbles\App\Config\File\Exception\InvalidFile', $ex, 'Expected exception Nimbles\App\Config\File\Exception\InvalidFile');
        }
        
        try {
            $config = FileAbstract::factory('', null, null);
            $this->fail('Expected exception Nimbles\App\Config\File\Exception\InvalidFile');
        } catch (\Exception $ex) {
            $this->assertType('Nimbles\App\Config\File\Exception\InvalidFile', $ex, 'Expected exception Nimbles\App\Config\File\Exception\InvalidFile');
            $this->assertEquals('Cannot parse file extension from file', $ex->getMessage()); // as a different reason
        }
        
        try {
            $config = FileAbstract::factory('foo', null, 'Foo');
            $this->fail('Expected exception Nimbles\App\Config\File\Exception\InvalidFile');
        } catch (\Exception $ex) {
            $this->assertType('Nimbles\App\Config\File\Exception\InvalidFile', $ex, 'Expected exception Nimbles\App\Config\File\Exception\InvalidFile');
            $this->assertEquals('No parser for found for type: Foo', $ex->getMessage()); // as a different reason
        }
    }
}