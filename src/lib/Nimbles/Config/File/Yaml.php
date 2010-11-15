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
 * @subpackage File
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Config\File;

use Nimbles\Config\Config,
    Nimbles\Config\File\Exception;

/**
 * @category   Nimbles
 * @package    Nimbles-Config
 * @subpackage File
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Config\File\FileAbstract
 *
 * @uses       \Nimbles\Config\Config
 * @uses       \Nimbles\Config\File\Exception\InvalidFile
 */
class Php extends FileAbstract {
    /**
     * Parses the file
     * @return \Nimbles\Config\Config
     * @throws \Nimbles\Config\File\Exception\InvalidFormat
     */
    public function parse() {
        if (!extension_loaded('yaml')) {
            throw new Exception\InvalidFormat('Cannot parse file, yaml extension not loaded');
        }
        
        $data = yaml_parse_file($this->getFile());
        
        if (!is_array($data)) {
            throw new Exception\InvalidFormat('Invalid file contents, must result in an associtive array');
        }
        
        return new Config($data);
    }
}