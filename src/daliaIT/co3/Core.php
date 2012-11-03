<?php
namespace daliaIT\co3;
use Exception,
    OutOfRangeException;
abstract class Core extends Inject
{
    protected 
        $conf; 
        
    public function __construct(){
        $this->onPluginSet = Event::inject(array('owner' => $this));
    }
    
    public abstract function boot($config);
    
    public function getConf(){
        return $this->conf;
    }
    
    //plugins
    protected $plugins = array();
    public function pluginExists( $name ){
        return isset($this->plugins[$name]);   
    }
    
    public function getPlugin($name){
        if( $this->pluginExists( $name ) ){
            return $this->plugins[$name];
        } else {
            throw new  OutOfRangeException("Unkown Plugin '$name'");
        }
    }
    
    public function setPlugin($name, IPlugin $plugin){
        $old = ( isset($this->plugins[$name]) )
            ? $this->plugins[$name]
            : null;
        if($plugin !== $old){
            $this->plugins[$name] = $plugin;
            $plugin->setCore($this);
            $plugin->init();
            $this->onPluginSet->trigger(
                ValueChangedEventArgs::inject(array(
                    'oldValue'  => $old,
                    'newValue'  => $plugin,
                    'name'      => $name
                ))
            );
        }
        return $this;
    }
    
    public function getPlugins(){
        return $this->plugins;
    }
    
    public function __get($name){
        return $this->getPlugin($name);
    }
    
    //events
    protected
        $onPluginSet;
        
    public function getOnPluginSet(){
        return $this->onPluginSet->getHandle();
    }
}
?>