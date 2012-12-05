<?php
/*/
class daliaIT\co3\IO\Filter implements IFilter
================================================================================

 Ke         | Vakue
 -----------|---------------------------------
 Author     | Oliver Anan \oliver@ananit.de
 Version    | 0.1.2
 Package    | co3

Base class for filters. 
*This filter can not be used to export or import data.* 

Implementation
--------------------------------------------------------------------------------
To enable importing or exporting you can override the "in" and "out" method and 
the properties $isInFilter or $isOutFilter or their getter methods.

### Example: UrlFilter

    class UrlFilter extends daliaIT\co3\IO\Filter
    {
        protected
           $isInFilter = true,
           $isOutFilter = true;
           
        public function in($data){
            return urldecode($data);
        }
        
        public function out($data){
            return urlencode($data)
        }
    }

If the behaviour of the filter may change during runtime you should
override the getter methods

### Example CallBackFilter

    class CallBackFilter extends daliaIT\co3\IO\Filter
    {
        protected
           $inCallback,
           $outCallBack;
           
        public function in($data){
            if( $this->getIsInFilter() ){
                return $this->useCallback($data, $this->inCallback);
            }    
            else{
                throw new Exception("No in callback set");
            } 
        }
        
        public function out($data){
            if( $this->getIsOutFilter() ){
                return $this->useCallback($data, $this->outCallback);
            }
            else{
                throw new Exception("No out callback set");
            } 
        }
        
        protected function useCallback($data, $callback){
            return call_user_func( $callback, $data );
        }
        
        
        public function getIsInFilter(){
            return isset($this->outCallback);
        }
        
        public function getIsInFilter(){
            return isset($this->inCallback);
        }
    }
    
With the above implementation we can use native PHP functions as filters:

    $jsonFilter = CallBackFilter::inject(array(
        'inCallback' => 'json_decode',
        'outCallback' => 'json_encode'
    ));
    
Source
--------------------------------------------------------------------------------
/*/
namespace daliaIT\co3\IO;
use daliaIT\co3\Core,
    InvalidArgumentException,
    daliaIT\co3\Component;
    
class Filter extends Component implements IFilter
{    
    protected 
    #>bool
        $isInFilter = false,
        $isOutFilter = false;
        #<
        
    public function getIsInFilter(){return $this->isInFilter;}
    public function getIsOutFilter(){return $this->isOutFilter;}
    
    
    #:mixed
    public function out($data){
        $class = get_called_class();
        throw new LogicException("$class is not an out filter.");
    }
    
    #:mixed
    public function in($data){
        $class = get_called_class();
        throw new LogicException("$class is not a in filter.");
    }
}
?>