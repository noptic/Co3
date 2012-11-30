<?php
namespace daliaIT\co3;
class CoreUser extends Inject implements ICoreUser{
    protected
        $core;
        
    public function getCore(){
        return $this->core;
    }
    
    public function setCore(Core $core){
        $this->core = $core;
        $this->injectCore( get_object_vars($this) );
    }
    
    protected function injectCore($targets){
        foreach($targets as $target){
            if(
                $target instanceof ICoreUser 
                && $target->getCore() !== $this->core
            ){
                $target->setCore($this->core);    
            }
            if(is_array($target)){
                $this->injectCore($target);
            }
        }
    }
}