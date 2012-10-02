<?php
namespace daliaIT\hydra\converter;
use daliaIT\co3\Make;
class BoolConverter extends Make 
{
        protected
            $falseValues = array('false', '', 0),
            $defaultFalse = 'false',
            $defaultTrue = 'true';
    
        public function toString($value){
            return ($value) 
                ? $this->defaultTrue
                : $this->defaultFalse;
        }
        
        public function fromString($string){
            if($string === null) return false;
            foreach($this->falseValues as $value){
                if($string === $value) return false;
            }
            return true;
        }
}