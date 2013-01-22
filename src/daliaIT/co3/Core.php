<?php
/*/
type:       class
author:
  name:     Oliver Anan
  mail:     <oliver@ananit.de>
version:    [0,1,0,0]
tags:       [system core]
================================================================================
Core
================================================================================
Handles component interaction.

The core linkks plugins but provides nearly no logic itself.

Boot
--------------------------------------------------------------------------------
After creating the core the boot script will call the boot method to initializ 
it.

The boot methoid must return the called instance.

Config
--------------------------------------------------------------------------------
The core also contains the config, a nested multi dimensional string array.
Config values can be accesed with simple path expressions:

    $this->getConfValue('encoding/yvnh') === $this->config['encoding']['yvnh'];
    
If the path is not set null is returned, so this code should work:

    if($this->getConfValue('require') ){
        foreach($this->getConfValue('require') as $require){
            require $require;
        }
    }

The path expressions are cached so you do not have to ise temp variables to
store the results.

Plugins
--------------------------------------------------------------------------------
All of co3 functionality is implemented in plugins.
Plugins should be accesibble over the magic __get method.

    $this->getPlugin('package') === $this->package();

List of Events:
--------------------------------------------------------------------------------
onPluginSet: 
  trigger:  plugin is added or replaced. 
  emits:    ValueChangedEventArgs

List of  Propertiess:
--------------------------------------------------------------------------------
onPluginSet:    Event               raised if plugin is added or replaced.
plugins:        Plugin[string]      array containing loaded plugins. 
conf:           sclalar[sclalar]    multidemensional array.

Source
--------------------------------------------------------------------------------
/*/
namespace daliaIT\co3;
use Exception,
    OutOfRangeException;
abstract class Core extends Inject
{
    protected
    #:Event    
        $onPluginSet,
    #:Plugin[string]
        $plugins = array(),
    #:array
        $conf;
        
    private
    #:scalar[scalar]
        $confCache = array();
    
    public function __construct(){
        $this->onPluginSet = Event::inject(array('owner' => $this));
    }
    
    #:this
    public function boot($config){
        $this->conf = $config; 
    }
    
    #:scalar[string]
    public function getConf(){
        return $this->conf;
    }
    
    #:scalar | scalar[string]
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
    
    #:this
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
    
    #:scalar[] | &scalar
    protected function &getConfNode(array $path){
        if(!$path){
            return;    
        }
        $next = array_shift($path);
        
    }
    #:bool
    public function pluginExists( $name ){
        return isset($this->plugins[$name]);   
    }
    
    #:Plugin
    public function getPlugin($name){
        if( $this->pluginExists( $name ) ){
            return $this->plugins[$name];
        } else {
            throw new  OutOfRangeException("Unkown Plugin '$name'");
        }
    }
    
    #:this
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
    
    #:Plugin[string]
    public function getPlugins(){
        return $this->plugins;
    }
    
    #:Plugin
    public function __get($name){
        return $this->getPlugin($name);
    }
    
    #:EventHandle
    public function getOnPluginSet(){
        return $this->onPluginSet->getHandle();
    }
    
    public function __wakeup(){
        foreach($this->plugins as $plugin){
            $plugin->setCore( $this );
        }
    }
}
?>