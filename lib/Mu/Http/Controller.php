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
 * @package    Mu-Http
 * @subpackage Header
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Http;

use Mu\Core\Controller\ControllerAbstract;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Header
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Controller\ControllerAbstract
 */
class Controller extends ControllerAbstract {
    public function __get($property) {
        switch ($property) {
            case 'query' :
            case 'post' :
            case 'server' :
                $method = 'get' . ucfirst($property);
                return $this->getRequest()->$method();
                break;

            case 'requestHeader' :
                return $this->getRequest()->getHeader();
                break;

            case 'responseHeader' :
                return $this->getResponse()->getHeaders();
                break;

            case 'requestCookie' :
                return $this->getRequest()->getHeader();
                break;
        }

        return parent::__get($property);
    }

    public function __set($property, $value) {
        switch ($property) {
            case 'responseHeader' :
                return $this->getResponse()->setHeaders();
                break;
        }
        return parent::__set($property, $value);
    }

    public function postDispatch() {
        $this->getResponse()->send();
    }
}