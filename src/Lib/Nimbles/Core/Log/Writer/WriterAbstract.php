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

namespace Nimbles\Core\Log\Writer;

use Nimbles\Core\Mixin\MixinAbstract,
    Nimbles\Core\Log\Formatter\FormatterAbstract,
    Nimbles\Core\Log\Entry;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Log\Mixin\MixinAbstract
 * @uses       \Nimbles\Core\Log\Filter\FilterAbstract
 * @uses       \Nimbles\Core\Log\Formatter\FormatterAbstract
 * @uses       \Nimbles\Core\Log\Entry
 */
abstract class WriterAbstract extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    protected static function _getImplements() {
        return array(
            'Nimbles\Core\Plugin\Pluginable' => array(
                'types' => array(
                    'filters' => array(
                        'abstract' => 'Nimbles\Core\Log\Filter\FilterAbstract',
                    )
                ),
            ),
            'Nimbles\Core\Config\Options' => array(
                'formatter' => 'simple',
                'separator' => "\n"
            )
        );
    }

    /**
     * The formatter used by this writer
     * @var \Nimbles\Core\Log\Formatter
     */
    protected $_formatter;

    /**
     * Gets the formatter to be used by this writer
     * @return \Nimbles\Core\Log\Formatter
     */
    public function getFormatterObject() {
        if (null === $this->_formatter) {
            $this->_formatter = FormatterAbstract::factory($this->getOption('formatter'));
        }
        return $this->_formatter;
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
     * Method which writes the log entry
     * @param \Nimbles\Core\Log\Entry $entry
     */
    public function write(Entry $entry) {
        foreach ($this->filters as $filter) {
            if ($filter->filter($entry)) { // stop if the filter removes the log entry from being written
                return;
            }
        }

        $this->_write($this->getFormatterObject()->format($entry));
    }

    /**
     * Abstract method to write the formatted entry
     * @param string $formattedEntry
     * @return bool indicates that the entry could not be written
     */
    abstract protected function _write($formattedEntry);
}
