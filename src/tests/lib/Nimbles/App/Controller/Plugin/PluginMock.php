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
namespace Tests\Lib\Nimbles\App\Controller\Plugin;

use Nimbles\App\Controller\Plugin\PluginAbstract,
    Nimbles\App\Controller\ControllerAbstract;

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\App\Controller\Plugin\PluginAbstract
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
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\App\Controller\Plugin\PluginAbstract
 */
class ResponseSend extends PluginAbstract {
    public function update(ControllerAbstract &$controller) {
        if (ControllerAbstract::STATE_POSTDISPATCH === $controller->getDispatchState()) {
            $controller->getResponse()->send();
        }
        return parent::update($controller);
    }
}