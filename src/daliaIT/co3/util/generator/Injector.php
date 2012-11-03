<?php
namespace daliaIT\co3\util\generator;
class Injector
{
    protected
        $class;
        
    public function __construct($class, $groups){
        parent::__construct($groups);    
    }
    
    public function current(){
        return $this->class::inject(parent::current());
    }
    
    public function random($number = null){
        if($number == null){
            return $this->class::inject(parent::random());
        } else {
            retur parent::random($number);
        }
    }
}