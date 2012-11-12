<?php
namespace daliaIT\co3\IO\typeFilter;
use daliaIT\co3\IO\Filter;
class StringFilter extends Filter
{
    protected
    #>bool
        $isInFilter = true,
        $isOuetFilter = true;
        #<
        
    #:string
    public function out($data){
        return (string)($data);
    }
    
    #:string
    public function in($data){
        return (string)($data);
    }
}