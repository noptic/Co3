<?php
namespace daliaIT\co3\test;
use daliaIT\co3\Inject;
class MethodTest extends Test
{
    protected
        $method,
        $steps = array();
        
    public function getMethod(){
        return $this->method;
    }
    
    public function getSteps(){
        return $this->steps;
    }
}