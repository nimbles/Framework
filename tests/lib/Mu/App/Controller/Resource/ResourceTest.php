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
 * @category   Mu
 * @package    Mu-App
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\App\Controller\Resource;

require_once 'ResourceMock.php';

use Mu\App\TestCase;

/**
 * @category   Mu
 * @package    Mu-App
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\App\TestCase
 *
 * @group      Mu
 * @group      Mu-App
 * @group      Mu-App-Controller
 */
class ResourceTest extends TestCase {

    /**
     * Tests that a helper implements the __invoke method and that the init method
     * is only called once when multiple invokes are made
     * @return void
     */
    public function testInvoke() {
        $mock = $this->getMock(
            'Tests\Lib\Mu\App\Controller\Resource\ResourceMock',
            array('init')
        );
        $mock->expects($this->once())->method('init');

        $this->assertTrue(method_exists($mock, '__invoke'));
        $this->assertTrue(is_callable($mock));

        $this->assertFalse($mock->isInitialized());
        $mock();

        $this->assertTrue($mock->isInitialized());
        $mock();

        $mock = $this->getMock(
            'Tests\Lib\Mu\App\Controller\Resource\ResourceMock',
            array('getResource')
        );

        $mock->expects($this->exactly(2)) ->method('getResource');

        $mock();
        $mock();
    }

    /**
     * Tests that the init method is only called once when getting the resource
     * @return void
     */
    public function testGetResource() {
        $mock = $this->getMock(
            'Tests\Lib\Mu\App\Controller\Resource\ResourceMock',
            array('init')
        );
        $mock->expects($this->once())->method('init');

        $this->assertFalse($mock->isInitialized());
        $mock->getResource();

        $this->assertTrue($mock->isInitialized());
        $mock->getResource();
    }
}