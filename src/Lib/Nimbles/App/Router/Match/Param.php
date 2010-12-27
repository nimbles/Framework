<?php
namespace Nimbles\App\Router\Match;

use Nimbles\App\Request\RequestAbstract;

class Param extends MatchAbstract {
    protected $_separator;
    
    public function getSeparator() {
        return $this->_separator;
    }
    
    public function setSeparator($separator) {
        $this->_separator = $separator;
        return $this;
    }
    
    public function match($value) {        
        $parts = explode($this->getSeparator(), $this->getPattern());
    }
}