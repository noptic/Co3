<?php
/*/
class daliaIT\co3\IO\converter\TypeConverter
================================================================================

 Ke         | Vakue
 -----------|---------------------------------
 Author     | Oliver Anan \oliver@ananit.de
 Version    | 0.1
 Package    | co3

Converts a class/interface type from dot nottation to PHP notation
and vice versa

Methods
---------------------------------------------------------------------------------
### public string toString(bool $value)
Converts a dot notated type into a PHP type.

### public bool function fromString(string $string)
Converts a PHP type into a dot notated type.

Source
--------------------------------------------------------------------------------
/*/
namespace daliaIT\co3\IO\converter;
use daliaIT\co3\Inject;
class TypeConverter extends Inject
{
        protected
            #:string
            $seperator = '.',
            #:string
            $nativeSeperator = '\\';
    
        #:string
        public function toString($value){
            return trim(str_replace($this->nativeSeperator, $this->seperator, $value),' \\');
        }
        
        #:string
        public function fromString($string){
             return '\\'.str_replace($this->seperator, $this->nativeSeperator, $value);
        }
}
?>