<?php
namespace daliaIT\co3;
use Closure;
    
class Event extends Inject implements IEvent{
    protected 
        $callbacks = array(),
        $owner;
    
    private 
        $handle;
        
    public function bind(Closure $callback){
        $this->callbacks[] = $callback;
        return $this;
    }
    
    public function unbind(Closure $callback){
        $matches = array_keys($this->callbacks, $callback, true);
        foreach($matches as $match){
            unset( $this->callbacks[$match] );
        }
        return $this;
    }
    
    public function trigger($data=null){
        foreach($this->callbacks as $callback){
            $callback($this->getHandle(), $data);   
        }
        return $this;
    }
    
    public function getOwner(){
        return $this->owner;
    }
    
    public function getHandle(){
        if($this->handle === null){
            $this->handle = EventHandle::inject(array('event' => $this));
        }
        return $this->handle;
    }
}
?>