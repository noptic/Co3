<?php
namespace daliaIT\co3\IO;
/*/
class PHPFilter
================================================================================
import export filter for PHPs native serialization.
/*/
class PHPFilter extends Filter
{
    protected
    #>bool
        $isInFilter = true,
        $isOutFilter = true;
        #<
        
    public function in($data){
        return unserialize($data);
    }
    
    public function out($data){
        return serialize($data);
    }
}
?>