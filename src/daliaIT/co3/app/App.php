<?php
namespace daliaIT\co3\app;
use Exception,
    daliaIT\co3\Core,
    daliaIT\co3\Inject,
    daliaIT\co3\Event;
    
class App extends Inject implements IApp
{    
    protected
    //events
        $onBoot,
        $onRun,
        $onFail,
        $onShutdown,
    //properties
        $core;
        
    public function __construct(){
        foreach(array('onBoot','onRun','onFail','onShutdown') as $name){
            $this->$name = Event::inject(
                array('owner' => $this)
            );
        }
    }
    
    //IApp
    public function boot(Core $core){
        $this->core = $core;
        $this->onBoot->trigger( AppStepEventArgs::inject(array(
                'step' => __FUNCTION__
            ))
        );
    }
    
    public function run(){
        $this->onRun->trigger( AppStepEventArgs::inject(array(
                'step' => __FUNCTION__
            ))
        );
    }
    
    public function fail(Exception $e){
        $this->onFail->trigger(AppFailEventArgs::inject(array(
                'step'      => __FUNCTION__,
                'exception' => $e
            ))
        );
    }
    
    public function shutdown(){
        $this->onShutdown->trigger(AppStepEventArgs::inject(array(
                'step' => __FUNCTION__
            ))
        );
    }    
    
    public function getCore(){
        return $this->core;    
    }
    
    public function getOnBoot(){ 
        return $this->onBoot->getHandle();
    }
    
    public function getOnRun(){ 
        return $this->onRun->getHandle();
    }
    
    public function getOnFail(){ 
        return $this->onFail->getHandle();
    }
    
    public function getOnShutdown(){ 
        return $this->onShutdown->getHandle();
    }
}
?>