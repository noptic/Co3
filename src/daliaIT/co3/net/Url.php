<?php
namespace daliaIT\co3\net;
use daliaIT\co3\Inject;
class Link extends Inject
{
    protected
    #>string
        $schema,#TODO scheme
        $host,#TODO host
        $path,
        $pass,#TODO pass
        $user,
        $fragment #TODO implement
        #<
    #:strin[]
        $querry,#TODO query
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
                $chunks[] ($value !== null) "$name=$value" : $name;
            }
            $str .= implode('&',$chunks);
        }
        if( $this->fragment ){
            $str .= "#{$this->fragment}";
    public function get(){
        return $this->
    }
    
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
    
    #:string[]
    public function getQuerry(){
        return $this->querry;
    }
    
    #:int
    public function getPort(){
        return $this->port;
    }
}