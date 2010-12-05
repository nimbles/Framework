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
 * @package    Nimbles-Plugin
 * @subpackage PluginsMock
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Plugin;

/**
 * @category   Nimbles
 * @package    Nimbles-Plugin
 * @subpackage PluginsMock
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 * 
 * @trait \Nimbles\Core\Plugin\Plugins
 * @trait \Nimbles\Config\Configurable
 */
class PluginsMock {
    /**
     * Class construct
     * @param array $plugins
     * @return void
     */
    public function __construct(array $plugins) {
        $this->getConfig()->plugins = $plugins;
    }
}