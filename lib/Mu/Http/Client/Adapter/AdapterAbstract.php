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

use Mu\Core\Mixin\MixinAbstract,
    Mu\Http\Client\Adapter,
    Mu\Core\Request;

/**
 * @category   Mu
 * @package    Mu-Http_Client
 * @subpackage Adapter
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\MixinAbstract
 * @uses       \Mu\Core\Config\Options
 * @uses       \Mu\Http\Client\Adapter\AdapterInterface
 *
 * @todo Add a factory
 */

abstract class AdapterAbstract extends MixinAbstract implements AdapterInterface {
    /**
     * Class implements
     * @var array
     */
    protected $_implements = array(
        'Mu\Core\Config\Options'
    );

    /**
     * Request instance
     * @var RequestAbstract
     */
    protected $_request;

    /**
     * Client constructor
     * @param array|null $options
     */
    public function __construct($options = null) {
        parent::__construct();
        $this->setOptions($options);
    }

    /**
     * (non-PHPdoc)
     * @see Mu/Http/Client/Adapter/Mu\Http\Client\Adapter.AdapterInterface::setRequest()
     */
    public function setRequest(RequestAbstract $request) {
        $this->_request = $request;
    }

    /**
     * (non-PHPdoc)
     * @see Mu/Http/Client/Adapter/Mu\Http\Client\Adapter.AdapterInterface::write()
     */
    public function write() {}
}
