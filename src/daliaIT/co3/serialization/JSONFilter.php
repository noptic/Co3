<?php
namespace daliaIT\co3\serialization;
/*/
class JSONFilter
================================================================================
import export filter for JSON.

/*/
class JSONFilter extends Filter
{         
    public function in($string){
        return json_decode($string);
    }
    
    public function out($structurtedArray){
        return json_encode($structurtedArray);
    }
    
}
?>