<?php
namespace daliaIT\co3;
use Exception,
    OutOfRangeException;
class Core extends Inject
{
    public function __construct(){
        $this->onPluginSet = Event::inject(array('owner' => $this));
    }
    
    //main instance
    private static $activeInstance;
    
    public static function get(){
        return Core::$activeInstance;
    }
    public function activate(){
        Core::$activeInstance = $this;
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
            $plugin->setCore($this);
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