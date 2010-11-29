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

namespace Tests\Lib\Nimbles\Adapter;

require_once 'AdapterMock.php';

use Nimbles\Adapter\TestCase,
    Nimbles\Adapter\Adapter,
    Tests\Lib\Nimbles\Adapter as TestAdapter;

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
class AdapterTest extends TestCase {
    /**
     * Tests using the adapter class
     * @param array $options
     * 
     * @dataProvider optionsProvider
     */
    public function testAdapter(array $options, $adapter = null) {
        $instance = new Adapter($options);
        
        $this->assertEquals($options['type'], $instance->getType());
        $this->assertEquals($options['namespaces'], $instance->getNamespaces());
        
        if (null !== $adapter) {         
            call_user_func_array(array($instance, 'setAdapter'), $adapter);
        }
        
        $adapter = $instance->getAdapter();
        
        if (null !== $options['type']) {
            $this->assertType($options['type'], $adapter);
        }
        
        if (method_exists($adapter, 'getParameters')) {
            $this->assertEquals(1, $adapter->param1);
            $this->assertEquals(2, $adapter->param2);
        }
    }
    
    /**
     * Data provider for adapter options
     * @return void
     */
    public function optionsProvider() {
        return array(
            array(
                array(
                    'type' => null,
                    'namespaces' => null  
                )
            ),
            array(
                array(
                    'type' => 'Tests\Lib\Nimbles\Adapter\AdapterSingle',
                    'namespaces' => array('Tests\Lib\Nimbles\Adapter')
                ),
                array(new TestAdapter\AdapterSingle())
            ),
            array(
                array(
                    'type' => 'Tests\Lib\Nimbles\Adapter\AdapterSingle',
                    'namespaces' => array('Tests\Lib\Nimbles\Adapter')
                ),
                array('AdapterSingle')
            ),
            array(
                array(
                    'type' => 'Tests\Lib\Nimbles\Adapter\AdapterParameters',
                    'namespaces' => array('Tests\Lib\Nimbles\Adapter')
                ),
                array(new TestAdapter\AdapterParameters(1, 2))
            ),
            array(
                array(
                    'type' => 'Tests\Lib\Nimbles\Adapter\AdapterParameters',
                    'namespaces' => array('Tests\Lib\Nimbles\Adapter')
                ),
                array('AdapterParameters', 1, 2)
            ),
            array(
                array(
                    'type' => 'Tests\Lib\Nimbles\Adapter\AdapterAbstract',
                    'namespaces' => array('Tests\Lib\Nimbles\Adapter')
                ),
                array(new TestAdapter\AdapterConcrete())
            ),
            array(
                array(
                    'type' => 'Tests\Lib\Nimbles\Adapter\AdapterAbstract',
                    'namespaces' => array('Tests\Lib\Nimbles\Adapter')
                ),
                array('AdapterConcrete')
            ),
            
            array(
                array(
                    'type' => 'Tests\Lib\Nimbles\Adapter\AdapterInterface',
                    'namespaces' => array('Tests\Lib\Nimbles\Adapter')
                ),
                array(new TestAdapter\AdapterImplementor())
            ),
            array(
                array(
                    'type' => 'Tests\Lib\Nimbles\Adapter\AdapterInterface',
                    'namespaces' => array('Tests\Lib\Nimbles\Adapter')
                ),
                array('AdapterImplementor')
            ),
        );
    }
}