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
        $isHandled,
        $app;

    public function getIsHandled(){
        return $this->isHandled;
    }
    
    public function getApp(){
        return $this->app;
    }
    
    public function setApp(IApp $app){
        $this->app = $app;
    }
    
    public function setIsHandled($value){
        $this->isHandled = (bool) $value;
    }
}