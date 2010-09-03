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
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Controller\Resource;

use Mu\Core\Mixin\MixinAbstract;

/**
 * @category   Mu
 * @package    Mu-Core
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
     * Gets the resource
     * @return object
     */
    public function getResource() {
        if (null === $this->_resource) {
            $this->_resource = $this->init();
        }

        return $this>_resource;
    }

    /**
     * Class construct
     * @param array|null $options
     * @return void
     */
    public function __construct($options = null) {
        parent::__construct();
        $this->setOptions($options);
    }

    /**
     * Initializes the resource, only called upon first use of the resource
     * @return object
     */
    abstract public function init();
}