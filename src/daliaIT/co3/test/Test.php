<?php
namespace daliaIT\co3\test;
use daliaIT\co3\CoreUser;
class Test extends CoreUser{
    protected
    #:mixed[]
        $vars  = array(),
        #<
    #:string
        $descriptio;
    
    #:string[]
    public function getVars(){
        return $this->vars;
    }
    
    #:string
    public function getDescription(){
        return $this->description;
    }
}