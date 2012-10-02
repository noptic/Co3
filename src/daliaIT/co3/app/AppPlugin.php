<?php
namespace daliaIT\co3\app;
use Exception,
    daliaIT\co3\Plugin,
    daliaIT\co3\Event;
    
class AppPlugin extends Plugin
{  
    protected
        $onRunApp;
        
    public function __construct(){
        $this->onRunApp = new Event();
    }
    
    public function runApp(IApp $app){
        $this->onRunApp->trigger( RunAppEventArgs::inject(array(
            'app' => $app    
        )));
        $app->boot($this->core);
        try{
            $app->run();    
        }
        catch(Exception $e){
            $pp->fail($e);
        }
        $app->shutdown();
    }
    
    public function getOnRunApp(){ 
        return $this->onRunApp->getHandle();
    }
}
?>