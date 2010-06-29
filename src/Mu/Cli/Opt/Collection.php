<?php
namespace Mu\Cli\Opt;

/**
 * @category Mu\Cli
 * @package Mu\Cli\Opt\Collection
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Collection extends \ArrayObject {
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
	}

	/**
	 * Overrides offsetSet so that value is passed through \Mu\Cli\Opt::factory
	 * @param string|int $index
	 * @param string $value
	 */
	public function offsetSet($index, $value) {
		return parent::offsetSet($index, \Mu\Cli\Opt::factory($value));
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

	public function parse() {
		if (0 === $this->count()) {
			return;
		}

		/**
		 * @todo map to Opts
		 */
		$options = getopt($this->getOptionString(), $this->getAliasArray());
	}
}