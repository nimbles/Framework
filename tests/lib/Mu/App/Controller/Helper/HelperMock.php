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
namespace Tests\Lib\Mu\App\Controller\Helper;

use Mu\App\Controller\Helper\HelperAbstract,
    Mu\App\Controller\ControllerAbstract;

/**
 * @category   Mu
 * @package    Mu-App
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\App\Controller\Helper\HelperAbstract
 */
class HelperMock extends HelperAbstract {
    protected $_states = array();

    public function __invoke() {
        return $this->getStates();
    }

    public function getStates() {
        return $this->_states;
    }

    public function update(ControllerAbstract &$controller) {
        $this->_states[] = $controller->getDispatchState();
        return parent::update($controller);
    }
}