<?php
namespace daliaIT\co3\serialization;
use Spyc;
/*/
class YAMLFilter
================================================================================
import export filter for YAML

By default this will use the Spyc parser with and indent of 2 and wordwrap 80.
/*/
class YAMLFilter extends Filter
{
    public 
        $parser,
        $indent = 2,
        $wordWrap = 80;
        
    public function __construct(){
        $this->parser = new Spyc();
    }
    
    public function in($string){
        return $this->parser->load($string);
    }
    public function out($structurtedArray){
        return $this->parser->dump(
            $structuredArray, 
            $this->indent, 
            $this->wordWrap
        );
    }
    
}
?>