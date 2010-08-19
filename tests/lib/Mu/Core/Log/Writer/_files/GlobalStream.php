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

namespace Tests\Lib\Mu\Core\Log\Writer;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 */
class GlobalStream {
    /**
     * Position in stream
     * @var int
     */
    protected $_pos;

    /**
     * The stream being written to
     * @var string
     */
    protected $_stream;

    /**
     * Opens the stream
     *
     * @param string $path
     * @param string $mode
     * @param int    $options
     * @param string $opened_path
     */
    public function stream_open($path, $mode, $options, &$opened_path) {
        $url = parse_url($path);
        $this->_stream = &$GLOBALS[$url["host"]];
        $this->_pos = 0;

        return is_string($this->_stream);
    }

    /**
     * Reads from the stream a set number of bytes
     *
     * @param int $count
     */
    public function stream_read($count) {
        $p =& $this->_pos;
        $ret = substr($this->_stream, $this->_pos, $count);
        $this->pos += strlen($ret);
        return $ret;
    }

    /**
     * Writes to the stream
     *
     * @param string $data
     */
    public function stream_write($data){
        $l = strlen($data);
        $this->_stream = substr($this->_stream, 0, $this->_pos) .
                        $data .
                        substr($this->_stream, $this->_pos += $l);

        return $l;
    }

    /**
     * Gets the current stream position
     * @return int
     */
    public function stream_tell() {
        return $this->_pos;
    }

    /**
     * Gets an indication if at the end of the stream
     * @return bool
     */
    public function stream_eof() {
        return $this->_pos >= strlen($this->_stream);
    }

    /**
     * Sets the stream position
     *
     * @param int $offset
     * @param int $whence starting position
     */
    public function stream_seek($offset, $whence) {
        $l = strlen($this->_stream);

        switch ($whence) {
            case SEEK_SET :
                $newPos = $offset;
                break;

            case SEEK_CUR :
                $newPos = $this->_pos + $offset;
                break;
            case SEEK_END :
                $newPos = $l + $offset;
                break;

            default :
                return false;
        }

        $ret = ($newPos >=0 && $newPos <=$l);
        if ($ret) {
            $this->pos = $newPos;
        }
        return $ret;
    }
}
