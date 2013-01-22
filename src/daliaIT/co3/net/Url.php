<?php
namespace daliaIT\co3\net;
use daliaIT\co3\Inject;
class Link extends Inject
{
    protected
    #>string
        $schema,
        $host,
        $path,
        $pass,
        $user,
        $fragment,
        #<
    #:strin[]
        $querry,
    #:int
        $port;

    #:string
    public function __toString(){
        $str = '';
        if( $this->schema ){ $str .= "{$this->schema}://"; }
        if( $this->user ){ $str .= $user; }
        if( isset($this->pass) ){ $str .= ":{$this->pass}"; }
        if( $this->user ){ $str.='@'; }
        if( $this->host ){ $str .= $host; }
        if( $this->path ){ $str .= $this->path; }
        if( $this->querry ){
            $str.='?';
            $chunks=array();
            foreach($this->querry as $name => $value){
                $chunks[] = ($value !== null)? "$name=$value" : $name;
            }
            $str .= implode('&',$chunks);
        }
        if( $this->fragment ){
            $str .= "#{$this->fragment}";
        }
    }
    #@access public public [schema host path pass user fragment] string#
    
    #:string
    public function getSchema(){
        return $this->schema;
    }
    
    #:string
    public function getHost(){
        return $this->host;
    }
    
    #:string
    public function getPath(){
        return $this->path;
    }
    
    #:string
    public function getPass(){
        return $this->pass;
    }
    
    #:string
    public function getUser(){
        return $this->user;
    }
    
    #:string
    public function getFragment(){
        return $this->fragment;
    }
    
    #:this
    public function setSchema($value){
        if(! is_string($value)){
           throw new \InvalidArgumentException(
             __METHOD__ .' expects a string but got a '.gettype($value)
           );
        }
        $this->schema = $value;
        return $this;
    }
    
    #:this
    public function setHost($value){
        if(! is_string($value)){
           throw new \InvalidArgumentException(
             __METHOD__ .' expects a string but got a '.gettype($value)
           );
        }
        $this->host = $value;
        return $this;
    }
    
    #:this
    public function setPath($value){
        if(! is_string($value)){
           throw new \InvalidArgumentException(
             __METHOD__ .' expects a string but got a '.gettype($value)
           );
        }
        $this->path = $value;
        return $this;
    }
    
    #:this
    public function setPass($value){
        if(! is_string($value)){
           throw new \InvalidArgumentException(
             __METHOD__ .' expects a string but got a '.gettype($value)
           );
        }
        $this->pass = $value;
        return $this;
    }
    
    #:this
    public function setUser($value){
        if(! is_string($value)){
           throw new \InvalidArgumentException(
             __METHOD__ .' expects a string but got a '.gettype($value)
           );
        }
        $this->user = $value;
        return $this;
    }
    
    #:this
    public function setFragment($value){
        if(! is_string($value)){
           throw new \InvalidArgumentException(
             __METHOD__ .' expects a string but got a '.gettype($value)
           );
        }
        $this->fragment = $value;
        return $this;
    }
    #@#
    #@access public public querry array#
    
    #:array
    public function getQuerry(){
        return $this->querry;
    }
    
    #:this
    public function setQuerry(array $value){
        $this->querry = $value;
        return $this;
    }
    #@#
    #@access public public port int#
    
    #:int
    public function getPort(){
        return $this->port;
    }
    
    #:this
    public function setPort($value){
        if(! is_int($value)){
           throw new \InvalidArgumentException(
             __METHOD__ .' expects a int but got a '.gettype($value)
           );
        }
        $this->port = $value;
        return $this;
    }
    #@#
}