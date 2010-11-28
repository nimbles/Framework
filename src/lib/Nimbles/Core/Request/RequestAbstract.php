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
 * @package    Nimbles-Core
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Core\Request;

use Nimbles\Core\Mixin\MixinAbstract,
    Nimbles\Core\Request,
    Nimbles\Core\Collection;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\MixinAbstract
 * @uses       \Nimbles\Core\Request\RequestInterface
 * @uses       \Nimbles\Core\Config\Options
 * @uses       \Nimbles\Core\Request\Exception\NimblesPathUndefined
 *
 * @uses       \Nimbles\Core\Collection
 *
 * @property   string $body
 * @property   \Nimbles\Core\Collection $server
 */
abstract class RequestAbstract extends MixinAbstract
    implements RequestInterface {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    protected static function _getImplements() {
        return array(
            'Nimbles\Core\Config\Options',
            'Nimbles\Core\Delegates\Delegatable' => array(
                    'delegates' => array(
                        /* @codeCoverageIgnoreStart */
                        'getServerRaw' => function() {
                            return $_SERVER;
                        },
                        /* @codeCoverageIgnoreEnd */
                    )
                )
            );
    }

    /**
     * Array of server variables
     * @var array
     */
    protected $_server;

    /**
     * Gets a server variable by its key
     * @param string|null $key
     * @return \Nimbles\Core\Collection|string|null
     */
    public function getServer($key = null) {
        if (null === $this->_server) {
            $this->_server = new Collection($this->getServerRaw(), array(
                'type' => 'string',
                'indexType' => Collection::INDEX_ASSOCITIVE,
                'readonly' => true
            ));
            $this->_server->setFlags(Collection::ARRAY_AS_PROPS);
        }

        if (null === $key) {
            return $this->_server;
        }

        return $this->_server->offsetExists($key) ? $this->_server[$key] : null;
    }

    /**
     * Abstract function for getting the request body
     */
    abstract function getBody();

    /**
     * Class construct
     * @param array|null $options
     */
    public function __construct($options = null) {
        parent::__construct();
        $this->setOptions($options);
    }

    /**
     * Magic __get to add some accesses for request context
     * @param string $name
     * @return mixed
     */
    public function __get($name) {
        if (in_array($name, array('server','body'))) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }

        return parent::__get($name);
    }

    /**
     * Factory method to build a corresponding request object
     * @return \Nimbles\Core\Request|null
     * @throws \Nimbles\Core\Request\Exception\NimblesPathUndefined
     */
    public static function factory() {
        if (!defined('NIMBLES_LIBRARY')) {
            throw new Request\Exception\NimblesPathUndefined('NIMBLES_LIBRARY constant is not defined');
        }

        $mu = dir(NIMBLES_LIBRARY);
        while ($path = $mu->read()) {
            if ('Core' === $path) {
                continue;
            }

            if (is_dir(NIMBLES_LIBRARY . '/' . $path) && class_exists(($class = 'Nimbles\\' . $path . '\\Request'))) {
                if (null !== ($request = $class::build())) {
                    return $request;
                }
            }
        }

        return null;
    }
}
