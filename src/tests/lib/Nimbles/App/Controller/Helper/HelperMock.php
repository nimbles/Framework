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
namespace Tests\Lib\Nimbles\App\Controller\Helper;

use Nimbles\App\Controller\Helper\HelperAbstract,
    Nimbles\App\Controller\ControllerAbstract;

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\App\Controller\Helper\HelperAbstract
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