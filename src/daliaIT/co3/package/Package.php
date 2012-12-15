<?php
namespace daliaIT\co3\package;
use daliaIT\co3\Inject;
class Package extends Inject
{
    protected 
    #>type string
        $name,
        $author,
        $license,
        $src,
        $id,
        $resource,
        #<
        
    #>type string[]
        $includes = array(),
        #<
        
    #>Dependency[]
        $dependencies;
        #<
    
    #:string
    public function geName(){ 
        return $this->name; 
    }
    
    #:string
    public function getAuthor(){ 
        return $this->author; 
    }
    
    #:string
    public function getLicense(){ 
        return $this->license; 
    }
    
    #:string 
    public function getSrc(){ 
        return $this->src; 
    }
    
    #:string
    public function getId(){
        return $this->id;
    }
    
    #:string
    public function getResource(){
        return $this->resource;
    }
    
    #:string[]
    public function getIncludes(){
        return $this->includes;
    }
    
    #:Dependency[]
    public function getDependencies(){
        return $this->dependencies;
    }
}