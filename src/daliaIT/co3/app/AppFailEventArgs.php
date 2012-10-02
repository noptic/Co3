<?php
namespace daliaIT\co3\app;
use daliaIT\co3\Inject;
class AppFailEventArgs extends Inject{
    protected
        $exception;
    
    public function getException(){
        return $this->exception();
    }
}
?>