<?php
/*/
class JSONFilter
================================================================================
 
 Ke         | Vakue
 -----------|---------------------------------
 Author     | Oliver Anan \oliver@ananit.de
 Version    | 0.1.3
 Package    | co3
 
Import export filter for Verbose Nested Hashes.

This filter turns scalar values arrays and objects into assoc arrays 
(aka hashes) and presers the original data types.

Verbose Nested Hashes can be turned into native PHP scalars arrays and onjects.

Usage
--------------------------------------------------------------------------------
This filter can  be used to preserve a values type when using untyped filters 
like YAML or JSON.

Source
--------------------------------------------------------------------------------
/*/
namespace daliaIT\co3\IO;
use Exception;
class VNHFilter extends Filter
{         
    protected
        $loader,
        $dumper;
        
    public function in($data){
        if($this->loader == null){
            throw new Exception("No vnh loader defined");
        }
        return $this->loader->load($data);
    }
    
    public function out($data){
        if($this->dumperr == null){
            throw new Exception("No vnh dumper defined");
        }
        return $this->dumper->dump($data);
    }
    
    public function getIsInFilter(){
        return $this->loader != null;
    }
    
    public function getIsOutFilter(){
        return $this->dumper != null;
    }
}
?>