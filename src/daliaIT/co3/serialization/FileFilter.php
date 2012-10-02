<?php
namespace daliaIT\co3\serialization;
use LogicException;

class FileFilter extends Filter
{
    protected
        $sources;
        
    public function in($string){
        foreach($this->sources as $source){
            $path = "$source/$string";
            if(is_readable($path)){
                return file_get_contents($path);    
            }
        }
        
    }
    
    public function out($structurtedArray){
        throw new LogicException(__CLASS__ .' does not support output.');
    }
}