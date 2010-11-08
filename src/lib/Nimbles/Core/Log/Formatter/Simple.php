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

use Nimbles\Core\Log\Entry;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Log\Formatter\FormatterAbstract
 * @uses       \Nimbles\Core\Config\Options
 * @uses       \Nimbles\Core\Log\Entry
 */
class Simple extends FormatterAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    static protected function _getImplements() {
        return array(
            'Nimbles\Core\Config\Options' => array(
                'format' => '%timestamp% %pid% %level% - %category% - %message%'
            )
        );
    }

    /**
     * Class construct
     * @param array $options
     * @return void
     */
    public function __construct(array $options = array()) {
        $this->setOptions($options);
    }

    /**
     * Formats the log entry according to the format option
     * @param \Nimbles\Core\Log\Entry $entry
     * @return string
     */
    public function format(Entry $entry) {
        $formatString = $this->getOption('format');

        preg_match_all('/%([^%]+)%/', $formatString, $matches);

        foreach ($matches[1] as $option) {
            $formattedOption = $this->getFormattedOption($entry, $option);
            $formatString = preg_replace('/%' . preg_quote($option, '/') . '%/', $formattedOption, $formatString);
        }

        return $formatString;
    }
}
