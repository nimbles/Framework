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

use Mu\Core\Mixin\MixinAbstract;

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
        )
    );

    /**
     * Dispatch states
     * @var int
     */
    const STATE_PREDISPATCH  = 0;
    const STATE_DISPATCH     = 1;
    const STATE_POSTDISPATCH = 2;

    /**
     * Dispatch state
     * @var int
     */
    protected $_dispatchState;

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
        try {
            $this->notifyPreDispatch()->preDispatch();

            if ('Action' !== substr($action, -6)) {
                $action .= 'Action';
            }
            $this->_dispatchAction($action, $params);

            $this->notifyPostDispatch()->postDispatch();
        } catch (\Exception $ex) {

        }
    }

    /**
     * Dispatches the action
     * @param string     $action
     * @param array|null $params
     * @return mixed
     */
    protected function _dispatchAction($action, array $params = null) {
        if (!method_exists($this, $action)) {
            // @todo throw
        }

        $params = (null === $params) ? array() : $params;
        return call_user_func_array(array($this, $action), $params);
    }

    /**
     * Notifies the plugins and helpers of the post dispatch state
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