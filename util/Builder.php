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
 * @subpackage Builder
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Build;

require_once 'Source.php';

/**
 * @category   Nimbles
 * @package    Nimbles-Build
 * @subpackage Builder
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Build\Source
 */
class Builder {
    /**
     * The source directory
     * @var string
     */
    protected $_source;
    
    /**
     * Path in which to search for traits
     * @var string
     */
    protected $_traitPath;
    
    /**
     * The destination directory
     * @var string
     */
    protected $_dest;
    
    /**
     * Flag if output should be quiet
     * @var bool
     */
    protected $_quiet;
    
    /**
     * Flag if traits should (true) be used or compiled (false)
     * @var bool
     */
    protected $_useTraits;
    
    /**
     * Class construct
     * @return void
     */
    public function __construct() {
        $options = function_exists('get_declared_traits') ? getopt('s:d:t:qu') : getopt('s:d:t:q'); 
        
        $this->_source = realpath(array_key_exists('s', $options) ? $options['s'] : './src');
        $this->_dest = realpath(array_key_exists('d', $options) ? $options['d'] : './build/lib');
        $this->_traitPath = realpath(array_key_exists('t', $options) ? $options['t'] : $this->_source . '/lib');
        $this->_quiet = array_key_exists('q', $options) ? true : false;
        $this->_useTraits = array_key_exists('u', $options) ? true : false;
    }
    
    /**
     * Build the project
     * @return void
     */
    public function build() {
        $source = new Source($this->_source);
        foreach ($source->getFiles() as $file) {
            $this->copyFile(str_replace($this->_source, '', $file));
        }
    }
    
    /**
     * Copies a file, adding traits if required
     * @param string $file
     * @return void
     */
    public function copyFile($file) {
        $path = $this->_dest . $file;
        if (!is_file($this->_source . $file)) {
            return;
        }
        
        if (!$this->_quiet) {
            echo 'Creating ' . $path . "\n";
        }
        
        if (!is_dir($dir = dirname($path))) {
            mkdir($dir, 0777, true);
        }
        
        if ('.php' === substr($file, -4)) {
            $contents = file_get_contents($this->_source . $file);
            if (0 !== preg_match_all('/@trait\s+(?P<trait>.*)/', $contents, $matches)) {
                foreach ($matches['trait'] as $trait) {
                    $contents = $this->_addTrait($contents, $trait);
                }    
            }
            
            if (false === strpos($contents, '@trait')) {
                file_put_contents($path, $contents);
            }
        } else {
            copy($this->_source . $file, $path);
        }
    }
    
    /**
     * Adds a trait to a file
     * @param string $contents
     * @param string $trait
     * @return string
     * @throws \Exception
     */
    protected function _addTrait($contents, $trait) {
        $traitFile = $this->_traitPath . '/' . str_replace('\\', '/', $trait) . '.php';
        if (!is_file($traitFile)) {
            throw new \Exception('Failed to import trait, ' . $traitFile . ' does not exist');
        }
        // get the class header and footer, separated by the first openning {
        list($classHeader, $classFooter) = explode('{', $contents, 2);
        
        if ($this->_useTraits) {
            $traitBody = "\n    use $trait;";
        } else {
            $traitContents = file_get_contents($traitFile);
            $traitStart = strpos($traitContents, '{');
            $traitEnd = strrpos($traitContents, '}');
            
            $traitBody = substr($traitContents, $traitStart + 1, $traitEnd - $traitStart - 2);
        }
        
        $contents = $classHeader . '{' . $traitBody . "\n" . $classFooter;
        $contents = preg_replace('/@trait\s+' . preg_quote($trait) . '/', '@uses       ' . $trait, $contents);
        
        return $contents;
    }
}