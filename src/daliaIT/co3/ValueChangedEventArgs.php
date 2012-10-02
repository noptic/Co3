<?php
namespace daliaIT\co3;
class ValueChangedEventArgs extends Inject{
    protected
        $oldValue,
        $newValue,
        $name;
        
    public function getOldPlugin(){
        return $this->oldPlugin;
    }
    
    public function getNewPlugin(){
        return $this->newPlugin;
    }
    
    public function getName(){
        return $this->name;
    }
}
?>