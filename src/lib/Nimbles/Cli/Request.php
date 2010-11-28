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
 * @package    Nimbles-Cli
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */
namespace Nimbles\Cli;

use Nimbles\Core\Request\RequestAbstract;

/**
 * @category   Nimbles
 * @package    Nimbles-Cli
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Request\RequestAbstract
 * @uses       \Nimbles\Core\Config\Options
 * @uses       \Nimbles\Core\Delegates\Delegatable
 *
 * @uses       \Nimbles\Cli\Opt
 * @uses       \Nimbles\Cli\Opt\Collection
 * @uses       \Nimbles\Cli\Request\Exception\InvalidOpts
 */
class Request extends RequestAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    protected static function _getImplements() {
        return array_merge_recursive(
            parent::_getImplements(),
            array(
                'Nimbles\Core\Delegates\Delegatable' => array(
                    'delegates' => array(
                        /* @codeCoverageIgnoreStart */
                        'getInput' => array('\Nimbles\Cli\Request', 'getStdin')
                        /* @codeCoverageIgnoreEnd */
                    )
                )
            )
        );
    }

    /**
     * Gets the input from stdin
     * @var string
     */
    protected static $_stdin;

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
    /* @codeCoverageIgnoreStart */
    public static function getStdin() {
        if (null === self::$_stdin) {
            self::$_stdin = file_get_contents('php://stdin');
        }
        return self::$_stdin;
    }
    /* @codeCoverageIgnoreEnd */

    /**
     * Gets the options to be used by getopts
     * @return \Nimbles\Cli\Opt\Collection
     */
    public function getOpts() {
        return $this->_opts;
    }

    /**
     * Sets the command line options used by getopts
     * @param unknown_type $opts
     * @return \Nimbles\Cli\Request
     * @throws \Nimbles\Cli\Request\Exception\InvalidOpts
     */
    public function setOpts($opts) {
        if (is_array($opts)) {
            $opts = new \Nimbles\Cli\Opt\Collection($opts);
        }

        if (!($opts instanceof \Nimbles\Cli\Opt\Collection)) {
            throw new Request\Exception\InvalidOpts('Opts must be an array or \Nimbles\Cli\Opt\Collection');
        }

        $opts->parse();

        $this->_opts = $opts;
        return $this;
    }

    /**
     * Gets an option parsed by getopts
     * @param string $opt
     * @return \Nimbles\Cli\Opt|null
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
     * @return \Nimbles\Cli\Request|null
     */
    /* @codeCoverageIgnoreStart */
    public static function build() {
        if ('cli' === PHP_SAPI) {
            return new self();
        }

        return null;
    }
    /* @codeCoverageIgnoreEnd */
}
