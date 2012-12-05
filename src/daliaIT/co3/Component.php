<?php
namespace daliaIT\co3;
class Component extends CoreUser implements IClassHasResource{
    
    public function getText($path){
        $path = str_replace('\\','/',$path);
        return $this->core->IO->in($path,'file');
    }
    
    public function formatArgs($path){
       $args = func_get_args();
        array_shift($args);
        return $this->formatArray($path, $args);
    }
    
    public function formatArray($path, array $args){
        return  vsprintf($this->getText($path), $args);
    }
}