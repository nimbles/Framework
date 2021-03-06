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
 * @subpackage Opt
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Cli\Opt;

use Nimbles\Core\ArrayObject;

/**
 * @category   Nimbles
 * @package    Nimbles-Cli
 * @subpackage Opt
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\ArrayObject
 *
 * @uses       \Nimbles\Cli\Opt
 */
class Collection extends ArrayObject {
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
        parent::__construct();

        $this->_shortopts = array();
        $this->_longopts = array();

        if (null !== $opts) {
            foreach ($opts as $opt) {
                $this[] = $opt;
            }
        }
    }

    /**
     * Overrides offsetSet so that value is passed through \Nimbles\Cli\Opt::factory, if required
     * @param string|int $index
     * @param string $value
     */
    public function offsetSet($index, $value) {
        if (null !== ($value = $this->_parseOpt($value))) {
            parent::offsetSet($index, $value);
        }
    }

    /**
     * Parsed the value and populate shortopts and longopts arrays
     * @param mixed $value
     * @return \Nimbles\Cli\Opt|null
     */
    protected function _parseOpt($value) {
        if (is_array($value) || is_string($value)) {
            $value = \Nimbles\Cli\Opt::factory($value);
        }

        if (null === $value || false === ($value instanceof \Nimbles\Cli\Opt)) {
            return null;
        }

        if (null !== ($character = $value->getCharacter())) {
            $this->_shortopts[$character] = $this->count();
        }

        if (null !== ($alias = $value->getAlias())) {
            $this->_longopts[$alias] = $this->count();
        }

        return $value;
    }

    /**
     * Gets an opt by character or alias
     * @param string $name
     * @return \Nimbles\Cli\Opt|null
     */
    public function __get($name) {
        if ((strlen($name) === 1) && array_key_exists($name, $this->_shortopts)) {
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
        return implode(
            '',
            array_map(
                function($option) {
                    return $option->getFormattedOpt();
                },
                $this->getArrayCopy()
            )
        );
    }

    /**
     * Gets the alias array
     * @return array
     */
    public function getAliasArray() {
        return array_values(
            array_filter(
                array_map(
                    function($option) {
                        return $option->getFormattedAlias();
                    },
                    $this->getArrayCopy()
                )
            )
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
