<?php
/**
 * Mu Framework
 *
 * LICENSE
 *
 * This shouce file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://mu-framework.com/license/mit
 *
 * @category  Mu\Cli
 * @package   Mu\Cli\Request
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
namespace Mu\Cli;

/**
 * @category  Mu\Cli
 * @package   Mu\Cli\Request
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
class Request extends \Mu\Core\Request\RequestAbstract {
	/**
	 * Gets the input from stdin
	 * @var string
	 */
	protected $_stdin;

	/**
	 * The command line options
	 * @var string|null
	 */
	protected $_opts;

	/**
	 * Result of getopt call
	 * @var null|array
	 */
	protected $_getoptResult;

	/**
	 * Gets the stdin
	 * @return string
	 */
	public function getStdin() {
		if (null === $this->_stdin) {
			/**
			 * Use simulated stdin from \Mu\Cli\TestCase if in test mode as php on the
			 * command line will just prompt for user input if none piped in
			 */
			if (defined('APPLICATION_ENV') && ('test' === APPLICATION_ENV)) {
				$this->_stdin = TestCase::getStdin();
			} else {
				$this->_stdin = file_get_contents(STDIN);
			}
		}
		return $this->_stdin;
	}

	/**
	 * Sets the stdin
	 * @param string|null $stdin
	 * @return \Mu\Cli\Request
	 */
	public function setStdin($stdin = null) {
		$this->_stdin = $stdin;
		return $this;
	}

	/**
	 * Gets the options to be used by getopts
	 * @return \Mu\Cli\Opt\Collection
	 */
	public function getOpts() {
		return $this->_opts;
	}

	/**
	 * Sets the command line options used by getopts
	 * @param unknown_type $opts
	 * @return $this
	 * @throws \Mu\Cli\Request\Exception\InvalidOpts
	 */
	public function setOpts($opts) {
		if (is_array($opts)) {
			$opts = new \Mu\Cli\Opt\Collection($opts);
		}

		if (!($opts instanceof \Mu\Cli\Opt\Collection)) {
			throw new Request\Exception\InvalidOpts('Opts must be an array or Mu\Cli\Opt\Collection');
		}

		$opts->parse();

		$this->_opts = $opts;
		return $this;
	}

	/**
	 * Gets an option parsed by getopts
	 * @param string $opt
	 * @return \Mu\Cli\Opt|null
	 */
	public function getOpt($opt) {
		return is_string($opt) ? $this->getOpts()->$opt : null;
	}

	/**
	 * Builds the request, used by factory
	 * @return \Mu\Cli\Request|null
	 */
	static public function build() {
		if ('cli' === PHP_SAPI) {
			return new self();
		}

		return null;
	}
}