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
 * @package    Nimbles-Http-Client
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Http\Client;

use Nimbles\Http\Client,
    Nimbles\Http,
    Nimbles\Http\Cookie;

/**
 * @category   Nimbles
 * @package    Nimbles-Http-Client
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Http\Request
 * @uses       \Nimbles\Http
 * @uses       \Nimbles\Http\Cookie
 */
class Response extends Http\Response {
    /**
     * Populate the request object using a raw response
     * @param srting $raw
     * @return \Nimbles\Http\Client\Response
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
                $header = explode(':', $header, 2);
                // @todo check for 2 parts
                switch (strtolower($header[0])) {
                    case 'set-cookie':
                        // @todo create method on Nimbles\Http\Cookie to create from a header
                        $cookieParts = array_reverse(array_map('trim', explode(';', $header[1])));
                        list($name, $value) = explode('=', array_pop($cookieParts));
                        $options = array (
                            'name' => $name,
                            'value' => $value
                        );

                        while (count($cookieParts) > 0) {
                            list($name, $value) = explode('=', array_pop($cookieParts));
                            $options[$name] = $value;
                        }

                        $this->setCookie(new Cookie($options));
                        break;
                    default:
                        $this->setHeader($header[0], $header[1]);
                }


            } else if (1 === preg_match('#^HTTP/[0-9.]+\s+(?<status>[0-9]{3})#', $header, $matches)) {
                $this->setStatus($matches['status']);
            }
        }
        return $this;
    }
}