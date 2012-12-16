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
use Exception;
class Component extends CoreUser implements IClassHasResource{
    
    #:string
    public function getText($path){
        if($this->core === null){
            throw new Exception('No core set.');
        }
        $path = str_replace('\\','/',$path);
        $result = $this->core->IO->file->in($path);
        if(!$result){
            throw new Exception("Could not find text: '$path'");
        }
        return $result;
    }
    
    #:string
    public function formatArgs($path){
       $args = func_get_args();
        array_shift($args);
        return $this->formatArray($path, $args);
    }
    
    #:string
    public function formatArray($path, array $args){
        if($this->core === null){
            throw new Exception('No core set.');
        }
        return  vsprintf($this->getText($path), $args);
    }
    
    #:mixed
    public function getResource($path){
        return $this->core->IO->resource->in($path);
    }
}