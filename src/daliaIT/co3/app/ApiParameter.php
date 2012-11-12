<?php
namespace daliaIT\co3\app;
use daliaIT\co3\Inject;
class ApiParameter extends Inject
{
    protected
    #:string
        $type;
    #:bool
        $isOptional;
    #:mixed
        $defaultValue;
    
    public function getType(){return $this->type;}
    public function getIsOptional(){return $this->isOptional;}
    public function getDefaultValue(){return $this->defaultValue;}
}