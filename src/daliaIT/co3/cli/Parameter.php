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
        
    #@access public public [type isList description required value] string#
    
    #:string
    public function getType(){
        return $this->type;
    }
    
    #:string
    public function getIsList(){
        return $this->isList;
    }
    
    #:string
    public function getDescription(){
        return $this->description;
    }
    
    #:string
    public function getRequired(){
        return $this->required;
    }
    
    #:string
    public function getValue(){
        return $this->value;
    }
    
    #:this
    public function setType($value){
        if(! is_string($value)){
           throw new \InvalidArgumentException(
             __METHOD__ .' expects a string but got a '.gettype($value)
           );
        }
        $this->type = $value;
        return $this;
    }
    
    #:this
    public function setIsList($value){
        if(! is_string($value)){
           throw new \InvalidArgumentException(
             __METHOD__ .' expects a string but got a '.gettype($value)
           );
        }
        $this->isList = $value;
        return $this;
    }
    
    #:this
    public function setDescription($value){
        if(! is_string($value)){
           throw new \InvalidArgumentException(
             __METHOD__ .' expects a string but got a '.gettype($value)
           );
        }
        $this->description = $value;
        return $this;
    }
    
    #:this
    public function setRequired($value){
        if(! is_string($value)){
           throw new \InvalidArgumentException(
             __METHOD__ .' expects a string but got a '.gettype($value)
           );
        }
        $this->required = $value;
        return $this;
    }
    
    #:this
    public function setValue($value){
        if(! is_string($value)){
           throw new \InvalidArgumentException(
             __METHOD__ .' expects a string but got a '.gettype($value)
           );
        }
        $this->value = $value;
        return $this;
    }
    #@#
    #@access public public value#
    
    public function getValue(){
        return $this->value;
    }
    
    #:this
    public function setValue($value){
        $this->value = $value;
        return $this;
    }
    #@#
    #@access public public required bool#
    
    #:bool
    public function getRequired(){
        return $this->required;
    }
    
    #:this
    public function setRequired($value){
        if(! is_bool($value)){
           throw new \InvalidArgumentException(
             __METHOD__ .' expects a bool but got a '.gettype($value)
           );
        }
        $this->required = $value;
        return $this;
    }
    #@#
}