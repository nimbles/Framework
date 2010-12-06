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

require_once 'AdapterMock.php';

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
 * @trait      \Tests\Lib\Nimbles\Core\Options
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
    public function testAdapter(array $options, $adapter = null, $exception = null) {
        if (null !== $exception) {
            $this->setExpectedException($exception);
        }
        
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
                    'type' => 'Tests\Lib\Nimbles\Core\Pattern\AdapterSingle',
                    'namespaces' => array('Tests\Lib\Nimbles\Core\Pattern')
                ),
                array(new AdapterSingle())
            ),
            array(
                array(
                    'type' => 'Tests\Lib\Nimbles\Core\Pattern\AdapterSingle',
                    'namespaces' => array('Tests\Lib\Nimbles\Core\Pattern')
                ),
                array('AdapterSingle')
            ),
            array(
                array(
                    'adapter' => new AdapterSingle(),
                    'type' => 'Tests\Lib\Nimbles\Core\Pattern\AdapterSingle',
                    'namespaces' => array('Tests\Lib\Nimbles\Core\Pattern'),
                ),
            ),
            array(
                array(
                    'type' => 'Tests\Lib\Nimbles\Core\Pattern\AdapterParameters',
                    'namespaces' => array('Tests\Lib\Nimbles\Core\Pattern')
                ),
                array(new AdapterParameters(1, 2))
            ),
            array(
                array(
                    'type' => 'Tests\Lib\Nimbles\Core\Pattern\AdapterParameters',
                    'namespaces' => array('Tests\Lib\Nimbles\Core\Pattern')
                ),
                array('AdapterParameters', 1, 2)
            ),
            array(
                array(
                    'type' => 'Tests\Lib\Nimbles\Core\Pattern\AdapterParameters',
                    'namespaces' => array('Tests\Lib\Nimbles\Core\Pattern')
                ),
                array('AdapterParameters'),
                'Nimbles\Core\Pattern\Adapter\Exception\CreateInstanceFailure'
            ),
            array(
                array(
                    'type' => 'Tests\Lib\Nimbles\Core\Pattern\AdapterAbstract',
                    'namespaces' => array('Tests\Lib\Nimbles\Core\Pattern')
                ),
                array(new AdapterConcrete())
            ),
            array(
                array(
                    'type' => 'Tests\Lib\Nimbles\Core\Pattern\AdapterAbstract',
                    'namespaces' => array('Tests\Lib\Nimbles\Core\Pattern')
                ),
                array('AdapterConcrete')
            ),
            array(
                array(
                    'adapter' => new AdapterSingle(),
                    'type' => 'Tests\Lib\Nimbles\Core\Pattern\AdapterAbstract',
                    'namespaces' => array('Tests\Lib\Nimbles\Core\Pattern')
                ),
                null,
                'Nimbles\Core\Pattern\Adapter\Exception\InvalidAdapter',
            ),
            array(
                array(
                    'type' => 'Tests\Lib\Nimbles\Core\Pattern\AdapterInterface',
                    'namespaces' => array('Tests\Lib\Nimbles\Core\Pattern')
                ),
                array(new AdapterImplementor())
            ),
            array(
                array(
                    'type' => 'Tests\Lib\Nimbles\Core\Pattern\AdapterInterface',
                    'namespaces' => array('Tests\Lib\Nimbles\Core\Pattern')
                ),
                array('AdapterImplementor')
            ),
            array(
                array(
                    'adapter' => 'AdapterImplemented',
                    'type' => 'Tests\Lib\Nimbles\Core\Pattern\AdapterInterface',
                    'namespaces' => array('Tests\Lib\Nimbles\Core\Pattern')
                ),
                null,
                'Nimbles\Core\Pattern\Adapter\Exception\InvalidNamespaces',
            ),
            array(
                array(
                    'adapter' => 'AdapterImplemented',
                    'type' => 'Tests\Lib\Nimbles\Core\Pattern\AdapterInterface',
                ),
                null,
                'Nimbles\Core\Pattern\Adapter\Exception\InvalidAdapter',
            ),
            array(
                array(
                    'type' => 'Tests\Lib\Nimbles\Core\Pattern\AdapterInterface',
                    'namespaces' => 123,
                ),
                null,
                'Nimbles\Core\Pattern\Adapter\Exception\InvalidNamespaces'
            ),
            
            array(
                array(
                    'type' => 123,
                    'namespaces' => array('Tests\Lib\Nimbles\Core\Pattern')
                ),
                null,
                'Nimbles\Core\Pattern\Adapter\Exception\InvalidType'
            ),
        );
    }
    
	/**
     * Data provider for options instance
     * @return array
     */
    public function optionsInstanceProvider() {
        return array(
            array(new Adapter())
        );
    }
    
    /**
     * Data provider for getting and setting an option on a given instance
     * @return void
     */
    public function getSetOptionProvider() {
        return array(
            array(new Adapter(), 'type', null)
        );
    }
    
	/**
     * Data provider for getting and setting options on a given instance
     * @return void
     */
    public function getSetOptionsProvider() {
        return array(
            array(
                new Adapter(),
                array(
                    'type' => null,
                    'namespaces' => null  
                )
            )
        );
    }
}