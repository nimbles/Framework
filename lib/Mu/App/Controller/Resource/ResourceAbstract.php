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
 * @package    Mu-App
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\App\Controller\Resource;

use Mu\Core\Mixin\MixinAbstract;

/**
 * @category   Mu
 * @package    Mu-App
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\MixinAbstract
 * @uses       \Mu\Core\Config\Options
 */
abstract class ResourceAbstract extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    static protected function _getImplements() {
        return array('Mu\Core\Config\Options');
    }

    /**
     * The resource
     * @var object
     */
    protected $_resource;

    /**
     * Indicates that the resource has been initialized
     * @var bool
     */
    protected $_initialized = false;

    /**
     * Gets the resource
     * @return object
     */
    public function getResource() {
        if (!$this->isInitialized() && (null === $this->_resource)) {
            $this->_resource = $this->init();
            $this->isInitialized(true);
        }

        return $this->_resource;
    }

    /**
     * Indicates that the resource has been initialized
     *
     * @param bool|null $initialized
     * @return bool
     */
    public function isInitialized($initialized = null) {
        return $this->_initialized = is_bool($initialized) ? $initialized : $this->_initialized;
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
     * Magic __invoke to get the resource
     * @return object
     */
    public function __invoke() {
        return $this->getResource();
    }

    /**
     * Initializes the resource, only called upon first use of the resource
     * @return object
     */
    abstract public function init();
}