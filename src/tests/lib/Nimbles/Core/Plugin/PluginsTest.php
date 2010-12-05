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
 * @package    Nimbles-Plugin
 * @subpackage PluginTest
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Plugin;

use Tests\Lib\Nimbles\Core\Plugin\PluginsStandaloneMock;

require_once 'PluginsMock.php';
require_once 'PluginsStandaloneMock.php';
require_once 'PluginsInvalidMock.php';

use Nimbles\Core\TestCase,
    Nimbles\Core\Plugin;

/**
 * @category   Nimbles
 * @package    Nimbles-Plugin
 * @subpackage PluginTest
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Plugin\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Plugin
 */
class PluginsTest extends TestCase {
    /**
     * Tests that the mock have get the traits methods
     * @return void
     */
    public function testTrait() {
        $mock1 = new PluginsMock(array());
        
        // this mock uses 2 traits
        $this->assertTrue(method_exists($mock1, 'getConfig'));
        $this->assertTrue(method_exists($mock1, 'getPlugin'));
        $this->assertTrue(method_exists($mock1, 'attach'));
        $this->assertTrue(method_exists($mock1, 'detach'));
        $mock2 = new PluginsStandaloneMock(array());
        
        // this mock defines its own getConfig
        $this->assertTrue(method_exists($mock2, 'getConfig'));
        $this->assertTrue(method_exists($mock2, 'getPlugin'));
        $this->assertTrue(method_exists($mock2, 'attach'));
        $this->assertTrue(method_exists($mock2, 'detach'));
        
        $mock3 = new PluginsInvalidMock();
        
        // this mock should not have getConfig
        $this->assertFalse(method_exists($mock3, 'getConfig'));
        $this->assertTrue(method_exists($mock3, 'getPlugin'));
        $this->assertTrue(method_exists($mock3, 'attach'));
        $this->assertTrue(method_exists($mock3, 'detach'));
    }
    
    /**
     * Tests the the Nimbles\Plugin\Exception\InvalidConfig exception is thrown
     * when the invalid mock is used as it does not have a getConfig method
     * @return void
     */
    public function testInvalidMock() {
        $mock = new PluginsInvalidMock();
        $this->setExpectedException('Nimbles\Core\Plugin\Exception\InvalidConfig');
        $mock->getPlugin();
    }
    
    /**
     * Tests using plugins
     * @param string $mock
     * @return void
     * 
     * @dataProvider mockProvider
     */
    public function testMock($mock) {
        $mock = new $mock(array(
            'foo' => array(
                'type' => 'string'
            ),
            'bar' => array(
                'type' => 'int'
            )
        ));
        
        $this->assertType('Nimbles\Core\Plugin\Collection', $mock->getPlugin());
        
        $this->assertType('Nimbles\Core\Plugin', $mock->getPlugin()->foo);
        $this->assertType('Nimbles\Core\Plugin', $mock->getPlugin('foo'));
        
        $this->assertType('Nimbles\Core\Plugin', $mock->getPlugin()->bar);
        $this->assertType('Nimbles\Core\Plugin', $mock->getPlugin('bar'));
        
        $this->assertEquals('foo', $mock->getPlugin()->foo->getName());
        $this->assertEquals('bar', $mock->getPlugin()->bar->getName());
        
        $mock->attach('foo', 'bar', 'a');
        $mock->attach('bar', 'foo', 1);
        
        $this->assertEquals('a', $mock->getPlugin()->foo->bar);
        $this->assertEquals(1, $mock->getPlugin()->bar->foo);
        
        $mock->detach('foo', 'bar');
        $mock->detach('bar', 'foo');
        
        $this->assertFalse($mock->getPlugin()->foo->offsetExists('bar'));
        $this->assertFalse($mock->getPlugin()->bar->offsetExists('foo'));
    }
    
    /**
     * Data provider of mock names
     * @return void
     */
    public function mockProvider() {
        return array(
            array('Tests\Lib\Nimbles\Core\Plugin\PluginsMock'),
            array('Tests\Lib\Nimbles\Core\Plugin\PluginsStandaloneMock'),
        );   
    }
    
}