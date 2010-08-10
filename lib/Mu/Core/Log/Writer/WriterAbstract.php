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

namespace Mu\Core\Log\Writer;

use Mu\Core\Mixin\MixinAbstract,
    Mu\Core\Log\Formatter\FormatterAbstract,
    Mu\Core\Log\Entry;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Log\Mixin\MixinAbstract
 * @uses       \Mu\Core\Log\Filter\FilterAbstract
 * @uses       \Mu\Core\Log\Formatter\FormatterAbstract
 * @uses       \Mu\Core\Log\Entry
 */
abstract class WriterAbstract extends MixinAbstract {
    /**
     * Implements for this mixin
     * @var array
     */
    protected $_implements = array(
        'Mu\Core\Plugin\Pluginable' => array(
            'types' => array(
                'filters' => array(
                    'abstract' => 'Mu\Core\Log\Filter\FilterAbstract',
                )
            ),
        ),
        'Mu\Core\Config\Options' => array(
            'formatter' => 'simple',
            'separator' => "\n"
        )
    );

    /**
     * The formatter used by this writer
     * @var \Mu\Core\Log\Formatter
     */
    protected $_formatter;

    /**
     * Gets the formatter to be used by this writer
     * @return \Mu\Core\Log\Formatter
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
        parent::__construct();
        $this->setOptions($options);
    }

    /**
     * Method which writes the log entry
     * @param \Mu\Core\Log\Entry $entry
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
