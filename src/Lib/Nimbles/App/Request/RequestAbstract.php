<?php
namespace Nimbles\App\Request;

abstract class RequestAbstract 
    implements RequestInterface{
    /**
     * Creates an application request object based on the SAPI
     * @return \Nimbles\App\Request\RequestAsbtract
     * @todo Extend as new request types become available
     */
    public static function factory() {
        if ('cli' === PHP_SAPI) {
            
        }
        
        return Http::build();
    }
}