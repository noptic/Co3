<?php
namespace daliaIT\co3\app;
use Exception,
    daliaIT\co3\Core,
    daliaIT\co3\CoreUser,
    daliaIT\co3\Event;
    
class App extends CoreUser implements IApp
{    
    protected
    #>Event
        $onBoot,
        $onRun,
        $onFail,
        $onShutdown,
        #<
    #:string[]
        $requiredPackages=array();
        
    public function __construct(){
        foreach(array('onBoot','onRun','onFail','onShutdown') as $name){
            $this->$name = Event::inject(
                array('owner' => $this)
            );
        }
    }
    
    #:this
    public function boot(Core $core){
        $this->setCore($core);
        foreach($this->requiredPackages as $package){
            if(!$this->core->package->packageLoaded($package)){
                $this->core->package->in($package);
            }
        }
        $this->onBoot->trigger( AppStepEventArgs::inject(array(
                'step' => __FUNCTION__
            ))
        );
        return $this;
    }
    
    #:Package[]
    public function getRequiredPackages(){
        return $this->requiredPackages;
    }
    
    #:Plugin[]
    public function getRequiredPlugins(){
        return $this->requiredPlugins;
    }
    
    #:mixed
    public function run($args=array()){
        $this->onRun->trigger( AppStepEventArgs::inject(array(
                'step' => __FUNCTION__,
                'args' => $args
            ))
        );
    }
    
    #:mixed
    public function fail(Exception $e){
        $this->onFail->trigger(AppFailEventArgs::inject(array(
                'step'      => __FUNCTION__,
                'exception' => $e
            ))
        );
    }
    
    #:mixed
    public function shutdown(){
        $this->onShutdown->trigger(AppStepEventArgs::inject(array(
                'step' => __FUNCTION__
            ))
        );
    }    
    
    #:Core
    public function getCore(){
        return $this->core;    
    }
    
    #:EventHandle
    public function getOnBoot(){ 
        return $this->onBoot->getHandle();
    }
    
    #:EventHandle
    public function getOnRun(){ 
        return $this->onRun->getHandle();
    }
    
    #:EventHandle
    public function getOnFail(){ 
        return $this->onFail->getHandle();
    }
    
    #:EventHandle
    public function getOnShutdown(){ 
        return $this->onShutdown->getHandle();
    }
}
?>