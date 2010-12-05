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

use Nimbles\App\TestCase,
    Nimbles\App\Config,
    Nimbles\App\Config\File\FileAbstract;

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
    }
    
    /**
     * Tests loading config from a .inc file
     * @return void
     */
    public function testIncConfig() {
        $this->_testFactory(realpath(dirname(__FILE__) . '/_files/data.inc'), FileAbstract::TYPE_PHP);
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
    }
    
    /**
     * Tests loading config from a .js file
     * @return void
     */
    public function testJsConfig() {
        if (!extension_loaded('json')) {
            $this->markTestSkipped('The json extension is not available');
        }
        $this->_testFactory(realpath(dirname(__FILE__) . '/_files/data.js'), FileAbstract::TYPE_JSON);
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
        
        $this->assertEquals(1, $config->level1->a);
        $this->assertType('Nimbles\App\Config', $config->level1->b);
        $this->assertEquals(2, $config->level1->b->c);
        $this->assertEquals(4, $config->level1->d->e);
        
        $autoConfig = FileAbstract::factory($file);
        $this->assertEquals($config, $autoConfig);
        
        $config = FileAbstract::factory($file, 'level2');
        
        $this->assertEquals(2, $config->a);
        $this->assertType('Nimbles\App\Config', $config->b);
        $this->assertEquals(2, $config->b->c);
        $this->assertEquals(5, $config->d->e);
        $this->assertEquals(6, $config->d->f);
    }
}