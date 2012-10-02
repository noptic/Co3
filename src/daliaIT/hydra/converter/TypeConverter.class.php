<?php
namespace daliaIT\hydra\converter;
use daliaIT\co3\Inject;
class TypeConverter extends Inject
{
        protected
            $seperator = '.',
            $nativeSeperator = '\\';
    
        public function toString($value){
            return trim(str_replace($this->nativeSeperator, $this->seperator, $value),' \\');
        }
        
        public function fromString($string){
             return '\\'.str_replace($this->seperator, $this->nativeSeperator, $value);
        }
}
?>