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

use Mu\App\TestCase,
    Mu\App\Controller\ControllerAbstract;

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
    public function testActionNotFound() {
        $controller = new ControllerMock(new RequestMock(), new ResponseMock());
        $this->setExpectedException('Mu\App\Controller\Exception\ActionNotFound');
        $controller->dispatch('missingAction');
    }

    /**
     * Tests dispatching an action with no helpers or plugins
     * @return void
     */
    public function testDispatchFlow() {
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

    /**
     * Tests dispatching an action with plugins, checks if the plugins are notified
     * @return void
     */
    public function testPlugins() {
        $controller = new ControllerMock(new RequestMock(), new ResponseMock());

        $plugins = array();
        // add 3 plugins
        for($i = 0; $i < 3; $i++) {
            $plugin = $this->getMock(
                'Tests\Lib\Mu\App\Controller\Plugin\PluginMock',
                array('update')
            );
            $plugin->expects($this->exactly(2))->method('update')->with($controller);
            $controller->plugins->attach('plugin' . $i, $plugin);

            // add a second plugin to test states
            $plugins[$i] = new Plugin\PluginMock();
            $controller->plugins->attach('pluginStates' . $i, $plugins[$i]);
        }

        $controller->dispatch('testAction');

        // test the plugins were called pre and post dispatch
        foreach($plugins as $plugin) {
            $this->assertSame(array(
                ControllerAbstract::STATE_PREDISPATCH,
                ControllerAbstract::STATE_POSTDISPATCH
            ), $plugin->getStates());
        }
    }

    /**
     * Tests dispatching an action with helpers, checks if the helpers are notified
     * @return void
     */
    public function testHelpers() {
        $controller = new ControllerMock(new RequestMock(), new ResponseMock());

        $helperMock = $this->getMock(
            'Tests\Lib\Mu\App\Controller\Helper\HelperMock',
            array('update')
        );
        $helperMock->expects($this->exactly(2))->method('update')->with($controller);
        $controller->helpers->attach('helperMock', $helperMock);

        $helper = new Helper\HelperMock();
        $controller->helpers->attach('helper', $helper);

        $controller->dispatch('testAction');

        // test the plugins were called pre and post dispatch
        $this->assertSame(array(
            ControllerAbstract::STATE_PREDISPATCH,
            ControllerAbstract::STATE_POSTDISPATCH
        ), $helper->getStates());
    }

    /**
     * Tests using a helper within a controller
     * @param string $dispatchMethod
     * @return void
     * @dataProvider actionHelperDispatchMethodProvider
     */
    public function testActionHelper($dispatchMethod) {
        $controller = new ControllerMock(new RequestMock(), new ResponseMock());
        $helper = new Helper\HelperMock();
        $controller->helpers->attach('states', $helper);

        $controller->dispatch($dispatchMethod);
        $this->assertSame(array(ControllerAbstract::STATE_PREDISPATCH), $controller->dump);
    }

    /**
     * Tests using a resource within a contoller
     * @param string $dispatchMethod
     * @return void
     * @dataProvider actionResourceDispatchMethodProvider
     */
    public function testResource($dispatchMethod) {
        $controller = new ControllerMock(new RequestMock(), new ResponseMock());
        $resource = new Resource\ResourceMock();
        $controller->resources->attach('string', $resource);

        $controller->dispatch($dispatchMethod);
        $this->assertEquals('resource1', $controller->dump);

        // dispatch again to check resource is the the same
        $controller->dispatch($dispatchMethod);
        $this->assertEquals('resource1', $controller->dump);
    }

    /**
     * Tests that the dispatch state changes
     * @return void
     */
    public function testDispatchState() {
        $controller = new ControllerMock(new RequestMock(), new ResponseMock());
        $this->assertEquals(ControllerAbstract::STATE_NOTDISPATCHED, $controller->getDispatchState());
    }

    /**
     * Tests the getters for a controller
     * @return void
     */
    public function testGetters() {
        $controller = new ControllerMock(new RequestMock(), new ResponseMock());

        $this->assertType('Mu\Core\Request\RequestAbstract', $controller->getRequest());
        $this->assertType('Mu\Core\Request\RequestAbstract', $controller->request);

        $this->assertType('Mu\Core\Response\ResponseAbstract', $controller->getResponse());
        $this->assertType('Mu\Core\Response\ResponseAbstract', $controller->response);

        $this->assertType('Mu\Core\Plugin', $controller->plugins);
        $this->assertType('Mu\Core\Plugin', $controller->helpers);
        $this->assertType('Mu\Core\Plugin', $controller->resources);
    }

    /**
     * Data provider for the action method names for the action helper test
     * @return array
     */
    public function actionHelperDispatchMethodProvider() {
        return array(
            array('helperMethodAction'),
            array('helperDirectAction'),
        );
    }

    /**
     * Data provider for the action method names for the action resource test
     * @return array
     */
    public function actionResourceDispatchMethodProvider() {
        return array(
            array('resourceMethodAction'),
            array('resourceDirectAction'),
        );
    }
}