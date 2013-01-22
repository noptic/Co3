<?php
namespace daliaIT\co3;
class ValueChangedEventArgs extends Inject{
    protected
        $oldValue,
        $newValue,
        $name;
        
    #@get public oldValue newValue mixed#
    
    #:newValue
    public function getOldValue(){
        return $this->oldValue;
    }
    #@#
    #@get public name string#
    
    #:string
    public function getName(){
        return $this->name;
    }
    #@#
}
?>