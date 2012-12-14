<?php
namespace daliaIT\co3\test;
use daliaIT\co3\Inject;
class MethodTest extends Inject
{
    protected
        $method,
        $description,
        $args = array(),
        $steps = array(),
        $constants = array();
        
    public function getMethod(){
        return $this->method;
    }
    
    public function getDescription(){
        return $this->description;
    }
    
    public function getArgs(){
        return $this->args;
    }
    
    public function getSteps(){
        return $this->steps;
    }
    
    public function getConstants(){
        return $this->constants;
    }
}