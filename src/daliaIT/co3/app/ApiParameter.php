<?php
namespace daliaIT\co3\app;
use daliaIT\co3\Inject;
class ApiParameter extends Inject
{
    protected
    #:string
        $type,
    #:bool
        $isOptional,
    #:mixed
        $defaultValue;
    
    #@get public type string#
    
    #:string
    public function getType(){
        return $this->type;
    }
    #@#
    #@get public isOptional bool#
    
    #:bool
    public function getIsOptional(){
        return $this->isOptional;
    }
    #@#
    #@get public defaultValue#
    
    #:mixed
    public function getDefaultValue(){
        return $this->defaultValue;
    }
    #@#
}