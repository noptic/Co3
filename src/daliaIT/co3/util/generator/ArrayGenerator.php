<?php
namespace daliaIT\co3\util\generator;
use Iterator,
    Countable,
    InvalidArgumentException,
    daliaIT\co3\Inject;
class ArrayGenerator extends Inject implements Iterator
{
    protected
        $groups = array();
    
    private
        $length,
        $groupLength = array(),
        $valid;
    
    
    public function __construct($groups=array()){
        foreach($groups as $group){
            if(! is_array($group)) throw new InvalidArgumentException(
                "All groups must be arrays.\nGroups: ".var_export($groups,true)
            );
        }
        $this->groups = $groups;
        $this->updateLength();
        $this->rewind();
    }
    
    public function count(){
        return $this->length;
    }
    
    public function rewind() {
        foreach($this->groups as &$group){
            reset($group);
        }
        $this->valid = (bool) $this->groups;
        return $this;
    }

    public function current() {
        $pointer = $this->position;
        $result = array();
        foreach($this->groups as $groupIndex => &$group){
            $result[$groupIndex] = current($group);
        }
        return $result;
    }

    public function key() {
        $key = '';
        foreach($this->groups as &$group){
            $key .= md5(key($group));
            $key .= " ";
        }
        return md5($key);
    }

    public function next() {
        foreach($this->groups as &$group){
            next($group);
            if(key($group) === null){
                reset($group);
                 $this->valid = false;
            } else {
                $this->valid = true;
                return;
            }
        }
        
    }

    public function valid() {
        return $this->valid;
    }
    
    public static function inject($data){
        return parent::inject($data)
            ->updateLength()
            ->rewind();      
    }
    
    public function toArray(){
        $this->rewind();
        $result = array();
        foreach($this as $key => $tup){
            $result[$key] = $tup;
        }
        return $result;
    }
    
    public function random($number=null){
        $result = array();
        if($number == null){
            foreach($this->groups as $groupIndex => $group){
                $keys = array_keys($group);
                $key = $keys[mt_rand(0,$this->groupLength[$groupIndex]-1)];
                $result[$groupIndex] = $group[$key];
            }
            return $result;    
        } else {
            for( $i=0; $i<$number; $i++){
                $result[$i] = $this->random();
            }
        }
        return $result;
    }
    
    protected function updateLength(){
        foreach($this->groups as $groupIndex => $group){
                $this->groupLength[$groupIndex] = count($group);
        }
        $this->length = array_product( $this->groupLength ); 
        return $this;
    }
    
    public function walk( $callback ){
        foreach($this as $tup){
            call_user_func_array( $callback, $tup);
        }
    }
}