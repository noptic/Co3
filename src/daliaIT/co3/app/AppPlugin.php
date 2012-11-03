<?php
namespace daliaIT\co3\app;
use Exception,
    daliaIT\co3\Plugin,
    daliaIT\co3\Event;
    
class AppPlugin extends Plugin
{  
    protected
    #:Event
        $onRunApp,
    #:App[]
        $stack = array();

    public function __construct(){
        $this->onRunApp = new Event();
    }
    
    public function runApp(IApp $app){
        $this->stack[] = $app;
        $this->onRunApp->trigger( RunAppEventArgs::inject(array(
            'app' => $app    
        )));
        $app->boot($this->core);
        try{
            $app->run();    
        }
        catch(Exception $e){
            $appException = new AppException( '', 0, $e);
            $appException->setApp($app);
            $app->fail($appException);
            if(! $appException->getIsHandled){
                throw $e;
            }
        }
        $app->shutdown();
        array_pop($this->stack);
    }
    
    public function getOnRunApp(){ 
        return $this->onRunApp->getHandle();
    }
    
    public function getStack(){
        return $this->stack;
    }
}
?>