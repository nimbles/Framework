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
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */
namespace Mu\Http\Client\Adapter;

use Mu\Core\Mixin\MixinAbstract,
    Mu\Http\Client,
    Mu\Http\Client\Adapter;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\MixinAbstract
 * @uses       \Mu\Http\Client
 * @uses       \Mu\Http\Client\Adapter
 *
 */
abstract class AdapterAbstract extends MixinAbstract
    implements AdapterInterface {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    static protected function _getImplements() {
        return array('Mu\Core\Config\Options');
    }

    /**
     * Request instance
     * @var \Mu\Http\Client\Request
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
     * Set the request
     * @param \Mu\Http\Client\Request $request
     */
    public function setRequest(Client\Request $request) {
        $this->_request = $request;
    }

    /**
     * Write request
     * @return \Mu\Http\Client\Response
     */
    /* @codeCoverageIgnoreStart */
    public function write() {}
    /* @codeCoverageIgnoreEnd */
}
