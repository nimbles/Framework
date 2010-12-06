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
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\App\Config\File;

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 */
class Mock extends FileAbstract {
    public static $data = null;
    /**
     * Parses the file
     * @param string $section
     * @return \Nimbles\App\Config
     * @throws \Nimbles\App\Config\File\Exception\InvalidFormat
     */
    public function parse($section = null) {
        return is_array(static::$data) ? $this->getSection(static::$data, $section) : static::$data;
    }
}