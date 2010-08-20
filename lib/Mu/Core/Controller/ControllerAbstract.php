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
 * @package    Mu-Core
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Controller;

use Mu\Core\Request\RequestAbstract,
    Mu\Core\Response\ResponseAbstract,
    Mu\Core\Mixin\MixinAbstract;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\MixinAbstract
 */
abstract class ControllerAbstract extends MixinAbstract {
    /**
     * Class implements
     * @var array
     */
    protected $_implements = array(
        'Mu\Core\Plugin\Pluginable' => array(
            'types' => array(
                'resources' => array(
                    'abstract' => 'Mu\Core\Controller\Resource\ResourceAbstract'
                ),
                'helpers' => array(
                    'abstract' => 'Mu\Core\Controller\Helper\HelperAbstract'
                ),
                'plugins' => array(
                    'abstract' => 'Mu\Core\Controller\Plugin\PluginAbstract'
                )
            )
        ),
        'Mu\Core\Options' => array(
            'dispatchState' => static::STATE_NOTDISPATCHED
        )
    );

    /**
     * Dispatch states
     * @var int
     */
    const STATE_NOTDISPATCHED = -1;
    const STATE_PREDISPATCH   = 0;
    const STATE_DISPATCH      = 1;
    const STATE_POSTDISPATCH  = 2;

    /**
     * Dispatch state
     * @var int
     */
    protected $_dispatchState;

    /**
     * The resulting data returned from an action
     * @var mixed
     */
    protected $_actionData;

    /**
     * The request that launched this controller
     * @var \Mu\Core\Request\RequestAbstract
     */
    protected $_request;

    /**
     * The response from this controller
     * @var \Mu\Core\Response\ResponseAbstract
     */
    protected $_response;

    /**
     * Gets the dispatch state
     * @return int
     */
    public function getDispatchState() {
        return $this->_dispatchState;
    }

    /**
     * Sets the dispatch state
     * @param int $state
     * @return \Mu\Core\Controller\ControllerAbstract
     */
    public function setDispatchState($state) {
        $this->_dispatchState = is_int($state) ? $state : $this->_dispatchState;
        return $this;
    }

    /**
     * Gets the resulting data returned from an action
     * @return mixed
     */
    public function getActionData() {
        return $this->_actionData;
    }

    /**
     * Gets the request that launched this controller
     * @return \Mu\Core\Request\RequestAbstract
     */
    public function getRequest() {
        return $this->_request;
    }

    public function setRequest(RequestAbstract $request) {
        $this->_request = $request;
        return $this;
    }

    /**
     * Gets the response from this controller
     * @return \Mu\Core\Response\ResponseAbstract
     */
    public function getResponse() {
        return $this->_response;
    }

    public function setResponse(ResponseAbstract $response) {
        $this->_response = $response;
        return $this;
    }

    /**
     * Class constructor
     * @param $options
     */
    public function __construct(RequestAbstract $request, ResponseAbstract $response, $options = null) {
        parent::__construct();
        $this->setOptions();
        $this->setRequest($request)
            ->setResponse($response);
    }

    /**
     * Notifies the plugins and helpers of the pre dispatch state
     * @return \Mu\Core\Controller\ControllerAbstract
     */
    public function notifyPreDispatch() {
        $this->setDispatchState(static::STATE_PREDISPATCH);
        $this->notify('plugins');
        $this->notify('helpers');

        return $this;
    }

    /**
     * Pre dispatch method
     * @return void
     */
    public function preDispatch() {}

    /**
     * Dispatches the action
     * @param string     $action
     * @param array|null $params
     * @return void
     */
    public function dispatch($action, array $params = null) {
        $this->notifyPreDispatch()->preDispatch();

        if ('Action' !== substr($action, -6)) {
            $action .= 'Action';
        }
        $this->_actionData = $this->_dispatchAction($action, $params);

        $this->notifyPostDispatch()->postDispatch();
    }

    /**
     * Dispatches the action
     * @param string     $action
     * @param array|null $params
     * @return mixed
     */
    protected function _dispatchAction($action, array $params = null) {
        $this->setDispatchState(static::STATE_DISPATCH);
        if (!method_exists($this, $action)) {
            throw new Exception\ActionNotFound('Cannot find action ' . $action . ' in the ' . __CLASS__ . ' controller');
        }

        $params = (null === $params) ? array() : $params;
        return call_user_func_array(array($this, $action), $params);
    }

    /**
     * Notifies the plugins and helpers of the post dispatch state
     * @return void
     */
    public function notifyPostDispatch() {
        $this->setDispatchState(static::STATE_POSTDISPATCH);
        $this->notify('helpers');
        $this->notify('plugins');

        return $this;
    }

    /**
     * Post dispatch method
     * @return void
     */
    public function postDispatch() {}
}