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
 * @package   Mu\Cli\Opt\Collection
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Cli\Opt;

/**
 * @category  Mu\Cli
 * @package   Mu\Cli\Opt\Collection
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
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
        parent::__construct();

        $this->_shortopts = array();
        $this->_longopts = array();

        if (null !== $opts) {
            $opts = array_map(array('\Mu\Cli\Opt', 'factory'), $opts);
            foreach ($opts as $opt) {
                $this->append($opt);
            }
        }
    }

    /**
     * Overrides append so that value the can passed through \Mu\Cli\Opt::factory, if required
     * @param mixed $value
     */
    public function append ($value) {
        if (null !== ($value = $this->_parseOpt($value))) {
            parent::append($value);
        }
    }

    /**
     * Overrides offsetSet so that value is passed through \Mu\Cli\Opt::factory, if required
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
     * @return \Mu\Cli\Opt|null
     */
    protected function _parseOpt($value) {
        if (is_array($value)) {
            $value = \Mu\Cli\Opt::factory($value);
        }

        if (null === $value || false === ($value instanceof \Mu\Cli\Opt)) {
            return null;
        }

        if (null !== ($c = $value->getCharacter())) {
            $this->_shortopts[$c] = $this->count();
        }

        if (null !== ($a = $value->getAlias())) {
            $this->_longopts[$a] = $this->count();
        }

        return $value;
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
