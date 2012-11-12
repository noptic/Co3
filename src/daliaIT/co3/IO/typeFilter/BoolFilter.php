<?php
namespace daliaIT\co3\IO\typeFilter;
use daliaIT\co3\IO\Filter;
class BoolFilter extends Filter
{
    protected
    #>bool
        $isInFilter = true,
        $isOuetFilter = true;
        #<
        
    #:string
    public function out($data){
        return ($data && $data !== 'false' && $data !== '0')? 'true':'false';
    }
    
    #:bool
    public function in($data){
        if(! $data){
            return false;
        } else {
            return strtolower((string) $data) !== 'false';
        }
    }
}