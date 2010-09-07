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

namespace Tests\Lib\Mu\Core\Controller;

use Mu\Core\Controller\ControllerAbstract,
    Mu\Core\Request\RequestAbstract,
    Mu\Core\Response\ResponseAbstract;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Controller\ControllerAbstract
 */
class ControllerMock extends ControllerAbstract {
    public function testAction() {}
}

/**
 * @category   Mu
 * @package    Mu-Core
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
 * @package    Mu-Core
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