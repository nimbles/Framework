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

use Mu\App\Controller\ControllerAbstract,
    Mu\Core\Request\RequestAbstract,
    Mu\Core\Response\ResponseAbstract;

/**
 * @category   Mu
 * @package    Mu-App
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\App\Controller\ControllerAbstract
 */
class ControllerMock extends ControllerAbstract {
    public function testAction() {}

    public function sendAction() {
        $this->response->body = 'hello world';
    }

    public $dump;

    public function helperDirectAction() {
        $this->dump = $this->helpers->states();
    }

    public function helperMethodAction() {
        $this->dump = $this->helpers->states->getStates();
    }

    public function resourceDirectAction() {
        $this->dump = $this->resources->string();
    }

    public function resourceMethodAction() {
        $this->dump = $this->resources->string->getResource();
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
 * @uses       \Mu\Core\Request\RequestAbstract
 */
class RequestMock extends RequestAbstract {
    public function getBody() {}

    static public function build() {}
}

/**
 * @category   Mu
 * @package    Mu-App
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Response\ResponseAbstract
 */
class ResponseMock extends ResponseAbstract {
    public function send() {}
}