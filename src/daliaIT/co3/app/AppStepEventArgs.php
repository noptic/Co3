<?php
namespace daliaIT\co3\app;
class AppStepEventArgs extends RunAppEventArgs{
    protected
        $step;
    
    public function getStep(){
        return $this->step();
    }
    
}
?>