<?php
/*/
type:       class
author:
  name:     Oliver Anan
  mail:     <oliver@ananit.de>
version:    [0,1,0,0]
tags:       [helper, base, core]

================================================================================
CoreUser
================================================================================
Base class for classes which interact whith the system core. Changing a 
instances core changes the childrens core.

Cascading Core
--------------------------------------------------------------------------------
If the core is changed the core all properties which implement ICoreUser will
be changed as well.

If a property implements ICoreUser but is already uses the new core setCore will
not be called on this property to prevent infinite loops.

Source
--------------------------------------------------------------------------------
/*/
namespace daliaIT\co3;
class CoreUser extends Inject implements ICoreUser{
    protected
    #;Core    
        $core;
    
    #:Core
    public function getCore(){
        return $this->core;
    }
    
    #:this
    public function setCore(Core $core){
        $this->core = $core;
        $this->injectCore( get_object_vars($this) );
        return $this;
    }
    
    #:this
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
        return $this;
    }
}