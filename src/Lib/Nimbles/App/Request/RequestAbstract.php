<?php
/**
 * Nimbles Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://Nimbles-framework.com/license/mit
 *
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\App\Request;

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 * 
 * @uses       \Nimbles\App\Request\RequestInterface
 */
abstract class RequestAbstract 
    implements RequestInterface{
    /**
     * Creates an application request object based on the SAPI
     * @return \Nimbles\App\Request\RequestAsbtract
     * @todo Extend as new request types become available
     */
    public static function factory() {
        if ('cli' === PHP_SAPI) {
            // @todo create a cli request object
        }
        
        return Http::build();
    }
}