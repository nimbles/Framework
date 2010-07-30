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
 * @category  \Mu\Core
 * @package   \Mu\Core\Log\Writer\Mock
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Log\Writer;

/**
 * @category  \Mu\Core
 * @package   \Mu\Core\Log\Writer\Mock
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @version   $Id$
 *
 * @uses      \Mu\Core\Log\Writer\WriterAbstract
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
