<?php
/*/
 class daliaIT\co3\AppException
================================================================================
/*/
namespace daliaIT\co3\app;
use Exception;
class AppException extends Exception
{
    protected 
        $isHandled;

    public function getIsHandled(){
        return $this->isHandled;
    }
    
    public function setIsHandled($value){
        $this->isHandled = (bool) $value;
    }
}