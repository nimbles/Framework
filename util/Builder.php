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
require_once 'IsTraitIterator.php';

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
            $fullFilename = $this->_source . $file;
            $contents = file_get_contents($fullFilename);

            if (0 !== preg_match_all('/(abstract\s)?class\s+(?P<class>[^\s]*).*{/', $contents, $matches)) {
                for ($i = 0; $i < count($matches[0]); $i++) {
                    $startOfClass = strpos($contents, $matches[0][$i]);
                    if ('*/' === substr($contents, $startOfClass -3, 2)) {
                        $offset = 3;
                        $length = 2;
                        $phpDocBlock = substr($contents, $startOfClass - $offset, $length);
                        while (1 !== preg_match('#^/\*\*#', $phpDocBlock)) {
                            $length++;
                            $offset++;
                            $phpDocBlock = substr($contents, $startOfClass - $offset, $length);
                        }

                        if (0 !== preg_match_all('/@trait\s+(?P<trait>.*)/', $phpDocBlock, $traitMatches)) {
                            foreach ($traitMatches['trait'] as $trait) {
                                $contents = $this->_addTrait($matches[0][$i], $contents, $trait);
                            }
                        }
                    }
                }
            } else if (!$this->_useTraits && (0 !== preg_match_all('/trait\s+(?P<trait>[^\s]*).*{/', $contents, $matches))) {
                for ($i = 0; $i < count($matches[0]); $i++) {
                    $startOfTrait = strpos($contents, $matches[0][$i]);
                    $contents = substr($contents, 0, $startOfTrait);
                }
            }
            
            file_put_contents($path, $contents);
        } else {
            copy($this->_source . $file, $path);
        }
    }

    /**
     * Adds a trait to a file
     * @param string $fullFilename
     * @param string $contents
     * @param string $trait
     * @return string
     * @throws \Exception
     */
    protected function _addTrait($class, $contents, $trait) {
        $traitFile = $this->_findTrait($trait);
        if (!file_exists($traitFile)) {
            throw new \Exception('Failed to import trait, ' . $trait . ' does not exist for ' . $class);
        }
        // get the class header and footer, separated by the first openning {
        list($classHeader, $classFooter) = explode($class, $contents, 2);

        if ($this->_useTraits) {
            $traitBody = "\n    use $trait;";
        } else {
            $traitContents = file_get_contents($traitFile);
            $traitStart = strpos($traitContents, '{');
            $traitEnd = strrpos($traitContents, '}');

            $traitBody = substr($traitContents, $traitStart + 1, $traitEnd - $traitStart - 2);
        }

        $contents = $classHeader . $class . $traitBody . "\n" . $classFooter;
        return $contents;
    }
    
    /**
     * Attempts to search for the trait
     * @param string $trait
     * @return string
     */
    protected function _findTrait($trait) {
        $namespace = implode('\\', explode('\\', trim($trait, '\\'), -1));
        $traitName = substr(trim($trait, '\\'), strlen($namespace) + 1);        
        
        // try first with just the single file
        $traitFiles = new \ArrayObject(
            array($this->_traitPath . '/' . str_replace('\\', '/', $trait) . '.php')
        );
        
        $iterator = new IsTraitIteractor($traitFiles->getIterator(), $namespace, $traitName);
        
        foreach ($iterator as $file) {
            return $file;
        }
        
        $iterator = new IsTraitIteractor(
            new \RegexIterator( 
                new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator(
                        $this->_source,
                        \FilesystemIterator::UNIX_PATHS |
                            \FilesystemIterator::FOLLOW_SYMLINKS |
                            \FilesystemIterator::SKIP_DOTS 
                    )
                ),
                '/^.+\/' . preg_quote($traitName, '/') . '\.php$/i',
                \RecursiveRegexIterator::GET_MATCH
            ),
            $namespace,
            $traitName
        );

        foreach ($iterator as $file) {
            if ($file instanceof \SplFileInfo) {
                return $file->getPathname();
            }
            
            return $file[0];
        }
        
        return '';
    }
}