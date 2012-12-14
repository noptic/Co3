<?php
namespace daliaIT\co3\test;
use daliaIT\co3\CoreUser;
class Test extends CoreUser{
    protected
    #>string[]
        $mocks      = array(),
        $constants  = array(),
        #<
    #:string
        $descriptio;
    
    #:string[]
    public function getMocks(){
        return $this->mocks;
    }
    
    #:string[]
    public function getConstants(){
        return $this->constants;
    }
    
    #:string
    public function getDescription(){
        return $this->description;
    }
}