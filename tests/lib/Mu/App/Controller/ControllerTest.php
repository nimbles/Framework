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

namespace Tests\Lib\Mu\App\Controller;

require_once 'ControllerMock.php';

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
class ControllerTest extends TestCase {
    /**
     * Tests that the Mu\App\Controller\Exception\ActionNotFound exception is thrown when
     * trying to dispatch an action that doesnt exist
     * @return void
     */
    public function testNoAction() {
        $controller = new ControllerMock(new RequestMock(), new ResponseMock());
        $this->setExpectedException('Mu\App\Controller\Exception\ActionNotFound');
        $controller->dispatch('missingAction');
    }

    /**
     * Tests dispatching an action
     * @return void
     */
    public function testAction() {
        $methods = array(
            'testAction',
            'notifyPreDispatch',
            'preDispatch',
            'notifyPostDispatch',
            'postDispatch'
        );

        $controller = $this->getMock(
            'Tests\Lib\Mu\App\Controller\ControllerMock',
            $methods,
            array(new RequestMock(), new ResponseMock())
        );

        foreach ($methods as $method) {
            $controller->expects($this->once())->method($method);
        }

        $controller->dispatch('testAction');
    }
}