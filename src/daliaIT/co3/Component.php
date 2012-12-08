<?php
/*/
type:       class
author:
  name:     Oliver Anan
  mail:     <oliver@ananit.de>
version:    [0,0,1,0]
tags:       [system core, base, helper]
================================================================================
Component
================================================================================
Base class for co3 components like filters and plugins.

Adds some helper methods.

Source
--------------------------------------------------------------------------------
/*/
namespace daliaIT\co3;
class Component extends CoreUser implements IClassHasResource{
    
    #:string
    public function getText($path){
        $path = str_replace('\\','/',$path);
        return $this->core->IO->in($path,'file');
    }
    
    #:string
    public function formatArgs($path){
       $args = func_get_args();
        array_shift($args);
        return $this->formatArray($path, $args);
    }
    
    #:string
    public function formatArray($path, array $args){
        return  vsprintf($this->getText($path), $args);
    }
}