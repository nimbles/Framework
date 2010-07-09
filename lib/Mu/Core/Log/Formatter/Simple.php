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
 * @package   Mu\Core\Log\Formatter\Simple
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Log\Formatter;

/**
 * @category  Mu\Core
 * @package   Mu\Core\Log\Formatter\Simple
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
class Simple extends \Mu\Core\Log\Formatter {
	/**
	 * Mixin implements
	 * @var array
	 */
	protected $_implements = array(
		'Mu\Core\Config\Options' => array(
			'format' => '%timestamp% %pid% %level% - %category% - %message%'
		)
	);

	/**
	 * Class construct
	 * @param array $options
	 * @return void
	 */
	public function __construct(array $options = array()) {
		parent::__construct();
		$this->setOptions($options);
	}

	/**
	 * Formats the log entry according to the format option
	 * @param \Mu\Core\Log\Entry $entry
	 * @return string
	 */
	public function format(\Mu\Core\Log\Entry $entry) {
		$formatString = $this->getOption('format');

		preg_match_all('/%([^%]+)%/', $formatString, $matches);

		foreach ($matches[1] as $option) {
			$formattedOption = $this->getFormattedOption($entry, $option);
			$formatString = preg_replace('/%' . preg_quote($option, '/') . '%/', $formattedOption, $formatString);
		}

		return $formatString;
	}
}