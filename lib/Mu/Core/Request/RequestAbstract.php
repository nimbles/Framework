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
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Request;

use Mu\Core\Mixin\MixinAbstract,
    Mu\Core\Request,
    Mu\Core\Collection;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\MixinAbstract
 * @uses       \Mu\Core\Request\RequestInterface
 * @uses       \Mu\Core\Config\Options
 * @uses       \Mu\Core\Request\Exception\MuPathUndefined
 *
 * @uses       \Mu\Core\Collection
 *
 * @property   string $body
 * @property   \Mu\Core\Collection $server
 */
abstract class RequestAbstract extends MixinAbstract
    implements RequestInterface {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    static protected function _getImplements() {
        return array(
            'Mu\Core\Config\Options',
            'Mu\Core\Delegates\Delegatable' => array(
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
     * @return \Mu\Core\Collection|string|null
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
     * @return \Mu\Core\Request|null
     * @throws \Mu\Core\Request\Exception\MuPathUndefined
     */
    static public function factory() {
        if (!defined('MU_LIBRARY')) {
            throw new Request\Exception\MuPathUndefined('MU_LIBRARY constant is not defined');
        }

        $mu = dir(MU_LIBRARY);
        while ($path = $mu->read()) {
            if ('Core' === $path) {
                continue;
            }

            if (is_dir(MU_LIBRARY . '/' . $path) && class_exists(($class = 'Mu\\' . $path . '\\Request'))) {
                if (null !== ($request = $class::build())) {
                    return $request;
                }
            }
        }

        return null;
    }
}
