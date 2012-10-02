<?php
namespace daliaIT\co3\app;
use Exception,
    daliaIT\co3\core,
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
        
    public __construct(){
        foreach(array('onBoot','onRun','onFail','omShutdown') as $name){
            $this->$name = Event::inject(
                array('owner' => $this)
            );
        }
    }
    
    //IApp
    public function boot(Core $core){
        $this->core = $core;
        $this->onBoot->trigger( AppStepEventArgs::injectarray(
                'step' => __FUNCTION__
            ))
        );
    }
    
    public function run(){
        $this->onRun->trigger( AppStepEventArgs::injectarray(
                'step' => __FUNCTION__
            ))
        );
    }
    
    public function fail(Exception $e=null){
        $this->onFail->trigger(AppFailEventArgs::injectarray(
                'step'      => __FUNCTION__,
                'exception' => $e
            ))
        );
    }
    
    public function shutdown(){
        $this->onShutdown->trigger(AppStepEventArgs::injectarray(
                'step' => __FUNCTION__
            ))
        );
    }    
    
    //event handles
    public function getOnBoot(){ 
        return $this_>onBoot->getHandle();
    }
    
    public function getOnRun(){ 
        return $this_>onRun->getHandle();
    }
    
    public function getOnFail(){ 
        return $this_>onFail->getHandle();
    }
    
    public function getOnShutdown(){ 
        return $this_>onShutdown->getHandle();
    }
}
?>