<?php
namespace daliaIT\co3\test;
use daliaIT\co3\Inject;
class ClassTest extends Test{
    protected
    #:string
        $class,
    #:MethodTest[]
        $methodTests;
    
    public function getMethodTests(){
        return $this->methodTests;
    }
    
    public function getClass(){
        return $this->class;
    }
    
}