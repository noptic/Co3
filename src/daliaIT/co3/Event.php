<?php
/*/
type:       class
author:
  name:     Oliver Anan
  mail:     <oliver@ananit.de>
version:    [0,1,0,0]
tags:       [event, hook]

================================================================================
Event
================================================================================
Used to alter or augment the behavior of software components by intercepting 
function calls or messages.

The events owner usually does not expose the event itself, instead other objects
can only access a EventHandle to bind to the event.

A class implementing an event:

    //a class with a event
    namespace daliaIT\co3;
    class MySample{
        protected
        #:Event
            $onMatch,
        #:string
            $magicString;
            
        public function __construct($magicString){
            $this->magicString = $magicString;
            $this->onMatch = Event::inject(array(
                'owner' => $this
            ));
        }
        
        #:EventHandle
        public function getOnMatch(){
            //we do *NOT* return the event but the EventHandle
            return $this->onMatch->getHandle()
        }
    }

For a example how to bind to an event see EventHandle
List of  Propertiess:
--------------------------------------------------------------------------------
owner:      Object      which triggers the Event.
callbacks:  callback[]  executed if the event is triggered.

Source
--------------------------------------------------------------------------------
/*/
namespace daliaIT\co3;
use Closure;
    
class Event extends Inject implements IEvent{
    protected 
    #:callback
        $callbacks = array(),
    #:object    
        $owner;
    
    private 
    #:EventHandle    
        $handle;
    
    #:this
    public function bind(Closure $callback){
        $this->callbacks[] = $callback;
        return $this;
    }
    
    #:this
    public function unbind(Closure $callback){
        $matches = array_keys($this->callbacks, $callback, true);
        foreach($matches as $match){
            unset( $this->callbacks[$match] );
        }
        return $this;
    }
    
    #:this
    public function trigger($data=null){
        foreach($this->callbacks as $callback){
            $callback($this->getHandle(), $data);   
        }
        return $this;
    }
    
    #@get public owner#
    
    #:mixed
    public function getOwner(){
        return $this->owner;
    }
    #@#
    
    #:EventHandle
    public function getHandle(){
        if($this->handle === null){
            $this->handle = EventHandle::inject(array('event' => $this));
        }
        return $this->handle;
    }
}
?>