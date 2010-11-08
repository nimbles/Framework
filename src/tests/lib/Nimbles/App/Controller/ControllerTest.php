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
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\App\Controller;

require_once 'ControllerMock.php';

use Nimbles\App\TestCase,
    Nimbles\App\Controller\ControllerAbstract;

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\App\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-App
 * @group      Nimbles-App-Controller
 */
class ControllerTest extends TestCase {
    /**
     * Tests that the Nimbles\App\Controller\Exception\ActionNotFound exception is thrown when
     * trying to dispatch an action that doesnt exist
     * @return void
     */
    public function testActionNotFound() {
        $controller = new ControllerMock(new RequestMock(), new ResponseMock());
        $this->setExpectedException('Nimbles\App\Controller\Exception\ActionNotFound');
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
            'Tests\Lib\Nimbles\App\Controller\ControllerMock',
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

        // add 3 plugins
        for($i = 0; $i < 3; $i++) {
            $plugin = $this->getMock(
                'Tests\Lib\Nimbles\App\Controller\Plugin\PluginMock',
                array('update'),
                array(),
                'PluginMock' . $i
            );
            $plugin->expects($this->exactly(2))->method('update')->with($controller);
            $controller->plugins->attach('plugin' . $i, $plugin);
        }

        $plugin = new Plugin\PluginMock();
        $controller->plugins->attach('pluginStates', $plugin);

        $controller->dispatch('testAction');

        $this->assertSame(array(
            ControllerAbstract::STATE_PREDISPATCH,
            ControllerAbstract::STATE_POSTDISPATCH
        ), $plugin->getStates());

        $this->setExpectedException('Nimbles\Core\Plugin\Exception\PluginAlreadyRegistered');
        $controller->plugins->attach('pluginStates2', $plugin);
    }

    /**
     * Tests dispatching an action with helpers, checks if the helpers are notified
     * @return void
     */
    public function testHelpers() {
        $controller = new ControllerMock(new RequestMock(), new ResponseMock());

        $helperMock = $this->getMock(
            'Tests\Lib\Nimbles\App\Controller\Helper\HelperMock',
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

        $this->setExpectedException('Nimbles\Core\Plugin\Exception\PluginAlreadyRegistered');
        $controller->helpers->attach('helper2', $helper);
    }

    /**
     * Tests using a helper within a controller
     * @param string $dispatchMethod
     * @param string $expectedMethod The expected method to be called on the helper
     * @return void
     * @dataProvider actionHelperDispatchMethodProvider
     */
    public function testActionHelper($dispatchMethod, $expectedMethod) {
        $controller = new ControllerMock(new RequestMock(), new ResponseMock());

        $helper = $this->getMock(
            'Tests\Lib\Nimbles\App\Controller\Helper\HelperMock',
            array($expectedMethod)
        );
        $helper->expects($this->once())->method($expectedMethod);
        $controller->helpers->attach('states', $helper);

        $controller->dispatch($dispatchMethod);
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
     * Tests that when dispatching the different action methods the send
     * is always called
     *
     * @param string $action
     * @return void
     * @dataProvider actionProvider
     */
    public function testPluginSend($action) {
        $response = $this->getMock(
            'Tests\Lib\Nimbles\App\Controller\ResponseMock',
            array('send')
        );

        $response->expects($this->once())->method('send');

        $controller = new ControllerMock(new RequestMock(), $response);
        $controller->plugins->attach('send', new Plugin\ResponseSend());
        $controller->dispatch('testAction');
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

        $this->assertType('Nimbles\Core\Request\RequestAbstract', $controller->getRequest());
        $this->assertType('Nimbles\Core\Request\RequestAbstract', $controller->request);

        $this->assertType('Nimbles\Core\Response\ResponseAbstract', $controller->getResponse());
        $this->assertType('Nimbles\Core\Response\ResponseAbstract', $controller->response);

        $this->assertType('Nimbles\Core\Plugin', $controller->plugins);
        $this->assertType('Nimbles\Core\Plugin', $controller->helpers);
        $this->assertType('Nimbles\Core\Plugin', $controller->resources);
    }

    /**
     * Data provider for the action method names for the action helper test
     * @return array
     */
    public function actionHelperDispatchMethodProvider() {
        return array(
            array('helperMethodAction', 'getStates'),
            array('helperDirectAction', '__invoke'),
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

    /**
     * Data provider for the action methods names in the controller mock
     * @return array
     */
    public function actionProvider() {
        return array(
            array('testAction'),
            array('helperMethodAction'),
            array('helperDirectAction'),
            array('resourceMethodAction'),
            array('resourceDirectAction'),
        );
    }
}