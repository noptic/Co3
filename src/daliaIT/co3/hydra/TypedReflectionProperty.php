<?php
namespace daliaIT\co3\hydra;
use ReflectionProperty;
class StrictReflectionProperty extends ReflectionProperty
{
    public
        $type = null,
        $isArray = null;
        
    public function __construct($class, $property,Type $type, $isArray=false){
        parent::__construct($class, $property);
        $this->type = type;
        $this->isArray = (bool) $isArray;
    }
    
    public function getType(){
        return $this->type;
    }
    
    public function getIsArray(){
        return $this->isArray;
    }
}