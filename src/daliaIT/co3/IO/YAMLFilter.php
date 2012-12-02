<?php
/*/
author:
  name:     Oliver Anan
  mail:     <oliver@ananit.de>
version:    0.1.1.1
package:    co3

================================================================================
class YAMLFilter
================================================================================ 
import export filter for YAML

By default this filter will use indent of 2 spaces and wordwrap 80.

Inject
--------------------------------------------------------------------------------

 property    |type    |default
 ------------|--------|----------
 parser      |Spyc    |Spyc
 indent      |int     |2
 wordWrap    |int     |80

Source
--------------------------------------------------------------------------------
/*/
namespace daliaIT\co3\IO;
use Spyc;
class YAMLFilter extends Filter
{
    public
    #:Spyc
        $parser,
    #>int
        $indent = 2,
        $wordWrap = 80;
        #<
    
    public function __construct(){
        $this->parser = new Spyc();
    }
    
    public function in($string){
        return $this->parser->load($string);
    }
    
    public function out($data){
        return $this->parser->dump(
            $data, 
            $this->indent, 
            $this->wordWrap
        );
    }
    
}
?>