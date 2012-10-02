<?php
namespace daliaIT\co3\serialization;
/*/
class PHPFilter
================================================================================
import export filter for PHPs native serialization.
/*/
class PHPFilter extends Filter
{
    public function in($string){
        return unserialize($string);
    }
    public function out($structurtedArray){
        return serialize($structurtedArray);
    }
}
?>