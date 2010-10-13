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
 */
class Mock extends WriterAbstract {
    /**
     * Array of entries
     * @var array
     */
    protected $_entries;

    /**
     * Gets the array of written entries
     * @return array
     */
    public function getEntries() {
        if (!is_array($this->_entries)) {
            $this->_entries = array();
        }

        return $this->_entries;
    }

    /**
     * Writes an entry to an array
     * @param string $entry
     * @return void
     */
    protected function _write($entry) {
        if (!is_array($this->_entries)) {
            $this->_entries = array();
        }

        $this->_entries[] = $entry;
    }
}
