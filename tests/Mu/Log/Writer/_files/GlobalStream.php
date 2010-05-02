<?php
namespace Tests\Mu\Log\Writer;

class GlobalStream {
    private $pos;
    private $stream;
    
    public function stream_open($path, $mode, $options, &$opened_path) {
        $url = parse_url($path);
        $this->stream = &$GLOBALS[$url["host"]];
        $this->pos = 0;
        if (!is_string($this->stream)) return false;
        return true;
    }
    
    public function stream_read($count) {
        $p=&$this->pos;
        $ret = substr($this->stream, $this->pos, $count);
        $this->pos += strlen($ret);
        return $ret;
    }
    
    public function stream_write($data){
        $l=strlen($data);
        $this->stream =
            substr($this->stream, 0, $this->pos) .
            $data .
            substr($this->stream, $this->pos += $l);
        return $l;
    }
    
    public function stream_tell() {
        return $this->pos;
    }
    
    public function stream_eof() {
        return $this->pos >= strlen($this->stream);
    }
    
    public function stream_seek($offset, $whence) {
        $l=strlen($this->stream);
        switch ($whence) {
            case SEEK_SET: $newPos = $offset; break;
            case SEEK_CUR: $newPos = $this->pos + $offset; break;
            case SEEK_END: $newPos = $l + $offset; break;
            default: return false;
        }
        $ret = ($newPos >=0 && $newPos <=$l);
        if ($ret) $this->pos=$newPos;
        return $ret;
    }
}