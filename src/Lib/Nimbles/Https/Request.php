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
 * @package    Nimbles-Https
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Https;

/**
 * @category   Nimbles
 * @package    Nimbles-Https
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Http\Request
 */
class Request extends \Nimbles\Http\Request {
    /**
     * Builds the request, used by factory
     * @return \Nimbles\Https\Request|null
     */
    /* @codeCoverageIgnoreStart */
    public static function build() {
        if ('cli' !== PHP_SAPI) {
            $request = new static();

            if (('http' === $request->getScheme)) {
                return null;
            }

            return $request;
        }

        return null;
    }
    /* @codeCoverageIgnoreEnd */
}
