<?php
namespace daliaIT\co3;
class CoreUser extends Inject implements ICoreUser,IClassHasResource{
    protected
        $core;
    
    public function getResource($path, $class=null, $filter='file'){
        if($class){
            $path = str_replace('\\','/',$class)."/$name";
        }
        return $this->core->IO->in($path,$filter);
    }
    
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