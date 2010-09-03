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
 * @package    Mu-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Log\Formatter;

use Mu\Core\Log\Entry;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Log\Formatter\FormatterAbstract
 * @uses       \Mu\Core\Config\Options
 * @uses       \Mu\Core\Log\Entry
 */
class Simple extends FormatterAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    static protected function _getImplements() {
        return array(
            'Mu\Core\Config\Options' => array(
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
     * @param \Mu\Core\Log\Entry $entry
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
