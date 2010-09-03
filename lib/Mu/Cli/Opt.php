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
 * @category   Mu
 * @package    Mu-Cli
 * @subpackage Opt
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Cli;

use Mu\Core\Mixin\MixinAbstract;

/**
 * @category   Mu
 * @package    Mu-Cli
 * @subpackage Opt
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\MixinAbstract
 * @uses       \Mu\Core\Config\Options
 *
 * @uses       \Mu\Cli\Request\Opt\Exception\InvalidAlias
 * @uses       \Mu\Cli\Request\Opt\Exception\InvalidCharacter
 * @uses       \Mu\Cli\Request\Opt\Exception\InvalidParameterType
 * @uses       \Mu\Cli\Request\Opt\Exception\Parse
 */
class Opt extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    static protected function _getImplements() {
        return array('Mu\Core\Config\Options');
    }

    /**
     * The parameter types
     */
    const PARAM_TYPE_NOT_ACCEPTED    = 0;
    const PARAM_TYPE_REQUIRED        = 1;
    const PARAM_TYPE_OPTIONAL        = 2;

    /**
     * The option character for the command line option
     * @var string
     */
    protected $_character;

    /**
     * The alias for the command line option
     * @var string
     */
    protected $_alias;

    /**
     * The parameter type for the command line option
     * @var int
     */
    protected $_parameterType = self::PARAM_TYPE_NOT_ACCEPTED;

    /**
     * The command line option description
     * @var string
     */
    protected $_description;

    /**
     * Indicates that this option is flagged
     * @var bool
     */
    protected $_flagged;

    /**
     * The option value
     * @var string
     */
    protected $_value;

    /**
     * Gets the character for the command line option
     * @return string|null
     */
    public function getCharacter() {
        return $this->_character;
    }

    /**
     * Sets the character for the command line option
     * @param string $text
     * @return \Mu\Cli\Request\Opt
     * @throws \Mu\Cli\Request\Opt\Exception\InvalidCharacter
     */
    public function setCharacter($text) {
        if (!is_string($text) || (strlen($text) !== 1)) {
            throw new Opt\Exception\InvalidCharacter('Command line option can only be one character');
        }

        $this->_character = $text;
        return $this;
    }

    /**
     * Gets the alias for the command line option
     * @return string|null
     */
    public function getAlias() {
        return $this->_alias;
    }

    /**
     * Sets the alias for the command line option
     * @param string $text
     * @return \Mu\Cli\Request\Opt
     * @throws \Mu\Cli\Request\Opt\Exception\InvalidAlias
     */
    public function setAlias($text) {
        if (!is_string($text)) {
            throw new Opt\Exception\InvalidAlias('Alias for a command line option must be a string');
        }

        $this->_alias = $text;
        return $this;
    }

    /**
     * Gets the parameter type for the command line option
     * @return int
     */
    public function getParameterType() {
        return $this->_parameterType;
    }

    /**
     * Sets the parameter type for the command line option
     * @param int $type
     * @return \Mu\Cli\Request\Opt
     * @throws \Mu\Cli\Request\Opt\Exception\InvalidParameterType
     */
    public function setParameterType($type) {
        if (!is_int($type)) {
            throw new Opt\Exception\InvalidParameterType('Unsupported command line option type');
        }

        switch ($type) {
            case self::PARAM_TYPE_NOT_ACCEPTED :
            case self::PARAM_TYPE_OPTIONAL :
            case self::PARAM_TYPE_REQUIRED :
                break;

            default :
                throw new Opt\Exception\InvalidParameterType('Unsupported command line option type');
                break;
        }

        $this->_parameterType = $type;
        return $this;
    }

    /**
     * Gets the description of the command line option
     * @return string|null
     */
    public function getDescription() {
        return $this->_description;
    }

    /**
     * Sets th desscription of the command line option
     * @param string $description
     * @return \Mu\Cli\Request\Opt
     */
    public function setDescription($description) {
        $this->_description = is_string($description) ? $description : null;
        return $this;
    }

    /**
     * Gets/Sets if this option was flagged
     * @param bool $flagged
     * @return bool|null
     */
    public function isFlagged($flagged = null) {
        if (is_bool($flagged)) {
            $this->_flagged = $flagged;
        }
        return $this->_flagged;
    }

    /**
     * Gets the value
     * @return string
     */
    public function getValue() {
        return $this->_value;
    }

    /**
     * Sets the value
     * @param string $value
     * @return \Mu\Cli\Request\Opt
     */
    public function setValue($value) {
        $this->_value = is_string($value) ? $value : null;
        return $this;
    }

    /**
     * Class construct
     * @param array|null $options
     * @return void
     */
    public function __construct($options = null) {
        $this->setOptions($options);
    }

    /**
     * Gets a Opt object from a string
     * NOTE: To provide greater flexibility the syntax is not the same as native getopt
     * @param string|\Mu\Cli\Request\Opt $string
     * @return \Mu\Cli\Request\Opt
     * @throws \Mu\Cli\Request\Opt\Exception\Parse
     */
    static public function factory($option) {
        if ($option instanceof Opt) {
            return $option;
        }

        if (is_array($option)) {
            return new self($option);
        }

        if (!is_string($option)) {
            throw new Opt\Exception\Parse('Cannot parse, format not a string');
        }

        $options = array();
        $option = trim($option);

        preg_match(
            '/^(?P<character>[a-z0-9])?(?:(?<!\A)\|)?(?P<alias>(?<=\A|\|)[a-z0-9]+)?(?P<parameterType>:{0,2})$/i',
            $option,
            $matches
        );

        foreach ($matches as $key => $match) {
            if (!is_numeric($key)) {
                $options[$key] = $match;
            }
        }

        if (array_key_exists('character', $options) && ('' === $options['character'])) {
            unset($options['character']);
        }

        if (array_key_exists('parameterType', $options)) {
            switch ($options['parameterType']) {
                case '' :
                    $options['parameterType'] = self::PARAM_TYPE_NOT_ACCEPTED;
                    break;

                case ':' :
                    $options['parameterType'] = self::PARAM_TYPE_REQUIRED;
                    break;

                case '::' :
                    $options['parameterType'] = self::PARAM_TYPE_OPTIONAL;
                    break;
            }
        }

        return new self($options);
    }

    /**
     * Gets the option formatted
     * @return string
     */
    public function getFormattedOpt() {
        if (null == ($character = $this->getCharacter())) {
            return '';
        }

        switch ($this->getParameterType()) {
            case self::PARAM_TYPE_NOT_ACCEPTED :
                return $character;

            case self::PARAM_TYPE_OPTIONAL :
                return $character . '::';

            case self::PARAM_TYPE_REQUIRED :
                return $character . ':';
        }

        return '';
    }

    /**
     * Gets the options alias formatted
     * @return string
     */
    public function getFormattedAlias() {
        if (null == ($alias = $this->getAlias())) {
            return '';
        }

        switch ($this->getParameterType()) {
            case self::PARAM_TYPE_NOT_ACCEPTED :
                return $alias;

            case self::PARAM_TYPE_OPTIONAL :
                return $alias . '::';

            case self::PARAM_TYPE_REQUIRED :
                return $alias . ':';
        }

        return '';
    }
}
