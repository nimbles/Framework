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
namespace Tests\Lib\Mu\App\Controller\Plugin;

use Mu\App\Controller\Plugin\PluginAbstract,
    Mu\App\Controller\ControllerAbstract;

/**
 * @category   Mu
 * @package    Mu-App
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\App\Controller\Plugin\PluginAbstract
 */
class PluginMock extends PluginAbstract {
    protected $_states = array();

    public function getStates() {
        return $this->_states;
    }

    public function update(ControllerAbstract &$controller) {
        $this->_states[] = $controller->getDispatchState();
        return parent::update($controller);
    }
}

/**
 * @category   Mu
 * @package    Mu-App
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\App\Controller\Plugin\PluginAbstract
 */
class ResponseSend extends PluginAbstract {
    public function update(ControllerAbstract &$controller) {
        if (ControllerAbstract::STATE_POSTDISPATCH === $controller->getDispatchState()) {
            $controller->getResponse()->send();
        }
        return parent::update($controller);
    }
}