<?php
namespace daliaIT\co3;
class Component extends CoreUser implements IClassHasResource{
    
    public function getResource($path, $class=null, $filter='file'){
        if($class){
            $path = str_replace('\\','/',$class)."/$name";
        }
        return $this->core->IO->in($path,$filter);
    }
}