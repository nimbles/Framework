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
 * @subpackage PluginsStandaloneMock
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Plugin;

/**
 * @category   Nimbles
 * @package    Nimbles-Plugin
 * @subpackage PluginsStandaloneMock
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @trait \Nimbles\Plugin\Plugins
 */
class PluginsStandaloneMock {
    /**
     * Array of plugins
     * @var array
     */
    public $config;
    
    /**
     * Gets the config
     * @param string $type
     * @return array
     */
    public function getConfig($type) {
        if ('plugins' === $type) {
            return $this->config;
        }
        
        return array();
    }
    
    /**
     * Class construct
     * @param array $plugins
     * @return void
     */
    public function __construct(array $plugins) {
        $this->config = $plugins;
    }
}