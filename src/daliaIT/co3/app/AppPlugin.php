<?php
namespace daliaIT\co3\app;
use Exception,
    daliaIT\co3\Plugin,
    daliaIT\co3\Event,
    daliaIT\co3\util\generator\ArrayGenerator;
    
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
    
    public function in($path, $filters){
        $app = $this->IO->in($path, $filters);
        $app->boot($this->core);
        return $app;
    }
    
    public function runApp(IApp $app, $args=array()){
        $this->stack[] = $app;
        $this->onRunApp->trigger( RunAppEventArgs::inject(array(
            'app' => $app    
        )));
        $app->boot($this->core);
        try{
            $app->run($args);    
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