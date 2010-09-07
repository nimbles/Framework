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

namespace Mu\App\Controller;

use Mu\Core\Request\RequestAbstract,
    Mu\Core\Response\ResponseAbstract,
    Mu\Core\Mixin\MixinAbstract;

/**
 * @category   Mu
 * @package    Mu-App
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\MixinAbstract
 * @uses       \Mu\Core\Plugin\Pluginable
 * @uses       \Mu\Core\Options
 *
 * @uses       \Mu\Core\Request\RequestAbstract
 * @uses       \Mu\Core\Response\ResponseAbstract
 *
 * @uses       \Mu\App\Controller\Exception\ActionNotFound
 * @uses       \Mu\App\Controller\Resource\ResourceAbstract
 * @uses       \Mu\App\Controller\Helper\HelperAbstract
 * @uses       \Mu\App\Controller\Plugin\PluginAbstract
 *
 * @property   \Mu\Core\Request\RequestAbstract $request
 * @property   \Mu\Core\Response\ResponseAbstract $response
 */
abstract class ControllerAbstract extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    static protected function _getImplements() {
        return array(
            'Mu\Core\Plugin\Pluginable' => array(
                'types' => array(
                    'resources' => array(
                        'abstract' => 'Mu\App\Controller\Resource\ResourceAbstract'
                    ),
                    'helpers' => array(
                        'abstract' => 'Mu\App\Controller\Helper\HelperAbstract'
                    ),
                    'plugins' => array(
                        'abstract' => 'Mu\App\Controller\Plugin\PluginAbstract'
                    )
                )
            ),
            'Mu\Core\Config\Options' => array(
                'dispatchState' => static::STATE_NOTDISPATCHED
            )
        );
    }

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
     * @return \Mu\App\Controller\ControllerAbstract
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
        $this->setOptions($options);
        $this->setRequest($request)
            ->setResponse($response);
    }

    /**
     * Magic __get to provider accesses for request and response
     * @param string $name
     * @return mixed
     */
    public function __get($name) {
        if (in_array($name, array('request', 'response'))) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }

        return parent::__get($name);
    }

    /**
     * Notifies the plugins and helpers of the pre dispatch state
     * @return \Mu\App\Controller\ControllerAbstract
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
        $this->notifyPreDispatch(); // not chained the user may forget to return $this
        $this->preDispatch();

        if ('Action' !== substr($action, -6)) {
            $action .= 'Action';
        }
        $this->_actionData = $this->_dispatchAction($action, $params);

        $this->notifyPostDispatch(); // not chained the user may forget to return $this
        $this->postDispatch();
    }

    /**
     * Dispatches the action
     * @param string     $action
     * @param array|null $params
     * @return mixed
     * @throws \Mu\App\Controller\Exception\ActionNotFound
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