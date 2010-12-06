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

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Log\Writer\WriterAbstract
 * @uses       \Nimbles\Core\Log\Writer\Exception\MissingStreamOption
 */
class Stream extends WriterAbstract {
    /**
     * Stream resource
     * @var resource
     */
    protected $_stream;

    /**
     * Writes an entry to a stream
     * @param string $entry
     * @return void
     * @throws \Nimbles\Core\Log\Writer\Exception\MissingStreamOption
     */
    protected function _write($entry) {
        if (null === $this->_stream) {
            if (null === ($this->_stream = $this->getOption('stream'))) {
                throw new Exception\MissingStreamOption('Stream writer must be given a stream option to write to');
            }

            if (!is_resource($this->_stream)) {
                $this->_stream = fopen($this->_stream, 'a+');
            }
        }

        fwrite($this->_stream, $entry . $this->getOption('separator'));
    }

    /**
     * Closes the stream connection
     * @return void
     */
    public function __destruct() {
        try {
            if (is_resource($this->_stream)) {
                @fclose($this->_stream); // surpress warning for destruct
            }
        } catch (\Exception $exception) {} // desctruct cannot throw exceptions
    }
}
