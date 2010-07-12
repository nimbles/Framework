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
 * @category  Mu\Core
 * @package   Mu\Core\Log\Formatter
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Log\Formatter;

/**
 * @category  Mu\Core
 * @package   Mu\Core\Log\Formatter
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
abstract class FormatterAbstract extends \Mu\Core\Mixin\MixinAbstract {
	/**
	 * Abstract method to format the entry
	 * @param Entry $entry
	 */
	abstract public function format(\Mu\Core\Log\Entry $entry);

	/**
	 * Factory method for formatters
	 * @param string|array $options
	 * @return \Mu\Core\Log\Formatter
	 * @throws \Mu\Core\Log\Formatter\Exception\InvalidFormatterType
	 */
	static public function factory($options) {
		if ($options instanceof Formatter) { // already a formatter so just return it
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
	 * @param \Mu\Core\Log\Entry $entry
	 * @param string $option
	 * @return null|string
	 */
	public function getFormattedOption(\Mu\Core\Log\Entry $entry, $option) {
		$value = $entry->getOption($option);

		switch ($option) {
			case 'timestamp' :
				if (!($value instanceof \Mu\Core\DateTime)) {
					return null;
				}

				return $value->format(\Mu\Core\DateTime::ISO8601);
				break;

			case 'level' :
				switch ($value) {
					case LOG_EMERG :
						return 'EMERG';

					case LOG_ALERT :
						return 'ALERT';

					case LOG_CRIT :
						return 'CRIT';

					case LOG_ERR :
						return 'ERROR';

					case LOG_WARNING :
						return 'WARN';

					case LOG_NOTICE :
						return 'NOTICE';

					case LOG_INFO :
						return 'INFO';

					case LOG_DEBUG :
						return 'DEBUG';
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