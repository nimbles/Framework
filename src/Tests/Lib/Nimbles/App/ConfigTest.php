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
 * @subpackage ConfigTest
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\App;

use Nimbles\App\TestCase,
    Nimbles\App\Config;

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage ConfigTest
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\App\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-App
 * @group      Nimbles-App-Config
 */
class ConfigTest extends TestCase {
    /**
     * Config data before each test
     * @var array
     */
    protected $_configData;
    
    /**
     * Case set up
     * @return void 
     */
    public function setUp() {
        $this->_configData = Config::getInstance()->getArrayCopy();
    }
    
    /**
     * Case tear down
     * @return void
     */
    public function tearDown() {
        Config::getInstance()->exchangeArray($this->_configData);
    }
    
    /**
     * Tests that the Config class extends the Nimbles\Core\Collection class
     * @return void
     */
    public function testAbstract() {
        $config = new Config();
        $this->assertInstanceOf('Nimbles\Core\Collection', $config);
    }
    
    /**
     * Tests getting an instance of config
     * @return void
     */
    public function testInstance() {
        $config = Config::getInstance();        
        $this->assertInstanceOf('Nimbles\App\Config', $config);
        
        $config->foo = 'bar';
        $config = Config::getInstance();
        $this->assertEquals('bar', $config->foo);
    }

    /**
     * Tests that the index type always remains associtive
     * @return void
     */
    public function testDefaultOptions() {
        $config = new Config();
        $this->assertEquals(Config::INDEX_MIXED, $config->getIndexType());
        $this->assertFalse($config->isReadOnly());

        $config = new Config(null, array(
            'indexType' => Config::INDEX_MIXED,
            'readonly'  => true
        ));
        $this->assertEquals(Config::INDEX_MIXED, $config->getIndexType());
        $this->assertTrue($config->isReadOnly());
    }

    /**
     * Tests that creating a config object from a construct
     * @return void
     */
    public function testConstruct() {
        $data = array(
            'a' => 1,
            'b' => array(
                'c' => 2
            ),
            'd' => new Config(array('e' => 4))
        );

        $config = new Config($data, array(
            'readonly'  => true
        ));

        $this->assertEquals(1, $config->a);
        $this->assertInstanceOf('Nimbles\App\Config', $config->b);
        $this->assertEquals(2, $config->b->c);
        $this->assertEquals(4, $config->d->e);

        $this->setExpectedException('Nimbles\Core\Collection\Exception\ReadOnly');
        $config->f = 'foo';
    }
    
    /**
     * Tests setting and getting config values
     * @return void
     */
    public function testAssignData() {
        $config = new Config();
        $config->foo = 123;
        
        $this->assertEquals(123, $config->foo);
        
        $config->bar = array('baz' => 456);
        $this->assertInstanceOf('Nimbles\App\Config', $config->bar);
        $this->assertEquals(456, $config->bar->baz);
        
        $this->setExpectedException('Nimbles\App\Config\Exception\InvalidValue');
        $config->quz = new \stdClass();
    }
    
    /**
     * Tests merging config objects
     * @return void
     */
    public function testMerge() {
        $config1 = new Config(array(
            'foo' => 123,
            'bar' => 456,
            'baz' => array(
                1,2,3
            )
        ));
        
        $config2 = new Config(array(
            'foo' => false,
            'baz' => array(
                4,5,6
            ),
            'quz' => true
        ));
        
        $config1->merge($config2);
        
        $this->assertFalse($config1->foo);
        $this->assertEquals(456, $config1->bar);
        $this->assertSame(array(4,5,6), $config1->baz->getArrayCopy());
        $this->assertTrue($config1->quz);
        
        $this->setExpectedException('Nimbles\App\Config\Exception\InvalidConfig');
        $config1->merge(123);
    }
}
