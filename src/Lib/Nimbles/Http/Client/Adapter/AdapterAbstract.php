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
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */
namespace Nimbles\Http\Client\Adapter;

use Nimbles\Core\Mixin\MixinAbstract,
    Nimbles\Http\Client,
    Nimbles\Http\Client\Adapter;

/**
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\MixinAbstract
 * @uses       \Nimbles\Http\Client
 * @uses       \Nimbles\Http\Client\Adapter
 *
 */
abstract class AdapterAbstract extends MixinAbstract
    implements AdapterInterface {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    protected static function _getImplements() {
        return array('Nimbles\Core\Config\Options');
    }

    /**
     * Request instance
     * @var \Nimbles\Http\Client\Request
     */
    protected $_request;

    /**
     * Client constructor
     * @param array|null $options
     */
    public function __construct($options = null) {
        $this->setOptions($options);
    }

    /**
     * Set the request
     * @param \Nimbles\Http\Client\Request $request
     */
    public function setRequest(Client\Request $request) {
        $this->_request = $request;
    }

    /**
     * Write request
     * @return \Nimbles\Http\Client\Response
     */
    /* @codeCoverageIgnoreStart */
    public function write() {}
    /* @codeCoverageIgnoreEnd */
}
