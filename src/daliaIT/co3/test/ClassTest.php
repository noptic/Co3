<?php
namespace daliaIT\co3\test;
use daliaIT\co3\Inject;
class ClassTest extends Test{
    protected
    #:string
        $class,
    #:MethodTest[]
        $methodTests,
    #:string[]
        $mocks      = array();
    public function getMethodTests(){
        return $this->methodTests;
    }
   
    #:string[]
    public function getMocks(){
        return $this->mocks;
    }

    public function getClass(){
        return $this->class;
    }
    
}