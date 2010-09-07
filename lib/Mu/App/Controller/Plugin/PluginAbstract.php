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

namespace Mu\App\Controller\Plugin;

use Mu\App\Controller\ControllerAbstract,
    Mu\Core\Mixin\MixinAbstract;

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
 *
 * @uses       \Mu\App\Controller\ControllerAbstract
 */
abstract class PluginAbstract extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    static protected function _getImplements() {
        return array('Mu\Core\Config\Options');
    }

    /**
     * The controller which this plugin has been updated by
     * @var \Mu\App\Controller\ControllerAbstract
     */
    protected $_controller;

    /**
     * Gets the controller which this plugin has been updated by
     * @return \Mu\App\Controller\ControllerAbstract
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
     * @param \Mu\App\Controller\ControllerAbstract $controller The controller is passed in by reference
     * @return \Mu\App\Controller\Plugin\PluginAbstract
     */
    public function update(ControllerAbstract &$controller) {
        $this->_controller =& $controller;
        return $this;
    }
}