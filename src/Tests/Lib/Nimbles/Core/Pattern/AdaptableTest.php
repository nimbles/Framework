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
 * @package    Nimbles-Adapter
 * @subpackage AdapterTest
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Pattern;

require_once 'AdaptableMock.php';

use Nimbles\Core\TestCase,
    Nimbles\Core\Pattern\Adapter;

/**
 * @category   Nimbles
 * @package    Nimbles-Adapter
 * @subpackage AdapterTest
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Adapter\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Adapter
 */
class AdaptableTest extends TestCase {
    /**
     * Tests getting the adapter object
     * @return void
     */
    public function testGetAdapterObject() {
        $mock = new AdaptableSingleMock();
        $this->assertInstanceOf('Nimbles\Core\Pattern\Adapter', $mock->getAdapterObject());
        
        // invalidate the apater object
        $mock->adapter = 'adapter';
        
        $this->setExpectedException('Nimbles\Core\Pattern\Adapter\Exception\InvalidInstance');
        $mock->getAdapterObject();
    }
    
    /**
     * Tests getting and setting the adapter
     * @param object $mock
     * @return void
     * 
     * @dataProvider mockProvider 
     */
    public function testGetSetAdapter($mock) {
        if ($mock instanceof AdaptableSingleNoConfigMocks) {
            $this->setExpectedException('Nimbles\Core\Pattern\Adapter\Exception\InvalidConfig');
            $mock->getAdapterObject();
            return;
        }
        
        $this->assertInstanceOf('Nimbles\Core\Pattern\Adapter', $mock->getAdapterObject());

        $mock->setAdapter(new AdapterConcrete());
        $this->assertInstanceOf('Tests\Lib\Nimbles\Core\Pattern\AdapterConcrete', $mock->getAdapter());
        
        $mock->setAdapter('AdapterConcrete');
        $this->assertInstanceOf('Tests\Lib\Nimbles\Core\Pattern\AdapterConcrete', $mock->getAdapter());
    }
    
    /**
     * Data provider for mocks
     * @return array
     */
    public function mockProvider() {
        return array(
            array(new AdaptableSingleNoConfigMocks()),
            array(new AdaptableSingleMock()),
            array(new AdaptableTypedMock()),
        );
    }
}