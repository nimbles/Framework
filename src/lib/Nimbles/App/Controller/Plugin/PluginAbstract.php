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
 * @package    Nimbles-App
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\App\Controller\Plugin;

use Nimbles\App\Controller\ControllerAbstract,
    Nimbles\Core\Mixin\MixinAbstract;

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\MixinAbstract
 * @uses       \Nimbles\Core\Config\Options
 *
 * @uses       \Nimbles\App\Controller\ControllerAbstract
 */
abstract class PluginAbstract extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    protected static function _getImplements() {
        return array('Nimbles\Core\Config\Options');
    }

    /**
     * The controller which this plugin has been updated by
     * @var \Nimbles\App\Controller\ControllerAbstract
     */
    protected $_controller;

    /**
     * Gets the controller which this plugin has been updated by
     * @return \Nimbles\App\Controller\ControllerAbstract
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
        $this->setOptions($options);
    }

    /**
     * Update the plugin
     * @param \Nimbles\App\Controller\ControllerAbstract $controller The controller is passed in by reference
     * @return \Nimbles\App\Controller\Plugin\PluginAbstract
     */
    public function update(ControllerAbstract &$controller) {
        $this->_controller =& $controller;
        return $this;
    }
}