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
 * @package    Nimbles-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Core\Log\Formatter;

use Nimbles\Core\Mixin\MixinAbstract,
    Nimbles\Core\Log\Entry,
    Nimbles\Core\DateTime;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\MixinAbstract
 * @uses       \Nimbles\Core\DateTime
 * @uses       \Nimbles\Core\Log\Entry
 * @uses       \Nimbles\Core\Log\Formatter\Exception\InvalidOptions
 * @uses       \Nimbles\Core\Log\Formatter\Exception\InvalidFormatterType
 */
abstract class FormatterAbstract extends MixinAbstract {
    /**
     * The log levels as array to string
     * @var array
     */
    protected $_levels = array(
        LOG_EMERG => 'EMERG',
        LOG_ALERT => 'ALERT',
        LOG_CRIT => 'CRIT',
        LOG_ERR => 'ERROR',
        LOG_WARNING => 'WARN',
        LOG_NOTICE => 'NOTICE',
        LOG_INFO => 'INFO',
        LOG_DEBUG => 'DEBUG',
    );

    /**
     * Abstract method to format the entry
     * @param \Nimbles\Core\Log\Entry $entry
     */
    abstract public function format(Entry $entry);

    /**
     * Factory method for formatters
     * @param string|array $options
     * @return \Nimbles\Core\Log\Formatter
     * @throws \Nimbles\Core\Log\Formatter\Exception\InvalidOptions
     * @throws \Nimbles\Core\Log\Formatter\Exception\InvalidFormatterType
     */
    public static function factory($options) {
        if ($options instanceof self) { // already a formatter so just return it
            return $options;
        }

        if (!(is_string($options) || is_array($options) || ($options instanceof \ArrayObject))) {
            throw new Exception\InvalidOptions('Options must be a string or array, recieved : ' . gettype($options));
        }

        if (is_string($options)) { // options is just the class name
            $type = $options;
            $options = array();
        } else if (is_array($options) || ($options instanceof \ArrayObject)) { // options is an array of name pointing to a array of options
            if ((is_array($options) && !count($options)) || (($options instanceof \ArrayObject) && !$options->count())) {
                throw new Exception\InvalidOptions('Options must not be empty');
            }

            reset($options);

            $type = key($options);
            if (is_numeric($type)) {
                throw new Exception\InvalidFormatterType('Formatter type passed into factory must be a string');
            }

            $options = current($options);
            if (!is_array($options)) {
                $options = array($options);
            }
        }

        $class = __NAMESPACE__ . '\\' . ucfirst($type);
        if (!class_exists($class)) {
            throw new Exception\InvalidFormatterType('Unknown formatter type: ' . $type);
        }

        return new $class($options);
    }

    /**
     * Gets an option formatted from an entry
     * @param \Nimbles\Core\Log\Entry $entry
     * @param string $option
     * @return null|string
     */
    public function getFormattedOption(Entry $entry, $option) {
        $value = $entry->getOption($option);

        switch ($option) {
            case 'timestamp' :
                if (!($value instanceof DateTime)) {
                    return null;
                }

                return $value->format(DateTime::ISO8601);
                break;

            case 'level' :
                if (array_key_exists($value, $this->_levels)) {
                    return $this->_levels[$value];
                }
                break;

            case 'category' :
                if (null === $value) {
                    return 'uncategorised';
                }
                break;
        }

        return $value;
    }
}
