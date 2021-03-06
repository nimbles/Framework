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
 * @package    Nimbles-Core
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Plugin;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @trait      \Nimbles\Core\Plugin\Plugins
 */
class PluginsStandaloneMock {
    /**
     * Array of plugins
     * @var array
     */
    public $options;
    
    /**
     * Gets the config
     * @param string $type
     * @return array
     */
    public function getOption($type) {
        if ('plugins' === $type) {
            return $this->options;
        }
        
        return array();
    }
    
    /**
     * Class construct
     * @param array $plugins
     * @return void
     */
    public function __construct(array $plugins) {
        $this->options = $plugins;
    }
}