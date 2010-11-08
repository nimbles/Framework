<?php
namespace Nimbles\Build;

class Source {
	protected $_files;
	
	public function getFiles() {
		return $this->_files;
	}
	
	public function __construct($directory) {
		$files = new \RegexIterator(
			new \RecursiveIteratorIterator(
            	new \RecursiveDirectoryIterator(
                	$directory
                )
            ),
            '/^.+\.php$/i',
            \RecursiveRegexIterator::GET_MATCH
        );

        $this->_files = array();
        foreach ($files as $index => $file) {
            $this->_files[] = realpath($file[0]);
        }
        sort($this->_files);
	}
}