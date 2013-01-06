<?php
namespace daliaIT\co3\IO;
class EmbedFilter extends Filter
{         
    protected
    #>bool
        $isOutFilter = true;
        #<
        
    public function out($data){
        return 'unserialize("'.addcslashes(serialize($data),"\n\r\$\"").'")';
    }
}