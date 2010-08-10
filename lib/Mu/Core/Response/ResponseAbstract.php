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
 * @package    Mu-Core
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Response;

use Mu\Core\Mixin\MixinAbstract;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version   $Id$
 *
 * @uses      \Mu\Core\Mixin\MixinAbstract
 * @uses      \Mu\Core\Config\Options
 */
abstract class ResponseAbstract extends MixinAbstract {
    /**
     * Class implements
     * @var array
     */
    protected $_implements = array('Mu\Core\Config\Options');

    /**
     * The response body
     * @var string
     */
    protected $_body;

    /**
     * Gets the response body
     * @return string
     */
    public function getBody() {
        return $this->_body;
    }

    /**
     * Sets the response body
     * @param string $body
     * @return \Mu\Core\Response\ResponseAbstract
     */
    public function setBody($body) {
        $this->_body = is_string($body) ? $body : $this->_body;
        return $this;
    }

    /**
     * Class construct
     * @param array|null $options
     */
    public function __construct($options = null) {
        parent::__construct();
        $this->setOptions($options);
    }

    /**
     * Sends the response
     * @return void
     */
    abstract public function send();
}