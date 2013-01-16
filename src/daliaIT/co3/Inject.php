<?php
namespace daliaIT\co3;
use ReflectionClass;
class  Inject implements IInject
{
    public static function inject($properties){
        $class = get_called_class();
        $args = func_get_args();
        array_shift($args);
        if($args){
            $reflect = new ReflectionClass($class); 
            $instance = $reflect->newInstanceArgs($args);
        } else {
            $instance = new $class();
        }
            
        if($properties){
            foreach( static::getInjectableProperties() as $property ){
                if( array_key_exists( $property, $properties ) ){
                    $instance->$property = $properties[$property];
                }
            }   
        }
        $instance->postInject();
        return $instance;
    }
    
    public static function injectMany($propertiesArray){
        $objects = array();
        foreach($propertiesArray as $key => $properties){
            $objects[$key] = static::inject( $properties );
        }
        return $objects;
    }
    
    public function extract(){
        $result = array();
        foreach( static::getInjectableProperties() as $property ){
            $result[$property] = $this->$property;
        }
        return $result;
    }
    
    protected static function getInjectableProperties(){
        return array_keys( get_class_vars( get_called_class() ) );
    }
    
    protected function postInject(){
        return $this;
    }
}
?>