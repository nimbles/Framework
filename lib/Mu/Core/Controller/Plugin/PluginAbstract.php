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

namespace Mu\Core\Controller\Plugin;

use Mu\Core\Controller\ControllerAbstract,
    Mu\Core\Mixin\MixinAbstract;

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
 *
 * @uses       \Mu\Core\Controller\ControllerAbstract
 */
abstract class PluginAbstract extends MixinAbstract {
    /**
     * Class implements. Adds in the options mixin for future resources to
     * have their constructor arguments given in options
     * @var array
     */
    protected $_implements = array('Mu\Core\Config\Options');

    /**
     * The controller which this plugin has been updated by
     * @var \Mu\Core\Controller\ControllerAbstract
     */
    protected $_controller;

    /**
     * Gets the controller which this plugin has been updated by
     * @return \Mu\Core\Controller\ControllerAbstract
     */
    public function getController() {
        return $this->_controller;
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
     * Update the plugin
     * @param \Mu\Core\Controller\ControllerAbstract $controller The controller is passed in by reference
     * @return \Mu\Core\Controller\Plugin\PluginAbstract
     */
    public function update(ControllerAbstract &$controller) {
        $this->_controller =& $controller;
        return $this;
    }
}