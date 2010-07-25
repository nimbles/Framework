<?php
/**
 * Mu Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
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
	 * Class implements
	 * @var array
	 */
	protected $_implements = array(
		'Mu\Core\Config\Options',
	    'Mu\Core\Delegates\Delegatable' => array(
	        'delegates' => array(
	            'getInput' => array('\Mu\Cli\Request', 'getStdin')
	        )
	    )
	);

    /**
     * Gets the input from stdin
     * @var string
     */
    static protected $_stdin;

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
    static public function getStdin() {
        if (null === self::$_stdin) {
            self::$_stdin = file_get_contents('php://stdin');
        }
        return self::$_stdin;
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
     * Gets the request body
     * @return string
     */
    public function getBody() {
        return $this->getInput();
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
