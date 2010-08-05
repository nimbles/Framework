<?php
/**
 * Mu Framework
 *
 * LICENSE
 *
 * This shouce file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://mu-framework.com/license/mit
 *
 * @category   Mu
 * @package    Mu-Http_Client
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Http\Client\Adapter;

use Mu\Core\Request;


/**
 * @category   Mu
 * @package    Mu-Http_Client
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Response\ResponseAbstract
 * @uses       \Mu\Core\Delegates\Delegatable
 * @uses       \Mu\Core\Config\Options
 *
 * @uses       \Mu\Http\Header
 * @uses       \Mu\Http\Status
 */

interface AdapterInterface {
    /**
     * Set the request
     * @param RequestAbstract $request
     */
    public function setRequest(RequestAbstract $request);
    /**
     * Write request
     */
    public function write();
}