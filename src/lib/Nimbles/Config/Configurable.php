<?php
/**
 * Nimbles Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://Nimbles-framework.com/license/mit
 *
 * @category   Nimbles
 * @package    Nimbles-Config
 * @subpackage Configuration
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Config;

/**
 * @category   Nimbles
 * @package    Nimbles-Config
 * @subpackage Configuration
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Config\Config
 * @uses       \Nimbles\Config\Exception\InvalidInstance
 */
trait Configurable {
    /**
     * Gets the config or config value
     * @return \Nimbles\Config\Config|scalar|null
     * @throws \Nimbles\Config\Exception\InvalidInstance
     */
    public function getConfig($key = null) {
        if (!isset($this->config)) {
            $this->config = new \Nimbles\Config\Config();
        } else if (!($this->config instanceof \Nimbles\Config\Config)) {
            throw new \Nimbles\Config\Exception\InvalidInstance('config property is not an instance of Nimbles\Config\Config');
        }
        
        if ($key === null) {
            return $this->config;
        }
        
        return $this->config->offsetExists($key) ? $this->config[$key] : null;
    }
}