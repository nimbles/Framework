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
 * @package    Mu-Http-Client
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Http\Client;

use Mu\Http\Client,
    Mu\Http;

/**
 * @category   Mu
 * @package    Mu-Http-Client
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Http\Request
 */
class Response extends Http\Response {
    /**
     * Populate the request object using a raw response
     * @param srting $raw
     * @return Response
     */
    public function setRawResponse($raw) {
        $lineEnding = (strstr(substr($raw, 0, 128), "\r\n")) ? "\r\n" : "\n";
        $headers = '';
        $body = $raw;

        $raw = explode(str_repeat($lineEnding, 2), $raw);
        if (0 < count($raw)) {
            $headers = $raw[0];
            unset($raw[0]);
            $body = implode(str_repeat($lineEnding, 2), $raw);
        }
        $this->setBody($body);

        $headers = explode($lineEnding, $headers);
        foreach ($headers as $header) {
            if (strstr($header, ': ')) {
                $header = explode(': ', $header);
                $this->setHeader($header[0], $header[1]);
            } else if (1 === preg_match('#^HTTP/[0-9.]+\s+(?<status>[0-9]{3})#', $header, $matches)) {
                $this->setStatus($matches['status']);
            }
        }
        return $this;
    }
}