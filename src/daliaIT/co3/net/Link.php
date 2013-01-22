<?php
namespace daliaIT\co3\net;
use daliaIT\co3\Inject;
class Link extends Inject
{
    protected
    #:Url
        $url,
    #>string
        $rel,
        $type;
        
    #@access public public url Url#
    
    #:Url
    public function getUrl(){
        return $this->url;
    }
    
    #:this
    public function setUrl(Url $value){
        $this->url = $value;
        return $this;
    }
    #@#
    #@access public public [rel type] string#
    
    #:string
    public function getRel(){
        return $this->rel;
    }
    
    #:string
    public function getType(){
        return $this->type;
    }
    
    #:this
    public function setRel($value){
        if(! is_string($value)){
           throw new \InvalidArgumentException(
             __METHOD__ .' expects a string but got a '.gettype($value)
           );
        }
        $this->rel = $value;
        return $this;
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
    #@#
}