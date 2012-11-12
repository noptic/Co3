<?php
namespace daliaIT\co3\IO\typeFilter;
use daliaIT\co3\IO\Filter;
class IntFilter extends Filter
{
    protected
    #>bool
        $isInFilter = true,
        $isOutFilter = true;
        #<
        
    #:string
    public function out($data){
        return (string)(int)$data;
    }
    
    #:int
    public function in($data){
        return (int) $data;
    }
}