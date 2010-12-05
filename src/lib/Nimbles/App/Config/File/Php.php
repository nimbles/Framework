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
 * @package    Nimbles-App
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\App\Config\File;

use Nimbles\App\Config,
    Nimbles\App\Config\File\Exception;

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\App\Config\File\FileAbstract
 *
 * @uses       \Nimbles\App\Config
 * @uses       \Nimbles\App\Config\File\Exception\InvalidFile
 */
class Php extends FileAbstract {
    /**
     * Parses the file
     * @param string $section
     * @return \Nimbles\App\Config
     * @throws \Nimbles\App\Config\File\Exception\InvalidFormat
     */
    public function parse($section = null) {
        $data = include $this->getFile();
        
        if ($data instanceof Config) {
            return $data;
        }
        
        if (!is_array($data)) {
            throw new Exception\InvalidFormat('Invalid file contents, must return an array or Config');
        }
        
        return $this->getSection($data, $section);
    }
}