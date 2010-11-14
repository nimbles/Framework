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
 * @package    Nimbles-Build
 * @subpackage Source
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Build;

/**
 * @category   Nimbles
 * @package    Nimbles-Build
 * @subpackage Source
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Build\Source
 */
class Source {
	/**
	 * The collection of files
	 * @var array
	 */
	protected $_files;
	
	/**
	 * Gets the files collection
	 * @return array
	 */
	public function getFiles() {
		return $this->_files;
	}
	
	/**
	 * Class construct
	 * @param string $directory
	 * @return void
	 */
	public function __construct($directory) {
		$files = new \RecursiveIteratorIterator(
        	new \RecursiveDirectoryIterator(
            	$directory,
            	\FilesystemIterator::UNIX_PATHS |
                	\FilesystemIterator::FOLLOW_SYMLINKS |
                	\FilesystemIterator::SKIP_DOTS 
            )
        );

        $this->_files = array();
        foreach ($files as $index => $file) {
            if ($file instanceof \SplFileInfo) {
                $this->_files[] = $file->getPathname();
            }
        }
        sort($this->_files);
	}
}