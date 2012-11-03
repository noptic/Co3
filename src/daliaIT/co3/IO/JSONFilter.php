<?php
namespace daliaIT\co3\IO;
/*/
class JSONFilter
================================================================================

 Ke         | Vakue
 -----------|---------------------------------
 Author     | Oliver Anan \oliver@ananit.de
 Version    | 0.1.3
 Package    | co3
 
import export filter for JSON.

Source
--------------------------------------------------------------------------------
/*/
class JSONFilter extends Filter
{         
    protected
    #>bool
        $isInFilter = true,
        $isOutFilter = true;
        #<
        
    public function in($data){
        return json_decode( $data, true );
    }
    
    public function out($data){
        return json_encode($data);
    }
}