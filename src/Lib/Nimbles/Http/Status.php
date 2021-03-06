<?php
/**
 * Nimbles Framework
 *
 * LICENSE
 *
 * This shouce file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://nimbl.es/license/mit
 *
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Status
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Http;

use Nimbles\Core\Mixin\MixinAbstract;

/**
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Status
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\MixinAbstract
 * @uses       \Nimbles\Core\Delegates\Delegatable
 * @uses       \Nimbles\Core\Config\Options
 *
 * @uses       \Nimbles\Http\Status\Exception\HeadersAlreadySent
 */
class Status extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    protected static function _getImplements() {
        return array(
            'Nimbles\Core\Delegates\Delegatable' => array(
                'delegates' => array(
                    'headers_sent' => 'headers_sent',
                    'header' => 'header'
                )
            ),
            'Nimbles\Core\Config\Options' => array(
                'status' => Status::STATUS_OK
            )
        );
    }

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
     * @return \Nimbles\Http\Status
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
     * Get the class of status message
     *
     * @return int
     */
    public function getStatusClass() {
        return intval(floor($this->_status / 100));
    }

    /**
     * Indicates that the status is informational
     * @return bool
     */
    public function isInformation() {
        return (1 === $this->getStatusClass());
    }

    /**
     * Indicates that the status is successful
     * @return bool
     */
    public function isSuccessful() {
        return (2 === $this->getStatusClass());
    }

    /**
     * Indicates that the status is a redirect
     * @return bool
     */
    public function isRedirection() {
        return (3 === $this->getStatusClass());
    }

    /**
     * Indicates that the status is a client error
     * @return bool
     */
    public function isClientError() {
        return (4 === $this->getStatusClass());
    }

    /**
     * Indicates that the status is a server error
     * @return bool
     */
    public function isServerError() {
        return (5 === $this->getStatusClass());
    }

    /**
     * Class construct
     * @param array|null $options
     * @return void
     */
    public function __construct($options = null) {
        $this->setOptions($options);
    }

    /**
     * Gets the status code as a header
     * @return string
     */
    public function __toString() {
        return sprintf('HTTP/1.1 %d %s', $this->getStatus(), $this->getDescription());
    }

    /**
     * Sends the status code
     * @return void
     */
    public function send() {
        if ($this->headers_sent()) {
            throw new Status\Exception\HeadersAlreadySent('Cannot send status when headers have already been sent');
        }

        $this->header((string) $this);
    }
}
