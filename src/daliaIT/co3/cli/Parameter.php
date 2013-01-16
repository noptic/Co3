<?php
namespace daliaIT\co3\cli;
use daliaIT\co3\IInject;
class Argument implements IInject{
    protected
    #>string 
        $type           = 'string',
        $isList         = false,
        $description,
        $value,
        #<
    #:bool
        $required       = true;
        
    #@get public type,isList,description,required,value#
    public function getType(){
        return $this->type;
    }
    
    public function getIsList(){
        return $this->isList;
    }
    
    public function getDescription(){
        return $this->description;
    }
    
    public function getRequired(){
        return $this->required;
    }
    
    public function getValue(){
        return $this->value;
    }
    #@#
    
    #@set public type,isList,description,required,value#
    public function setType($value){
        $this->type = $value;
        return $this;
    }
    
    public function setIsList($value){
        $this->isList = $value;
        return $this;
    }
    
    public function setDescription($value){
        $this->description = $value;
        return $this;
    }
    
    public function setRequired($value){
        $this->required = $value;
        return $this;
    }
    
    public function setValue($value){
        $this->value = $value;
        return $this;
    }
    #@#
    #---@get public type,isList,description,required@#
}