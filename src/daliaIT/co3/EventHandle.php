<?php
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
    
    public function getOwner(){
        return $this->event->getOwner();
    }
}
?>