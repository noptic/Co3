<?php
namespace daliaIT\co3\net;
use daliaIT\co3\Inject;
class Link extends Inject
{
    protected
    #:Url
        $url;
    #>string
        $rel,
        $type;
        
    #:Url
    public function getUrl(){
        return $this->url;
    }
    
    #:string
    public function getRel(){
        return $this->rel;
    }
    
    #:string
    public function getType(){
        return $this->type;
    }
    
}