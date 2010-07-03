<?php
namespace Mu\Cli\Opt;

/**
 * @category Mu\Cli
 * @package Mu\Cli\Opt\Collection
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Collection extends \ArrayObject {
	/**
	 * The short opts index
	 * @var array
	 */
	protected $_shortopts;

	/**
	 * The long opts index
	 * @var array
	 */
	protected $_longopts;

	/**
	 * Class construct
	 * @param array|null $opts
	 * @return void
	 */
	public function __construct(array $opts = null) {
		if (null === $opts) {
			parent::__construct();
		} else {
			parent::__construct(array_map(array('Mu\Cli\Opt', 'factory'), $opts));
		}

		$this->_shortopts = array();
		$this->_longopts = array();
	}

	/**
	 * Overrides offsetSet so that value is passed through \Mu\Cli\Opt::factory
	 * @param string|int $index
	 * @param string $value
	 */
	public function offsetSet($index, $value) {
		$value = \Mu\Cli\Opt::factory($value);

		if (null !== ($c = $value->getCharacter())) {
			$this->_shortopts[$c] = $this->count();
		}

		if (null !== ($a = $value->getAlias())) {
			$this->_longopts[$a] = $this->count();
		}

		parent::offsetSet($index, $value);
	}

	/**
	 * Gets an opt by character or alias
	 * @param string $name
	 * @return \Mu\Cli\Opt|null
	 */
	public function __get($name) {
		if ((strlen($name) === 1) && array_key_exists($name, $this->_shortopts)){
			return $this[$this->_shortopts[$name]];
		}

		if (array_key_exists($name, $this->_longopts)) {
			return $this[$this->_longopts[$name]];
		}

		return null;
	}

	/**
	 * Gets the option string
	 * @return string
	 */
	public function getOptionString() {
		return implode('', array_map(
			function($option) {
				return $option->getFormattedOpt();
			},
			$this->getArrayCopy()
		));
	}

	/**
	 * Gets the alias array
	 * @return array
	 */
	public function getAliasArray() {
		return array_map(
			function($option) {
				return $option->getFormattedAlias();
			},
			$this->getArrayCopy()
		);
	}

	/**
	 * Parse the options
	 * @return void
	 */
	public function parse() {
		if (0 === $this->count()) {
			return;
		}

		$options = getopt($this->getOptionString(), $this->getAliasArray());

		foreach ($options as $key => $value) {
			foreach ($this as &$opt) {
				if (($key === $opt->getCharacter()) || ($key === $opt->getAlias())) {
					if (false === $value) {
						$opt->isFlagged(true);
					} else if (is_string($value)) {
						$opt->setValue($value);
					}
				}
			}
		}
	}
}