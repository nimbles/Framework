<?php
namespace Nimbles\App\Router\Match;

use Nimbles\App\Request\RequestAbstract;

class Exact extends MatchAbstract {
    public function match($value) {
        if ($value == $this->getPattern()) {
            return array();
        }
        
        return false;
    }
}