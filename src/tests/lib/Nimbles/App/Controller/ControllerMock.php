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

use Nimbles\App\Controller\ControllerAbstract,
    Nimbles\Core\Request\RequestAbstract,
    Nimbles\Core\Response\ResponseAbstract;

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\App\Controller\ControllerAbstract
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
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Request\RequestAbstract
 */
class RequestMock extends RequestAbstract {
    public function getBody() {}

    static public function build() {}
}

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Response\ResponseAbstract
 */
class ResponseMock extends ResponseAbstract {
    public function send() {}
}