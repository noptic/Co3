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
    
    #@access public public [name author license src id resource]#
    
    public function getName(){
        return $this->name;
    }
    
    public function getAuthor(){
        return $this->author;
    }
    
    public function getLicense(){
        return $this->license;
    }
    
    public function getSrc(){
        return $this->src;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getResource(){
        return $this->resource;
    }
    
    #:this
    public function setName($value){
        $this->name = $value;
        return $this;
    }
    
    #:this
    public function setAuthor($value){
        $this->author = $value;
        return $this;
    }
    
    #:this
    public function setLicense($value){
        $this->license = $value;
        return $this;
    }
    
    #:this
    public function setSrc($value){
        $this->src = $value;
        return $this;
    }
    
    #:this
    public function setId($value){
        $this->id = $value;
        return $this;
    }
    
    #:this
    public function setResource($value){
        $this->resource = $value;
        return $this;
    }
    #@#
    #@access public public includes array#
    
    #:array
    public function getIncludes(){
        return $this->includes;
    }
    
    #:this
    public function setIncludes(array $value){
        $this->includes = $value;
        return $this;
    }
    #@#
    #@access public public dependencies array#
    
    #:array
    public function getDependencies(){
        return $this->dependencies;
    }
    
    #:this
    public function setDependencies(array $value){
        $this->dependencies = $value;
        return $this;
    }
    #@#
}