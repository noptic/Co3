<?php
namespace daliaIT\co3;
use Exception,
    OutOfRangeException;
abstract class Core extends Inject
{
    protected 
        $conf; 
    private
        $confCache = array();
        
    public function __construct(){
        $this->onPluginSet = Event::inject(array('owner' => $this));
    }
    
    public abstract function boot($config);
    
    public function getConf(){
        return $this->conf;
    }
    
    public function getConfValue($path){
        if(! isset($this->confCache[$path])){
            $parts = explode('/',$path);
            $current = $this->getConf();
            foreach($parts as $index => $key){
                if(! isset($current[$key])){
                    return null;      
                }
                $current = $current[$key];
            }
            $this->confCache[$path] = $current;
        }
        return $this->confCache[$path];
    }
    
    public function setConfValue($path, $value){
        $this->confCache[$path] = $value;
        $parts = explode('/',$path);
        $current = $this->getConf();
        $leave = array_pop($parts);
        foreach($parts as $index => $key){
            if(! isset($current[$key])){
                $current[$key] = array();       
            } else {
                if(!is_array(current)){
                    throw new OutOfRangeExcedption(implode("\n",
                        "Invalid config key. ",
                        "Element is no array.",
                        "Path: $path",
                        "Key: $key",
                        "Index $index"
                    ));
                }
            }
            $current = $current[$key];
        }
        $current[$leave] = $value;
        return $this;
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
            $plugin->setCore( $this );
            $plugin->init( $name );
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