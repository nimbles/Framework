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
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\App\Response;

use Nimbles\App\TestCase,
    Nimbles\App\Response\Http;

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\App\TestCase
 * @trait      \Tests\Lib\Nimbles\Core\Options
 *
 * @group      Nimbles
 * @group      Nimbles-App
 * @group      Nimbles-App-Response
 */
class HttpTest extends TestCase {
	/**
     * Tests that a the object extends Nimbles\App\Response\ResponseAbstract
     * @return void
     */
    public function testAbstract() {
        $http = new Http();
        $this->assertType('Nimbles\App\Response\ResponseAbstract', $http);
    }
    
	/**
     * Tests getting and setting header values
     * @return void
     */
    public function testGetSetHeader() {
        $http = new Http();
        
        $this->assertType('Nimbles\App\Http\Header\Collection', $http->getHeader());
        $this->assertNull($http->getHeader('X-Foo'));
        
        $http->setHeader('X-Foo', 'Value');
        $this->assertType('Nimbles\App\Http\Header', $http->getHeader('X-Foo'));
        $this->assertSame(array('Value'), $http->getHeader('X-Foo')->getArrayCopy());
        
        $http->setHeader('X-Foo', 'Value2');
        $this->assertSame(array('Value2'), $http->getHeader('X-Foo')->getArrayCopy());
        
        $http->setHeader('X-Foo', 'Value3', true);
        $this->assertSame(array('Value2', 'Value3'), $http->getHeader('X-Foo')->getArrayCopy());
        
        $http->setHeader('X-Foo', array('Value4', 'Value5'), true);
        $this->assertSame(array('Value2', 'Value3', 'Value4', 'Value5'), $http->getHeader('X-Foo')->getArrayCopy());
    }
    
	/**
     * Data provider for options instance
     * @return array
     */
    public function optionsInstanceProvider() {
        return array(
            array(new Http())
        );
    }

    /**
     * Data provider for getting and setting an option
     * @return array
     */
    public function getSetOptionProvider() {
        return array(
            array(new Http(), 'body', 'foo', null)
        );
    }
    
    /**
     * Data provider for getting and setting options
     * @return array
     */
    public function getSetOptionsProvider() {
        return array(
            array(new Http(), array())
        );
    }
}