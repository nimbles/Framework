<?php
namespace Nimbles\Build;

require_once 'Source.php';

class Builder {
	protected $_source;
	protected $_dest;
	
	public function __construct() {
		$options = getopt('s:d:');
		$this->_source = realpath(array_key_exists('s', $options) ? $options['s'] : './src');
		$this->_dest = realpath(array_key_exists('d', $options) ? $options['d'] : './build/lib');
	}
	
	public function build() {
		$source = new Source($this->_source);
		foreach ($source->getFiles() as $file) {
			$this->copyFile(str_replace($this->_source, '', $file));
		}
	}
	
	public function copyFile($file) {
		$contents = file_get_contents($this->_source . $file);
		if (0 !== preg_match_all('/@trait\s+(?P<trait>.*)/', $contents, $matches)) {
			foreach ($matches['trait'] as $trait) {
				$contents = $this->addTrait($contents, $trait);
			}	
		}
		
		if (false === strpos($contents, 'trait')) {
			$path = $this->_dest . $file;
			echo 'Creating ' . $path . "\n";
			
			if (!is_dir($dir = dirname($path))) {
				mkdir($dir, 0777, true);
			}
			
			file_put_contents($path, $contents);
		}
	}
	
	public function addTrait($contents, $trait) {
		$traitFile = $this->_source . '/' . str_replace('\\', '/', $trait) . '.php';
		if (!is_file($traitFile)) {
			throw new \Exception('Failed to import trait, ' . $traitFile . ' does not exist');
		}
		
		$classStart = strpos($contents, '{');
		$classHeader = substr($contents, 0, $classStart + 1);
		$classFooter = substr($contents, $classStart + 1);
		
		$traitContents = file_get_contents($traitFile);		
		$traitStart = strpos($traitContents, '{');
		$traitEnd = strrpos($traitContents, '}');
		
		$traitBody = substr($traitContents, $traitStart + 1, $traitEnd - $traitStart - 2);
		
		$contents = $classHeader . $traitBody . "\n" . $classFooter;
		$contents = preg_replace('/@trait\s+' . preg_quote($trait) . '/', '@uses        ' . $trait, $contents);
		
		return $contents;
	}
}