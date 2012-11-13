<?php
namespace daliaIT\co3\IO;
class FormatFilter extends Filter
{
    protected
    #>string
        $inFormat,
        $outFormat;
        #<
        
    #:bool
    public function getIsInFilter(){return $this->inFormat === null;}
    #:bool
    public function getIsOutFilter(){return $this->isOutFilter === null;}
    
    #:string
    public function in($data){
        return $this->format($this->inFormat, $data);    
    }
    
    #:string
    public function out($data){
        return $this->format($this->outFormat, $data);
    }
    
    #:string
    protected function format($format, $data){
        if( is_array($data) ){
            return vsprintf($format, $data);
        } else {
            return sprintf($format, $data);
        }
           
    }
}