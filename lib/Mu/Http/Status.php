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
 * @package    Mu-Http
 * @subpackage Status
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Http;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Status
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 */
class Status {
    /**
     * Informational
     */
    const STATUS_CONTINUE = 100;
    const STATUS_SWITCHING_PROTOCOLS = 101;

    /**
     * Successfull
     */
    const STATUS_OK = 200;
    const STATUS_CREATED = 201;
    const STATUS_ACCEPTED = 202;
    const STATUS_NON_AUTHORITATIVE_INFORMATION = 203;
    const STATUS_NO_CONTENT = 204;
    const STATUS_RESET_CONTENT = 205;
    const STATUS_PARTIAL_CONTENT = 206;

    /**
     * Redirectional
     */
    const STATUS_MULTIPLE_CHOICES = 300;
    const STATUS_MOVED_PERMANENTLY = 301;
    const STATUS_FOUND = 302;
    const STATUS_SEE_OTHER = 303;
    const STATUS_NOT_MODIFIED = 304;
    const STATUS_USE_PROXY = 305;
    const STATUS_SWITCH_PROXY = 306;
    const STATUS_TEMPORARY_REDIRECT = 307;

    /**
     * Client Error
     */
    const STATUS_BAD_REQUEST = 400;
    const STATUS_UNAUTHORIZED = 401;
    const STATUS_PAYMENT_REQUIRED = 402;
    const STATUS_FORBIDDEN = 403;
    const STATUS_NOT_FOUND = 404;
    const STATUS_METHOD_NOT_ALLOWED = 405;
    const STATUS_NOT_ACCEPTABLE = 406;
    const STATUS_PROXY_AUTHENTICATION_REQUIRED = 407;
    const STATUS_REQUEST_TIMEOUT = 408;
    const STATUS_CONFLICT = 409;
    const STATUS_GONE = 410;
    const STATUS_LENGTH_REQUIRED = 411;
    const STATUS_PRECONDITION_FAILED = 412;
    const STATUS_REQUEST_ENTITY_TOO_LARGE = 413;
    const STATUS_REQUEST_URI_TOO_LONG = 414;
    const STATUS_UNSUPPORTED_MEDIA_TYPE = 415;
    const STATUS_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const STATUS_EXPECTATION_FAILED = 417;

    /**
     * Server Error
     */
    const STATUS_INTERNAL_SERVER_ERROR = 500;
    const STATUS_NOT_IMPLEMENTED = 501;
    const STATUS_BAD_GATEWAY = 502;
    const STATUS_SERVICE_UNAVAILABLE = 503;
    const STATUS_GATEWAY_TIMEOUT = 504;
    const STATUS_HTTP_VERSION_NOT_SUPPORTED = 505;
    const STATUS_VARIANT_ALSO_NEGOTIATES = 506;
    const STATUS_BANDWIDTH_LIMIT_EXCEEDED = 509;
    const STATUS_NOT_EXTENDED = 510;
    const STATUS_USER_ACCESS_DENIED = 530;

    /**
     * The current http status
     * @var int
     */
    protected $_status = 200;

    /**
     * Mapping of status codes to their RFC description
     * @var array
     */
    protected $_headers = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Switch Proxy',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        509 => 'Bandwidth Limit Exceeded',
        510 => 'Not Extended',
        530 => 'User access denied',
    );

    /**
     * Gets the http status code
     * @return int
     */
    public function getStatus() {
        return $this->_status;
    }

    /**
     * Sets the http status code
     * @param int|string $status
     * @return \Mu\Http\Status
     */
    public function setStatus($status) {
        if (is_string($status) && in_array($status, $this->_headers)) {
            $headers = array_flip($this->_headers);
            $this->_status = $headers[$status];
        } else if (is_int($status) && array_key_exists($status, $this->_headers)) {
            $this->_status = $status;
        }

        return $this;
    }

    /**
     * Gets the description
     * @return string
     */
    public function getDescription() {
        return $this->_headers[$this->getStatus()];
    }

    /**
     * Indicates that the status informational
     * @return bool
     */
    public function isInformation() {
        return floor($this->_status / 100) === 1;
    }

    /**
     * Indicates that the status successful
     * @return bool
     */
    public function isSuccessful() {
        return floor($this->_status / 100) === 2;
    }

    /**
     * Indicates that the status redirection
     * @return bool
     */
    public function isRedirection() {
        return floor($this->_status / 100) === 3;
    }

    /**
     * Indicates that the status client error
     * @return bool
     */
    public function isClientError() {
        return floor($this->_status / 100) === 4;
    }

    /**
     * Indicates that the status server error
     * @return bool
     */
    public function isServerError() {
        return floor($this->_status / 100) === 4;
    }

    /**
     * Class construct
     * @param int $status
     * @return void
     */
    public function __construct($status) {
        $this->setStatus($status);
    }

    /**
     * Gets the status code as a header
     * @return string
     */
    public function __toString() {
        return sprintf('HTTP/1.1 %d %s', $this->getStatus(), $this->getDescription());
    }
}