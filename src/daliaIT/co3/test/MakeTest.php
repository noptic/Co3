<?php
namespace daliaIT\co3\test;
use daliaIT\co3\Inject;
class InjectDummy extends Inject{
    public 
        $pub;
    
    protected
        $pro;
        
    private
        $pri;
        
    public function getPro(){
        return $this->pro;
    }
    
    public function getPri(){
        return $this->pri;
    }
}