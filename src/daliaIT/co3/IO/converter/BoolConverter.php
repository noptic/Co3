<?php
/*/
class daliaIT\co3\IO\converter\BoolConverter
================================================================================

 Ke         | Vakue
 -----------|---------------------------------
 Author     | Oliver Anan \oliver@ananit.de
 Version    | 0.1
 Package    | co3

Converts values in boolean vakues and booleans intp strings.



Methods
---------------------------------------------------------------------------------
### public string toString(bool $value)
Converts a value into a string reoresentation.

If the value evalutas to true this will return 'true'
else it will return 'false'.
### public bool function fromString(string $string)
Converts a value to a boolean.

These strings will be evaluated as false_

 - 'false'
 - 'no'
 - '0' 

Anything else is cast to bool.

Source
--------------------------------------------------------------------------------
/*/
namespace daliaIT\co3\IO\converter;
use daliaIT\co3\Inject;
class BoolConverter extends Inject 
{
        protected
            #:string[] 
            $falseValues = array('false', 'no', '0'),
            #:string
            $defaultFalse = 'false',
            #:string
            $defaultTrue = 'true';
        
        #:string
        public function toString($value){
            return ($value) 
                ? $this->defaultTrue
                : $this->defaultFalse;
        }
        
        #:bool
        public function fromString($string){
            if($string === null) return false;
            foreach($this->falseValues as $value){
                if($string === $value) return false;
            }
            return (bool) $value;
        }
}