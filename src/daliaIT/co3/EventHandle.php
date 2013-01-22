<?php
/*/
type:       class
author:
  name:     Oliver Anan
  mail:     <oliver@ananit.de>
version:    [0,1,0,0]
tags:       [event, hook, handle]

================================================================================
EventHandle
================================================================================
Allows binding to an event without making the event itself public.

Since a event should only be triggered by its owner it should not be
public. To allow binding to an event the object owning the event should
provide a public event handle.

Getting a handle
--------------------------------------------------------------------------------
You should not create instances of this class yourself, because there should be
only one handle per event to allow strict comparison.

To get a event handle call the events `getHandle` method.

Callbacks
--------------------------------------------------------------------------------
The callback must be a closure accepting 3 arguments. The first argument is
the event handle and the second additional event data.

    namespace daliaIT\co3;
    //getOnPluginSet returns a EventHandle
    $this->core->getOnPluginSet->bind(
        function(EventHandle $handle, PropertyChangedEventArgs $args){
            // your code here
        }
    )
    
List of  Properties:
--------------------------------------------------------------------------------
event:      Event      thius handle belongs to.

Source
--------------------------------------------------------------------------------
/*/
namespace daliaIT\co3;
class EventHandle extends Inject
{
    protected $event;
    
    function bind($callback){
        $this->event->bind($callback);
    }

    function unbind($callback){
        $this->event->unbind($callback);
    }
    
    #@get public owner
                    public function getOwner(){
                        return $this->event->getOwner();
                    }
                    #
    
    #:public
    public function getOwner
    (){
        return $this->owner
    ;
    }
    #@#
}
?>