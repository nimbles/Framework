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
 * @package    Nimbles-Config
 * @subpackage ConfigurableTest
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Config;

use Nimbles\Config\TestCase,
    Nimbles\Config\Config;
    
require_once 'ConfigurableMock.php';

/**
 * @category   Nimbles
 * @package    Nimbles-Config
 * @subpackage ConfigurableTest
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Config\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Config
 */
class ConfigurableTest extends TestCase {
    /**
     * Tests that the mock has the traits methods
     * @return void
     */
    public function testTrait() {
        $configMock = new ConfigurableMock();
        
        $this->assertTrue(method_exists($configMock, 'getConfig'));
    }
    
    /**
     * Tests getting the config
     * @return void
     */
    public function testGetConfig() {
        $configMock = new ConfigurableMock();
        
        $this->assertType('Nimbles\Config\Config', $configMock->getConfig());
        
        $configMock->getConfig()->foo = 'bar';
        $this->assertEquals('bar', $configMock->getConfig()->foo);
        $this->assertEquals('bar', $configMock->getConfig('foo'));
        $this->assertNull($configMock->getConfig('bar'));
    }
}